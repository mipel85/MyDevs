<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 03 26
 * @since       PHPBoost 6.0 - 2024 02 25
*/

class PlanningHomeController extends DefaultModuleController
{
	private $items_number = 0;
	private $ids = array();
	private $hide_delete_input = array();
	private $display_multiple_delete = true;

	public function execute(HTTPRequestCustom $request)
	{
		$this->check_authorizations();

        $c_clubs = ModulesManager::is_module_installed('lamclubs') && ModulesManager::is_module_activated('lamclubs');
        $c_categories = CategoriesService::get_categories_manager()->get_categories_cache()->has_categories();
        if ($c_clubs && $c_categories)
        {
            $current_page = $this->build_table();
        }
        else
        {
            $current_page = $this->build_warnings();
        }

		if ($this->display_multiple_delete)
			$this->execute_multiple_delete_if_needed($request);

		return $this->generate_response($current_page);
	}

	private function build_table()
	{
		$columns = array(
			new HTMLTableColumn($this->lang['date.date'], 'start_date'),
			new HTMLTableColumn($this->lang['planning.activities'], 'id_category'),
			new HTMLTableColumn($this->lang['planning.activity.detail'], 'activity_detail'),
			new HTMLTableColumn($this->lang['planning.club.department'], 'department'),
			new HTMLTableColumn($this->lang['planning.club.name'], 'name'),
			new HTMLTableColumn($this->lang['common.see.details'], 'content'),
			new HTMLTableColumn('')
		);

		$table_model = new SQLHTMLTableModel(PlanningSetup::$planning_table, 'items-list', $columns, new HTMLTableSortingRule('start_date', HTMLTableSortingRule::ASC));

		$table_model->set_layout_title($this->lang['planning.module.title']);

		$table_model->set_filters_menu_title($this->lang['planning.filter.items']);
		$table_model->add_filter(new HTMLTableDateGreaterThanOrEqualsToSQLFilter('start_date', 'filter1', $this->lang['date.date'] . ' ' . TextHelper::lcfirst($this->lang['common.minimum'])));
		$table_model->add_filter(new HTMLTableDateLessThanOrEqualsToSQLFilter('start_date', 'filter2', $this->lang['date.date'] . ' ' . TextHelper::lcfirst($this->lang['common.maximum'])));
		$table_model->add_filter(new HTMLTableEqualsFromListSQLFilter('department', 'filter3', $this->lang['planning.club.department'], array(44 => 44, 49 => 49, 53 => 53, 72 => 72, 85 => 85)));
        $table_model->add_filter(new HTMLTableCategorySQLFilter('filter4', $this->lang['planning.activities']));

        $now = new Date();
        $clear = new Date($now->get_timestamp() - 86400, Timezone::SERVER_TIMEZONE);
        $table_model->add_permanent_filter('(end_date_enabled = 0 AND start_date > ' . $clear->get_timestamp() . ' OR end_date_enabled = 1 AND end_date > ' . $clear->get_timestamp() . ')');

		$table = new HTMLTable($table_model);
		$table->set_filters_fieldset_class_HTML();

		$results = array();
		$result = $table_model->get_sql_results('pl
			LEFT JOIN ' . DB_TABLE_MEMBER . ' member ON member.user_id = pl.author_user_id
			LEFT JOIN ' . LamclubsSetup::$lamclubs_table . ' club ON club.club_id = pl.lamclubs_id'
		);

		$items = array();
		$moderation_link_number = 0;
		foreach ($result as $row)
		{
			$item = new PlanningItem();
			$item->set_properties($row);

			$items[] = $item;
			if ($item->is_authorized_to_edit() || $item->is_authorized_to_delete())
			{
				$moderation_link_number++;
				$this->items_number++;
				$this->ids[$this->items_number] = $item->get_id();
			}
			else
				$this->hide_delete_input[] = $item->get_id();
		}

		if (empty($moderation_link_number))
		{
			$table_model->delete_last_column();
			$table->hide_multiple_delete();
			$this->display_multiple_delete = false;
		}

		foreach ($items as $item)
		{
			$category = $item->get_category();

			$edit_link = new EditLinkHTMLElement(PlanningUrlBuilder::edit_item($item->get_id()));
			$edit_link = $item->is_authorized_to_edit() ? $edit_link->display() : '';

			$delete_link = new DeleteLinkHTMLElement(PlanningUrlBuilder::delete_item($item->get_id()), '', array('data-confirmation' => 'delete-element'));
			$delete_link = $item->is_authorized_to_delete() ? $delete_link->display() : '';

            $visitor_link = new LinkHTMLElement(PlanningUrlBuilder::display($category->get_id(), $category->get_rewrited_name(), $item->get_id(), $item->get_rewrited_link()), '<i class="fa fa-fw fa-eye"></i>', array('aria-label' => $this->lang['common.read.more']));
            $visitor_link = $visitor_link->display();

			$br = new BrHTMLElement();

			$c_root_category = $category->get_id() == Category::ROOT_CATEGORY;
            $title = $c_root_category ? $item->get_activity_other() : $category->get_name();
            $c_end_date = $item->get_end_date_enabled() && $item->get_start_date()->format(Date::FORMAT_DAY_MONTH_YEAR) !== $item->get_end_date()->format(Date::FORMAT_DAY_MONTH_YEAR);
            $club = LamclubsService::get_item($item->get_lamclubs_id());

			if ($item->is_approved())
			{
                $cancel_class = $item->is_cancelled() ? ' bgc error' : '';
                $title = $item->is_cancelled() ? '<span class="text-strike">'. $title . '</span><br />' . $this->lang['planning.cancelled.item'] : $title;
				$row = array(
					new HTMLTableRowCell(($c_end_date ? $this->lang['date.from.date'] : '') . ' ' . $item->get_start_date()->format(Date::FORMAT_DAY_MONTH_YEAR) . ($c_end_date ? $br->display() . $this->lang['date.to.date'] . ' ' . $item->get_end_date()->format(Date::FORMAT_DAY_MONTH_YEAR) : ''),'align-left' . $cancel_class),
					new HTMLTableRowCell($title, 'align-left' . $cancel_class),
					new HTMLTableRowCell($item->get_activity_detail(), 'align-left' . $cancel_class),
					new HTMLTableRowCell($club->get_department(), $cancel_class),
					new HTMLTableRowCell($club->get_name(),'align-left' . $cancel_class),
					new HTMLTableRowCell($visitor_link),
					$moderation_link_number ? new HTMLTableRowCell($edit_link . $delete_link, 'controls') : null
				);

				$table_row = new HTMLTableRow($row);
				if (in_array($item->get_id(), $this->hide_delete_input))
					$table_row->hide_delete_input();

				$results[] = $table_row;
			}
		}
		$table->set_rows($table_model->get_number_of_matching_rows(), $results);

		$this->view->put_all(array(
            'CONTENT' => $table->display(),
            'CALL_TO_ACTION' => self::build_call_to_action()
        ));

		return $table->get_page_number();
	}

    private function build_warnings()
    {
        $this->view = new FileTemplate('planning/PlanningWarningsController.tpl');
        $this->view->add_lang(LangLoader::get_all_langs('planning'));
        $c_clubs = ModulesManager::is_module_installed('lamclubs') && ModulesManager::is_module_activated('lamclubs');
        $c_categories = CategoriesService::get_categories_manager()->get_categories_cache()->has_categories();

        $this->view->put_all(array(
            'C_NO_LAMCLUBS' => !$c_clubs,
            'C_NO_CATEGORIES' => !$c_categories
        ));
    }

    private function build_call_to_action()
    {
        $view = new FileTemplate('planning/PlanningAddController.tpl');
        $view->add_lang(LangLoader::get_all_langs('planning'));

        $view->put_all(array(
            'C_AUTH' => CategoriesAuthorizationsService::check_authorizations()->contribution(),
            'ADD_ITEM' => PlanningUrlBuilder::add_item()->rel()
        ));

		return $view;
    }

	protected function get_template_string_content()
	{
		return '
            # INCLUDE MESSAGE_HELPER #
            # INCLUDE CALL_TO_ACTION #
            # INCLUDE CONTENT #
        ';
	}

	private function execute_multiple_delete_if_needed(HTTPRequestCustom $request)
	{
		if ($request->get_string('delete-selected-elements', false))
		{
			for ($i = 1 ; $i <= $this->items_number ; $i++)
			{
				if ($request->get_value('delete-checkbox-' . $i, 'off') == 'on')
				{
					if (isset($this->ids[$i]) && !in_array($this->ids[$i], $this->hide_delete_input))
					{
						$item = '';
						try {
							$item = PlanningService::get_item($this->ids[$i]);
						} catch (RowNotFoundException $e) {}

						if ($item)
						{
							// Delete item
							PlanningService::delete_item($item->get_id());
						}
					}
				}
			}

			AppContext::get_response()->redirect(PlanningUrlBuilder::home(), $this->lang['warning.process.success']);
		}
	}

	private function check_authorizations()
	{
		if (!CategoriesAuthorizationsService::check_authorizations()->read())
		{
			$error_controller = PHPBoostErrors::user_not_authorized();
			DispatchManager::redirect($error_controller);
		}
	}

	private function generate_response($page = 1)
	{
		$response = new SiteDisplayResponse($this->view);
		$graphical_environment = $response->get_graphical_environment();
		$graphical_environment->set_page_title($this->lang['planning.module.title'], $page);
		$graphical_environment->get_seo_meta_data()->set_description(StringVars::replace_vars($this->lang['planning.seo.description.events.list'], array('site' => GeneralConfig::load()->get_site_name())));
		$graphical_environment->get_seo_meta_data()->set_canonical_url(PlanningUrlBuilder::home());

		$breadcrumb = $graphical_environment->get_breadcrumb();
		$breadcrumb->add($this->lang['planning.module.title'], PlanningUrlBuilder::home());

		return $response;
	}

	public static function get_view()
	{
		$object = new self('planning');
		$object->check_authorizations();
		$object->build_table();
		return $object->view;
	}
}
?>
