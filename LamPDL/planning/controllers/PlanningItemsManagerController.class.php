<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 11 
 * @since       PHPBoost 6.0 - 2020 01 18
 */

class PlanningItemsManagerController extends DefaultModuleController
{
    private $items_number = 0;
    private $ids = array();

    public function execute(HTTPRequestCustom $request)
    {
        $this->check_authorizations();

        $current_page = $this->build_table();

        $this->execute_multiple_delete_if_needed($request);

        return $this->generate_response($current_page);
    }

    private function build_table()
    {
        $columns = array(
          new HTMLTableColumn($this->lang['planning.activity'], 'id_category'),
          new HTMLTableColumn($this->lang['planning.activity.detail'], 'activity_detail'),
          new HTMLTableColumn($this->lang['common.author'], 'display_name'),
          new HTMLTableColumn($this->lang['date.date'], 'start_date'),
          new HTMLTableColumn($this->lang['planning.club.department'], 'department'),
          new HTMLTableColumn($this->lang['planning.club.name'], 'name'),
          new HTMLTableColumn($this->lang['common.status'], 'approved'),
          new HTMLTableColumn($this->lang['common.actions'], '', array('sr-only' => true))
        );

        $table_model = new SQLHTMLTableModel(PlanningSetup::$planning_table, 'items-manager', $columns, new HTMLTableSortingRule('start_date', HTMLTableSortingRule::DESC));

        $table_model->set_layout_title($this->lang['planning.items.management']);

        $table_model->set_filters_menu_title($this->lang['planning.filter.items']);
        $table_model->add_filter(new HTMLTableDateGreaterThanOrEqualsToSQLFilter('start_date', 'filter1', $this->lang['planning.start.date'] . ' ' . TextHelper::lcfirst($this->lang['common.minimum'])));
        $table_model->add_filter(new HTMLTableDateLessThanOrEqualsToSQLFilter('start_date', 'filter2', $this->lang['planning.start.date'] . ' ' . TextHelper::lcfirst($this->lang['common.maximum'])));
        $table_model->add_filter(new HTMLTableEqualsFromListSQLFilter('department', 'filter3', $this->lang['planning.club.department'], array(44 => 44, 49 => 49, 53 => 53, 72 => 72, 85 => 85)));
        $table_model->add_filter(new HTMLTableCategorySQLFilter('filter4', $this->lang['planning.activities']));
        $table_model->add_filter(new HTMLTableEqualsFromListSQLFilter('approved', 'filter5', $this->lang['common.status'], array(1 => $this->lang['common.status.approved'], 0 => $this->lang['planning.status.draft'])));

        $table = new HTMLTable($table_model);
        $table->set_filters_fieldset_class_HTML();

        $results = array();
        $result = $table_model->get_sql_results('pl
			LEFT JOIN ' . DB_TABLE_MEMBER . ' member ON member.user_id = pl.author_user_id
			LEFT JOIN ' . LamclubsSetup::$lamclubs_table . ' club ON club.club_id = pl.lamclubs_id'
        );

        foreach ($result as $row)
        {
            $item = new PlanningItem();
            $item->set_properties($row);
            $category = $item->get_category();
            $user = $item->get_author_user();

            $this->items_number++;
            $this->ids[$this->items_number] = $item->get_id();

            $edit_link = new EditLinkHTMLElement(PlanningUrlBuilder::edit_item($item->get_id()));
            $delete_link = new DeleteLinkHTMLElement(PlanningUrlBuilder::delete_item($item->get_id()), '', array('data-confirmation' => 'delete-element'));

            $user_group_color = User::get_group_color($user->get_groups(), $user->get_level(), true);
            $author = $user->get_id() !== User::VISITOR_LEVEL ? new LinkHTMLElement(UserUrlBuilder::profile($user->get_id()), $user->get_display_name(), (!empty($user_group_color) ? array('style' => 'color: ' . $user_group_color) : array()), UserService::get_level_class($user->get_level())) : $user->get_display_name();

            $br = new BrHTMLElement();

            $draft_class = !$item->is_approved() ? 'bgc warning' : '';
            $c_root_category = $category->get_id() == Category::ROOT_CATEGORY;
            $title = $c_root_category ? $item->get_activity_other() : $category->get_name();
            $club = LamclubsService::get_item($item->get_lamclubs_id());
            $c_end_date = $item->get_end_date_enabled() && $item->get_start_date()->format(Date::FORMAT_DAY_MONTH_YEAR) !== $item->get_end_date()->format(Date::FORMAT_DAY_MONTH_YEAR);

            $row = array(
                new HTMLTableRowCell(new LinkHTMLElement(PlanningUrlBuilder::display($category->get_id(), $category->get_rewrited_name(), $item->get_id(), $item->get_rewrited_link()), $title), 'align-left ' . $draft_class),
                new HTMLTableRowCell($item->get_activity_detail()),
                new HTMLTableRowCell($author, $draft_class),
                new HTMLTableRowCell(($c_end_date ? $this->lang['date.from.date'] : '') . ' ' . $item->get_start_date()->format(Date::FORMAT_DAY_MONTH_YEAR) . ($c_end_date ? $br->display() . $this->lang['date.to.date'] . ' ' . $item->get_end_date()->format(Date::FORMAT_DAY_MONTH_YEAR) : ''), $draft_class),
                new HTMLTableRowCell($club->get_department(), $draft_class),
                new HTMLTableRowCell($club->get_name(), $draft_class),
                new HTMLTableRowCell($item->is_approved() ? $this->lang['planning.status.published'] : $this->lang['planning.status.draft'], $draft_class),
                new HTMLTableRowCell($edit_link->display() . $delete_link->display(), 'controls ' . $draft_class)
            );

            $results[] = new HTMLTableRow($row);
        }
        $table->set_rows($table_model->get_number_of_matching_rows(), $results);

        $this->view->put('CONTENT', $table->display());

        return $table->get_page_number();
    }

    private function execute_multiple_delete_if_needed(HTTPRequestCustom $request)
    {
        if ($request->get_string('delete-selected-elements', false))
        {
            for ($i = 1; $i <= $this->items_number; $i++)
            {
                if ($request->get_value('delete-checkbox-' . $i, 'off') == 'on')
                {
                    if (isset($this->ids[$i]))
                    {
                        $item = '';
                        try
                            {
                                $item = PlanningService::get_item($this->ids[$i]);
                            }
                        catch (RowNotFoundException $e)
                            {
                            
                            }

                        if ($item)
                        {
                            //Delete item
                            PlanningService::delete_item($item->get_id());

                            HooksService::execute_hook_action('delete', self::$module_id, $item->get_properties());
                        }
                    }
                }
            }

            AppContext::get_response()->redirect(PlanningUrlBuilder::manage_items(), $this->lang['warning.process.success']);
        }
    }

    private function check_authorizations()
    {
        if (!CategoriesAuthorizationsService::check_authorizations()->moderation())
        {
            $error_controller = PHPBoostErrors::user_not_authorized();
            DispatchManager::redirect($error_controller);
        }
    }

    private function generate_response($page = 1)
    {
        $response = new SiteDisplayResponse($this->view);

        $graphical_environment = $response->get_graphical_environment();
        $graphical_environment->set_page_title($this->lang['planning.items.management'], $this->lang['planning.module.title'], $page);
        $graphical_environment->get_seo_meta_data()->set_canonical_url(PlanningUrlBuilder::manage_items());

        $breadcrumb = $graphical_environment->get_breadcrumb();
        $breadcrumb->add($this->lang['planning.module.title'], PlanningUrlBuilder::home());

        $breadcrumb->add($this->lang['planning.items.management'], PlanningUrlBuilder::manage_items());

        return $response;
    }
}
?>
