<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class PlanningItemFormController extends DefaultModuleController
{
	public function execute(HTTPRequestCustom $request)
	{
		$this->check_authorizations();

		$this->build_form($request);

		if ($this->submit_button->has_been_submited() && $this->form->validate())
		{
			$this->form->get_field_by_id('activity_other')->set_hidden($this->get_item()->get_id_category() != Category::ROOT_CATEGORY);
			$this->save();
			$this->redirect();
		}

        $this->view->put_all(array(
            'CONTENT' => $this->form->display(),
			'OPTIONS'  => self::build_options(),
        ));

		return $this->generate_response($this->view);
	}

	private function build_form(HTTPRequestCustom $request)
	{
		$item = $this->get_item();

		$form = new HTMLForm(__CLASS__);
		$form->set_layout_title($item->get_id() === null ? $this->lang['planning.item.add'] : $this->lang['planning.item.edit']);

		$fieldset = new FormFieldsetHTML('event', $this->lang['form.parameters']);
		$form->add_fieldset($fieldset);

		if (CategoriesService::get_categories_manager()->get_categories_cache()->has_categories())
		{
			$search_category_children_options = new SearchCategoryChildrensOptions();
			$search_category_children_options->add_authorizations_bits(Category::CONTRIBUTION_AUTHORIZATIONS);
			$search_category_children_options->add_authorizations_bits(Category::WRITE_AUTHORIZATIONS);
			$fieldset->add_field(CategoriesService::get_categories_manager()->get_select_categories_form_field('id_category', $this->lang['planning.activity'], $item->get_id_category(), $search_category_children_options,
                array(
                    'description' => $this->lang['planning.activity.clue'],
                    'events' => array('change' => '
                        if (HTMLForms.getField("id_category").getValue() == ' . Category::ROOT_CATEGORY . ') {
                            HTMLForms.getField("activity_other").enable();
                        } else {
                            HTMLForms.getField("activity_other").disable();
                        }'
                    )
                )
            ));
		}

		$fieldset->add_field(new FormFieldTextEditor('activity_other', $this->lang['planning.activity.other'], '',
			array(
                'required' => true,
                'hidden' => $item->get_id_category() != Category::ROOT_CATEGORY
            )
		));

		$fieldset->add_field(new FormFieldSimpleSelectChoice('club_infos', $this->lang['planning.club.infos'], $this->get_item()->get_lamclubs_id(), LamclubsService::get_options_list(), array('required' => true)));

        $fieldset->add_field($start_date = new FormFieldDateTime('start_date', $this->lang['planning.start.date'], $this->get_item()->get_start_date(),
			array('required' => true, 'five_minutes_step' => true)
		));

		$fieldset->add_field(new FormFieldCheckbox('end_date_enabled', $this->lang['planning.end.date.enabled'], $this->get_item()->get_end_date_enabled(),
			array(
				'events' => array('click' => '
					if (HTMLForms.getField("end_date_enabled").getValue()) {
						HTMLForms.getField("end_date").enable();
					} else {
						HTMLForms.getField("end_date").disable();
					}'
				)
			)
		));

		$fieldset->add_field($end_date = new FormFieldDateTime('end_date', $this->lang['planning.end.date'], $this->get_item()->get_end_date(),
			array(
                'required' => true, 'five_minutes_step' => true,
                'hidden' => !$this->get_item()->get_end_date_enabled()
            )
		));

		$end_date->add_form_constraint(new FormConstraintFieldsDifferenceSuperior($start_date, $end_date));

		$fieldset->add_field(new FormFieldMailEditor('email', $this->lang['planning.contact.email'], $item->get_email(),
            array(
                'required' => true,
                'description' => $this->lang['planning.contact.email.clue']
            )
        ));

        $fieldset->add_field(new FormFieldCheckbox('more_infos', $this->lang['planning.form.more.infos'], $item->get_more_infos()));

		$option_fieldset = new FormFieldsetHTML('options', $this->lang['form.options']);
		$form->add_fieldset($option_fieldset);
        // if ($this->is_new_item)
        //     $option_fieldset->set_css_class('hidden');

        $option_fieldset->add_field(new FormFieldTelEditor('phone', $this->lang['planning.form.phone'], $item->get_phone()));

		$option_fieldset->add_field(new FormFieldThumbnail('thumbnail', $this->lang['planning.form.thumbnail'], $item->get_thumbnail()->relative(), PlanningItem::THUMBNAIL_URL,
			array (
                'description' => $this->lang['planning.form.thumbnail.clue']
            )
		));

        $location_value = TextHelper::deserialize($item->get_location());

		$location = '';
		if (is_array($location_value) && isset($location_value['address']))
			$location = $location_value['address'];
		else if (!is_array($location_value))
			$location = $location_value;

		if ($this->config->is_googlemaps_available())
		{
			$option_fieldset->add_field(new GoogleMapsFormFieldMapAddress('location', $this->lang['planning.location'], $location,
				array(
					'events' => array('blur' => '
						if (HTMLForms.getField("location").getValue()) {
							HTMLForms.getField("map_displayed").enable();
						} else {
							HTMLForms.getField("map_displayed").disable();
						}'
					)
				)
			));

			$option_fieldset->add_field(new FormFieldCheckbox('map_displayed', $this->lang['planning.form.display.map'], $item->is_map_displayed(),
				array('hidden' => !$location)
			));
		}
		else
			$option_fieldset->add_field(new FormFieldShortMultiLineTextEditor('location', $this->lang['planning.location'], $location));

		$option_fieldset->add_field(new FormFieldRichTextEditor('content', $this->lang['planning.form.content'], $item->get_content(),
			array('rows' => 15)
		));

        if ((!$this->is_new_item && $this->get_item()->is_authorized_to_add()) || CategoriesAuthorizationsService::check_authorizations($item->get_id_category())->moderation())
        {
            $publication_fieldset = new FormFieldsetHTML('publications', $this->lang['form.publication']);
            $form->add_fieldset($publication_fieldset);

            if (!$this->is_new_item)
                $publication_fieldset->add_field(new FormFieldCheckbox('cancelled', $this->lang['planning.form.cancel'], $this->get_item()->is_cancelled()));

            if (CategoriesAuthorizationsService::check_authorizations($item->get_id_category())->moderation())
                $publication_fieldset->add_field(new FormFieldCheckbox('approved', $this->lang['form.approve'], $item->is_approved()));
        }

		$this->build_contribution_fieldset($form);

		$fieldset->add_field(new FormFieldHidden('referrer', $request->get_url_referrer()));

		$this->submit_button = new FormButtonDefaultSubmit();
		$form->add_button($this->submit_button);
		$form->add_button(new FormButtonReset());

		$this->form = $form;
	}

	protected function get_template_string_content()
	{
		return '
            # INCLUDE MESSAGE_HELPER #
            # INCLUDE CONTENT #
            # INCLUDE OPTIONS #
        ';
	}

	private function build_options()
	{
		$view = new FileTemplate('planning/PlanningJS.tpl');
		$view->add_lang($this->lang);

		$view->put_all(array(
		));

		return $view;
	}

	private function build_contribution_fieldset($form)
	{
		if ($this->get_item()->get_id() === null && $this->is_contributor_member())
		{
			$fieldset = new FormFieldsetHTML('contribution', $this->lang['contribution.contribution']);
			$fieldset->set_description(MessageHelper::display($this->lang['contribution.extended.warning'], MessageHelper::WARNING)->render());
			$form->add_fieldset($fieldset);

			$fieldset->add_field(new FormFieldRichTextEditor('contribution_description', $this->lang['contribution.description'], '', array('description' => $this->lang['contribution.description.clue'])));
		}
		elseif ($this->get_item()->is_authorized_to_edit() && $this->is_contributor_member())
		{
			$fieldset = new FormFieldsetHTML('member_edition', $this->lang['contribution.member.edition']);
			$fieldset->set_description(MessageHelper::display($this->lang['contribution.edition.warning'], MessageHelper::WARNING)->render());
			$form->add_fieldset($fieldset);

			$fieldset->add_field(new FormFieldRichTextEditor('edition_description', $this->lang['contribution.edition.description'], '',
				array('description' => $this->lang['contribution.edition.description.clue'])
			));
		}
	}

	private function is_contributor_member()
	{
		return (!CategoriesAuthorizationsService::check_authorizations()->write() && CategoriesAuthorizationsService::check_authorizations()->contribution());
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
			{
				$this->is_new_item = true;
				$this->item = new PlanningItem();
				$this->item->init_default_properties(AppContext::get_request()->get_getint('id_category', Category::ROOT_CATEGORY));
            }
		}
		return $this->item;
	}

	private function check_authorizations()
	{
		$item = $this->get_item();

		if ($item->get_id() === null)
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
			$error_controller = PHPBoostErrors::user_in_read_only();
			DispatchManager::redirect($error_controller);
		}
	}

	private function save()
	{
		$item = $this->get_item();

		$item->set_lamclubs_id($this->form->get_value('club_infos')->get_raw_value());
		if (CategoriesService::get_categories_manager()->get_categories_cache()->has_categories())
			$item->set_id_category($this->form->get_value('id_category')->get_raw_value());
        $item->set_activity_other($this->form->get_value('activity_other'));
		$item->set_rewrited_link(Url::encode_rewrite($item->get_category()->get_name()));
		$item->set_start_date($this->form->get_value('start_date'));
		$item->set_end_date_enabled($this->form->get_value('end_date_enabled'));
        if($this->form->get_value('end_date_enabled'))
            $item->set_end_date($this->form->get_value('end_date'));
		$item->set_phone($this->form->get_value('phone'));
		$item->set_thumbnail($this->form->get_value('thumbnail'));
		$item->set_email($this->form->get_value('email'));
		$item->set_content($this->form->get_value('content'));
		$item->set_location($this->form->get_value('location'));

		if ($this->config->is_googlemaps_available())
		{
			if ($this->form->get_value('map_displayed'))
				$item->display_map();
			else
				$item->hide_map();
		}

		if (CategoriesAuthorizationsService::check_authorizations($item->get_id_category())->moderation())
		{
			if ($this->form->get_value('approved'))
			{
				$item->approve();
				if ($item->get_id() !== null)
					$item->set_update_date(new Date());
			}
			else
				$item->unapprove();
		}
		else if (CategoriesAuthorizationsService::check_authorizations($item->get_id_category())->contribution() && !CategoriesAuthorizationsService::check_authorizations($item->get_id_category())->write())
			$item->unapprove();

		if ($this->is_new_item)
		{
			$item_id = PlanningService::add_item($item);
			$item->set_id($item_id);

			if (!$this->is_contributor_member())
				HooksService::execute_hook_action('add', self::$module_id, array_merge($item->get_properties(), array('item_url' => $item->get_item_url())));
		}
		else
        {
            if ($this->form->get_value('cancelled'))
                $item->cancel();
            else
                $item->uncancel();
			$item_id = PlanningService::update_item($item);

			if (!$this->is_contributor_member())
				HooksService::execute_hook_action('edit', self::$module_id, array_merge($item->get_properties(), array('item_url' => $item->get_item_url())));
		}

		$this->contribution_actions($item);

		PlanningService::clear_cache();
	}

	private function contribution_actions(PlanningItem $item)
	{
		if($this->is_contributor_member())
		{
			$contribution = new Contribution();
			$contribution->set_id_in_module($item->get_id());
			if ($this->is_new_item)
				$contribution->set_description(stripslashes($this->form->get_value('contribution_description')));
			else
				$contribution->set_description(stripslashes($this->form->get_value('edition_description')));

			$contribution->set_entitled($item->get_category()->get_name());
			$contribution->set_fixing_url(PlanningUrlBuilder::edit_item($item->get_id())->relative());
			$contribution->set_poster_id(AppContext::get_current_user()->get_id());
			$contribution->set_module('planning');
			$contribution->set_auth(
				Authorizations::capture_and_shift_bit_auth(
					CategoriesService::get_categories_manager()->get_heritated_authorizations($item->get_id_category(), Category::MODERATION_AUTHORIZATIONS, Authorizations::AUTH_CHILD_PRIORITY),
					Category::MODERATION_AUTHORIZATIONS, Contribution::CONTRIBUTION_AUTH_BIT
				)
			);
			ContributionService::save_contribution($contribution);
			HooksService::execute_hook_action($this->is_new_item ? 'add_contribution' : 'edit_contribution', self::$module_id, array_merge($contribution->get_properties(), $item->get_properties(), array('item_url' => $item->get_item_url())));
		}
		else
		{
			$corresponding_contributions = ContributionService::find_by_criteria('planning', $item->get_id());
			if (count($corresponding_contributions) > 0)
			{
				foreach ($corresponding_contributions as $contribution)
				{
					$contribution->set_status(Event::EVENT_STATUS_PROCESSED);
					ContributionService::save_contribution($contribution);
				}
				HooksService::execute_hook_action('process_contribution', self::$module_id, array_merge($contribution->get_properties(), $item->get_properties(), array('item_url' => $item->get_item_url())));
			}
		}
	}

	private function redirect()
	{
		$item = $this->get_item();
		$category = $item->get_category();

		$c_root_category = $category->get_id() == Category::ROOT_CATEGORY;
        $title = $c_root_category ? $item->get_activity_other() : $category->get_name();
        if ($this->is_new_item && $this->is_contributor_member() && !$item->is_approved())
		{
			DispatchManager::redirect(new UserContributionSuccessController());
		}
		elseif ($item->is_approved())
		{
			if ($this->is_new_item)
				AppContext::get_response()->redirect(PlanningUrlBuilder::home(), StringVars::replace_vars($this->lang['planning.message.success.add'], array('title' => $title)));
			else
				AppContext::get_response()->redirect(($this->form->get_value('referrer') ? $this->form->get_value('referrer') : PlanningUrlBuilder::home()), StringVars::replace_vars($this->lang['planning.message.success.edit'], array('title' => $title)));
		}
		else
		{
			if ($this->is_new_item)
				AppContext::get_response()->redirect(PlanningUrlBuilder::display_pending_items(), StringVars::replace_vars($this->lang['planning.message.success.add'], array('title' => $title)));
			else
				AppContext::get_response()->redirect(($this->form->get_value('referrer') ? $this->form->get_value('referrer') : PlanningUrlBuilder::display_pending_items()), StringVars::replace_vars($this->lang['planning.message.success.edit'], array('title' => $title)));
		}
	}

	private function generate_response(View $view)
	{
		$item = $this->get_item();

		$location_id = $item->get_id() ? 'item-edit-'. $item->get_id() : '';

		$response = new SiteDisplayResponse($view, $location_id);
		$graphical_environment = $response->get_graphical_environment();

		$breadcrumb = $graphical_environment->get_breadcrumb();
		$breadcrumb->add($this->lang['planning.module.title'], PlanningUrlBuilder::home());

		if ($item->get_id() === null)
		{
			$graphical_environment->set_page_title($this->lang['planning.item.add'], $this->lang['planning.module.title']);
			$breadcrumb->add($this->lang['planning.item.add'], PlanningUrlBuilder::add_item());
			$graphical_environment->get_seo_meta_data()->set_description($this->lang['planning.item.add']);
			$graphical_environment->get_seo_meta_data()->set_canonical_url(PlanningUrlBuilder::add_item());
		}
		else
		{
			if (!AppContext::get_session()->location_id_already_exists($location_id))
				$graphical_environment->set_location_id($location_id);

			$graphical_environment->set_page_title($this->lang['planning.item.edit'], $this->lang['planning.module.title']);

			$category = $item->get_category();
			$breadcrumb->add($this->lang['planning.item.edit'], PlanningUrlBuilder::edit_item($item->get_id()));
			$graphical_environment->get_seo_meta_data()->set_description($this->lang['planning.item.edit']);
			$graphical_environment->get_seo_meta_data()->set_canonical_url(PlanningUrlBuilder::edit_item($item->get_id()));
		}

		return $response;
	}
}
?>
