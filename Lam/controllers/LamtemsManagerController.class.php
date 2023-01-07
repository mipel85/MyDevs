<?php
/*
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2022 12 27
 * @since       PHPBoost 6.0 - 2022 12 20
 */
class LamItemsManagerController extends DefaultModuleController
{
    private $items_number = 0;
    private $ids = array();
    public function execute(HTTPRequestCustom $request)
    {
//		$this->check_authorizations();

        $current_page = $this->build_table();

//		$this->execute_multiple_delete_if_needed($request);

        return $this->generate_response($current_page);
    }
    private function build_table()
    {

        $columns = array(
            new HTMLTableColumn($this->lang['lam.form.radio.choices'], 'form_name'),
            new HTMLTableColumn($this->lang['lam.club.name'], 'club_name'),
            new HTMLTableColumn($this->lang['lam.club.activity.date'], 'club_activity_date'),
        );
        $table_model = new SQLHTMLTableModel(LamSetup::$lam_forms, 'items-manager', $columns, new HTMLTableSortingRule('form_name', HTMLTableSortingRule::DESC));
        $table_model->set_layout_title($this->lang['lam.stats']);
        $table_model->set_filters_menu_title($this->lang['lam.filter.items']);
        
		$activity = array($this->lang['lam.jpo']=>$this->lang['lam.jpo'], $this->lang['lam.qpdd']=>$this->lang['lam.qpdd']);
        $table_model->add_filter(new HTMLTableEqualsFromListSQLFilter('form_name', 'activityfilter', $this->lang['lam.activity'], $activity));
        $table = new HTMLTable($table_model);
        $table->set_filters_fieldset_class_HTML();
        
        $results = array();
        $result = $table_model->get_sql_results('stats');
        foreach ($result as $row)
        {
            $item = new LamItem();
            $item->set_properties($row);
            $this->items_number++;
            $this->ids[$this->items_number] = $item->get_id();
//
//			$edit_link = new EditLinkHTMLElement(CalendarUrlBuilder::edit_item(!$item->get_parent_id() ? $item->get_id() : $item->get_parent_id()));
//			$delete_link = new DeleteLinkHTMLElement(CalendarUrlBuilder::delete_item($item->get_id()), '', array('data-confirmation' => !$item->belongs_to_a_serie() ? 'delete-element' : ''));
//
//			$br = new BrHTMLElement();
//            Debug::dump($item);
            $row = array(
                new HTMLTableRowCell($item->get_form_name()),
                new HTMLTableRowCell($item->get_club_name()),
                new HTMLTableRowCell($item->get_club_activity_date()->format(Date::FORMAT_DAY_MONTH_YEAR)),
            );

            $results[] = new HTMLTableRow($row);
        }
        $table->set_rows($table_model->get_number_of_matching_rows(), $results);

        $this->view->put('CONTENT', $table->display());

        return $table->get_page_number();
    }
//    private function execute_multiple_delete_if_needed(HTTPRequestCustom $request)
//    {
//        if ($request->get_string('delete-selected-elements', false)){
//            for ($i = 1; $i <= $this->items_number; $i++)
//            {
//                if ($request->get_value('delete-checkbox-' . $i, 'off') == 'on'){
//                    if (isset($this->ids[$i])){
//                        $item = '';
//                        try {
//                            $item = CalendarService::get_item($this->ids[$i]);
//                        }catch (RowNotFoundException $e){
//                            
//                        }
//
//                        if ($item){
//                            $items_list = CalendarService::get_serie_items($item->get_content()->get_id());
//
//                            //Delete item
//                            CalendarService::delete_item($item->get_id(), $item->get_parent_id());
//
//                            if (!$item->belongs_to_a_serie() || count($items_list) == 1){
//                                CalendarService::delete_item_content($item->get_id());
//                            }
//
//                            HooksService::execute_hook_action('delete', self::$module_id, array_merge($item->get_content()->get_properties(), $item->get_properties()));
//                        }
//                    }
//                }
//            }
//
//            CalendarService::clear_cache();
//
//            AppContext::get_response()->redirect(CalendarUrlBuilder::manage_items(), $this->lang['warning.process.success']);
//        }
//    }
    
    private function check_authorizations()
    {
        if (!CategoriesAuthorizationsService::check_authorizations()->moderation()){
            $error_controller = PHPBoostErrors::user_not_authorized();
            DispatchManager::redirect($error_controller);
        }
    }
    private function generate_response($page = 1)
    {
        $response = new SiteDisplayResponse($this->view);

        $graphical_environment = $response->get_graphical_environment();
        $graphical_environment->set_page_title($this->lang['lam.activity'], $this->lang['lam.activity'], $page);
        $graphical_environment->get_seo_meta_data()->set_canonical_url(LamUrlBuilder::stats());

        $breadcrumb = $graphical_environment->get_breadcrumb();
        $breadcrumb->add($this->lang['lam.activity'], LamUrlBuilder::home());
        $breadcrumb->add($this->lang['lam.activity'], LamUrlBuilder::stats());

        return $response;
    }
}
?>
