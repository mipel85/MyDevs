<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class PlanningItemController extends DefaultModuleController
{
    private $email_form;

	public function execute(HTTPRequestCustom $request)
	{
		$this->check_authorizations();

		$this->build_view();

		return $this->generate_response();
	}

	private function get_item()
	{
		if ($this->item === null)
		{
			$id = AppContext::get_request()->get_getint('id', 0);
			if (!empty($id))
			{
				try {
					$this->item = PlanningService::get_item($id);
				} catch (RowNotFoundException $e) {
					$error_controller = PHPBoostErrors::unexisting_page();
					DispatchManager::redirect($error_controller);
				}
			}
			else
				$this->item = new PlanningItem();
		}
		return $this->item;
	}

	private function build_view()
	{
		$item = $this->get_item();
        $this->build_email_form();

		$this->view->put_all(array_merge($item->get_template_vars(), array(
			'NOT_VISIBLE_MESSAGE' => MessageHelper::display($this->lang['warning.element.not.visible'], MessageHelper::WARNING),
            'EMAIL_FORM' => $this->email_form->display()
		)));

		// Email sending
		if ($this->submit_button->has_been_submited() && $this->email_form->validate())
		{
			if ($this->send_email())
			{
				$this->view->put('MESSAGE_HELPER', MessageHelper::display($this->lang['planning.message.success.email'], MessageHelper::SUCCESS));
			}
			else
				$this->view->put('MESSAGE_HELPER', MessageHelper::display($this->lang['planning.message.error.email'], MessageHelper::ERROR, 5));
		}
	}

	private function build_email_form()
	{
        $category = $this->item->get_category();
        $category_name = $category->get_id() == Category::ROOT_CATEGORY ? $this->get_item->get_activity_other() : $category->get_name();
        $club = LamclubsService::get_item($this->item->get_lamclubs_id());

		$email_form = new HTMLForm(__CLASS__);

		$fieldset = new FormFieldsetHTML('send_a_mail', $this->lang['planning.contact.author'] . ' ' . $club->get_name());
		$email_form->add_fieldset($fieldset);

		$fieldset->add_field(new FormFieldFree('title', $this->lang['planning.item.interest'], $category_name . ' ' . $this->lang['date.from.date'] . ' ' . $this->item->get_start_date()->format(Date::FORMAT_DAY_MONTH_YEAR)));

		$fieldset->add_field(new FormFieldTextEditor('sender_name', $this->lang['planning.sender.name'], AppContext::get_current_user()->get_display_name(),
			array('required' => true)
		));

		$fieldset->add_field(new FormFieldMailEditor('sender_email', $this->lang['planning.sender.email'], AppContext::get_current_user()->get_email(),
			array('required' => true)
		));

		$fieldset->add_field(new FormFieldMultiLineTextEditor('sender_message', $this->lang['planning.sender.message'], '',
			array('required' => true)
		));

		$this->submit_button = new FormButtonDefaultSubmit();
		$email_form->add_button($this->submit_button);
		$email_form->add_button(new FormButtonReset());

		$this->email_form = $email_form;
	}

	private function send_email()
	{
        $category = $this->item->get_category();
        $category_name = $category->get_id() == Category::ROOT_CATEGORY ? $this->get_activity_other() : $category->get_name();
		$item_message = '';
		$item_subject = $category_name . ' ' . $this->lang['common.from.date'] . ' ' .  $this->item->get_start_date()->format(Date::FORMAT_DAY_MONTH_YEAR);
		$item_sender_name = $this->email_form->get_value('sender_name');
		$item_sender_email = $this->email_form->get_value('sender_email');
		$item_message = $this->email_form->get_value('sender_message');
		$item_recipient_email = $this->item->get_email();

		$item_email = new Mail();
		$item_email->set_sender(MailServiceConfig::load()->get_default_mail_sender(), $this->lang['planning.module.title']);
		$item_email->set_reply_to($item_sender_email, $item_sender_name);
		$item_email->set_subject($item_subject);
		$item_email->set_content(TextHelper::html_entity_decode($item_message));
		$item_email->add_recipient($item_recipient_email);

		$send_email = AppContext::get_mail_service();

		return $send_email->try_to_send($item_email);
	}

	private function check_authorizations()
	{
		$item = $this->get_item();

		if (!$item->is_approved())
		{
			$current_user = AppContext::get_current_user();
			if ((!CategoriesAuthorizationsService::check_authorizations($item->get_id_category())->moderation() && !CategoriesAuthorizationsService::check_authorizations($item->get_id_category())->write() && (!CategoriesAuthorizationsService::check_authorizations($item->get_id_category())->contribution() || $item->get_author_user()->get_id() != $current_user->get_id())) || ($current_user->get_id() == User::VISITOR_LEVEL))
			{
				$error_controller = PHPBoostErrors::user_not_authorized();
				DispatchManager::redirect($error_controller);
			}
		}
		else
		{
			if (!CategoriesAuthorizationsService::check_authorizations($item->get_id_category())->read())
			{
				$error_controller = PHPBoostErrors::user_not_authorized();
				DispatchManager::redirect($error_controller);
			}
		}
	}

	/**
	 * {@inheritdoc}
	 */
	protected function get_template_to_use()
	{
		return new FileTemplate('planning/PlanningItemController.tpl');
	}

	private function generate_response()
	{
		$item = $this->get_item();
		$category = $item->get_category();
		$response = new SiteDisplayResponse($this->view);
		$graphical_environment = $response->get_graphical_environment();
		$graphical_environment->set_page_title($category->get_name(), ($category->get_id() != Category::ROOT_CATEGORY ? $category->get_name() . ' - ' : '') . $this->lang['planning.module.title']);
		$graphical_environment->get_seo_meta_data()->set_description($item->get_content());
		$graphical_environment->get_seo_meta_data()->set_canonical_url(PlanningUrlBuilder::display($category->get_id(), $category->get_rewrited_name(), $item->get_id(), $item->get_rewrited_link()));

		$breadcrumb = $graphical_environment->get_breadcrumb();
		$breadcrumb->add($this->lang['planning.module.title'], PlanningUrlBuilder::home());

		$categories = array_reverse(CategoriesService::get_categories_manager('planning')->get_parents($item->get_id_category(), true));
		foreach ($categories as $id => $category)
		{
			if ($category->get_id() != Category::ROOT_CATEGORY)
				$breadcrumb->add($category->get_name(), PlanningUrlBuilder::home());
		}
		$breadcrumb->add($this->lang['common.see.details']);

		return $response;
	}
}
?>
