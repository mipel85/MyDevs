<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2024 01 18
*/

class LamclubsItemFormController extends DefaultModuleController
{
	public function execute(HTTPRequestCustom $request)
	{
		$this->check_authorizations();

		$this->build_form($request);

		if ($this->submit_button->has_been_submited() && $this->form->validate())
		{
			$this->save();
			$this->redirect();
		}

		$this->view->put('CONTENT', $this->form->display());

		return $this->build_response($this->view);
	}

	private function build_form(HTTPRequestCustom $request)
	{
		$form = new HTMLForm(__CLASS__);
		$form->set_layout_title($this->get_item()->get_club_id() === null ? $this->lang['lamclubs.add'] : ($this->lang['lamclubs.edit']));

		$fieldset = new FormFieldsetHTML('lamclubs', $this->lang['form.parameters']);
		$form->add_fieldset($fieldset);

		$fieldset->add_field(new FormFieldTextEditor('name', $this->lang['form.name'], $this->get_item()->get_name(),
			array('required' => true)
		));

		$fieldset->add_field(new FormFieldNumberEditor('ffam_nb', $this->lang['lamclubs.ffam.number'], $this->get_item()->get_ffam_nb(),
			array('required' => true, 'min' => 1, 'max' => 9999)
		));

		$fieldset->add_field(new FormFieldSimpleSelectChoice('department', $this->lang['lamclubs.department'], $this->get_item()->get_department(),
            array(
                new FormFieldSelectChoiceOption('', ''),
                new FormFieldSelectChoiceOption($this->lang['lamclubs.44'], 44),
                new FormFieldSelectChoiceOption($this->lang['lamclubs.49'], 49),
                new FormFieldSelectChoiceOption($this->lang['lamclubs.53'], 53),
                new FormFieldSelectChoiceOption($this->lang['lamclubs.72'], 72),
                new FormFieldSelectChoiceOption($this->lang['lamclubs.85'], 85)
            ),
			array('required' => true)
		));

		$fieldset->add_field(new FormFieldUrlEditor('website_url', $this->lang['common.website'], $this->get_item()->get_website_url()->absolute()));

        $fieldset->add_field(new FormFieldHidden('referrer', $request->get_url_referrer()));

		$this->submit_button = new FormButtonDefaultSubmit();
		$form->add_button($this->submit_button);
		$form->add_button(new FormButtonReset());

		$this->form = $form;
	}

	private function get_item()
	{
		if ($this->item === null)
		{
			$club_id = AppContext::get_request()->get_getint('club_id', 0);
			if (!empty($club_id))
			{
				try {
					$this->item = LamclubsService::get_item($club_id);
				} catch (RowNotFoundException $e) {
					$error_controller = PHPBoostErrors::unexisting_page();
					DispatchManager::redirect($error_controller);
				}
			}
			else
			{
				$this->is_new_item = true;
				$this->item = new LamclubsItem();
			}
		}
		return $this->item;
	}

	private function check_authorizations()
	{
		$item = $this->get_item();

		if ($item->get_club_id() === null)
		{
			if (!$item->is_authorized_to_add())
			{
				$error_controller = PHPBoostErrors::user_not_authorized();
				DispatchManager::redirect($error_controller);
			}
		}
		else
		{
			if (!$item->is_authorized_to_edit())
			{
				$error_controller = PHPBoostErrors::user_not_authorized();
				DispatchManager::redirect($error_controller);
			}
		}
		if (AppContext::get_current_user()->is_readonly())
		{
			$controller = PHPBoostErrors::user_in_read_only();
			DispatchManager::redirect($controller);
		}
	}

	private function save()
	{
		$item = $this->get_item();

		$item->set_name($this->form->get_value('name'));
		$item->set_ffam_nb(sprintf("%04d", $this->form->get_value('ffam_nb')));
		$item->set_department($this->form->get_value('department')->get_raw_value());
		$item->set_website_url(new Url($this->form->get_value('website_url')));

		if ($item->get_club_id() === null)
		{
			$club_id = LamclubsService::add($item);
			$item->set_club_id($club_id);

			HooksService::execute_hook_action('add', self::$module_id, array_merge($item->get_properties(), array('item_url' => $item->get_item_url())));
		}
		else
		{
			LamclubsService::update($item);

			HooksService::execute_hook_action('edit', self::$module_id, array_merge($item->get_properties(), array('item_url' => $item->get_item_url())));
		}
	}

	private function redirect()
	{
		$item = $this->get_item();
		AppContext::get_response()->redirect(LamclubsUrlBuilder::home(), StringVars::replace_vars($this->lang['lamclubs.message.success.edit'], array('name' => $item->get_name())));
	}

	private function build_response(View $view)
	{
		$item = $this->get_item();

		$response = new SiteDisplayResponse($view);
		$graphical_environment = $response->get_graphical_environment();

		$breadcrumb = $graphical_environment->get_breadcrumb();
		$breadcrumb->add($this->lang['lamclubs.module.title'], LamclubsUrlBuilder::home());

		if ($item->get_club_id() === null)
		{
			$graphical_environment->set_page_title($this->lang['lamclubs.add']);
			$breadcrumb->add($this->lang['lamclubs.add'], LamclubsUrlBuilder::add());
			$graphical_environment->get_seo_meta_data()->set_description($this->lang['lamclubs.add'], $this->lang['lamclubs.module.title']);
			$graphical_environment->get_seo_meta_data()->set_canonical_url(LamclubsUrlBuilder::add());
		}
		else
		{
			$graphical_environment->set_page_title($this->lang['lamclubs.edit']);
			$graphical_environment->get_seo_meta_data()->set_description($this->lang['lamclubs.edit'], $this->lang['lamclubs.module.title']);
			$graphical_environment->get_seo_meta_data()->set_canonical_url(LamclubsUrlBuilder::edit($item->get_club_id()));
			$breadcrumb->add($item->get_name(), $item->get_club_id());
			$breadcrumb->add($this->lang['lamclubs.edit'], LamclubsUrlBuilder::edit($item->get_club_id()));
		}

		return $response;
	}
}
?>
