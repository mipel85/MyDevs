<?php
/*
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 18
 * @since       PHPBoost 6.0 - 2024 01 18
 */
class FinancialItemsManagerController extends DefaultModuleController
{
    private $activity;
    private $items_number = 0;
    private $ids = array();

    protected function get_template_to_use()
    {
        return new FileTemplate('financial/FinancialItemsManagerController.tpl');
    }

    public function execute(HTTPRequestCustom $request)
    {
        $this->check_authorizations();
        $this->build_activity_table();
        $this->build_financial_statement();

        $this->view->put('ACTIVITY_TABLE', $this->activity->display());
        return $this->generate_response();
    }

    private function check_authorizations()
    {
        if (!FinancialAuthorizationsService::check_authorizations()->officer()){
            $controller = PHPBoostErrors::user_not_authorized();
            DispatchManager::redirect($controller);
        }
    }

    private function build_financial_statement()
    {
        $nb_jpo_requests = FinancialService::get_requests_number('jpo');
        $nb_exam_requests = FinancialService::get_requests_number('exam');

        $this->view->put_all(array(
            'C_IS_AUTHORIZED'       => AppContext::get_current_user()->get_groups()[1] == 1 || AppContext::get_current_user()->get_level(user::ADMINISTRATOR_LEVEL),
            'JPO'                   => $this->lang['financial.jpo'],
            'JPO_TOTAL_AMOUNT'      => $this->config->get_jpo_total_amount(),
            'JPO_DAY_AMOUNT'        => $this->config->get_jpo_day_amount(),
            'JPO_NB_REQUESTS'       => $nb_jpo_requests['jpo'],
            'JPO_REMAINING_AMOUNT'  => $this->config->get_jpo_total_amount() - $this->config->get_jpo_day_amount() * $nb_jpo_requests['jpo'],
            'EXAM'                  => $this->lang['financial.exam'],
            'EXAM_TOTAL_AMOUNT'     => $this->config->get_exam_total_amount(),
            'EXAM_DAY_AMOUNT'       => $this->config->get_exam_day_amount(),
            'EXAM_NB_REQUESTS'      => $nb_exam_requests['exam'],
            'EXAM_REMAINING_AMOUNT' => $this->config->get_exam_total_amount() - $this->config->get_exam_day_amount() * $nb_exam_requests['exam']
        ));
    }

    private function build_activity_table()
    {
        $columns = array(
            new HTMLTableColumn($this->lang['financial.form.radio.choices'], 'activity_type'),
            new HTMLTableColumn($this->lang['financial.club.name'], 'club_name'),
            new HTMLTableColumn($this->lang['financial.club.ffam.number'], 'club_ffam_number'),
            new HTMLTableColumn($this->lang['financial.club.activity.date'], 'club_activity_date'),
            new HTMLTableColumn($this->lang['financial.club.request.date'], 'club_request_date'),
        );
        $table_model = new SQLHTMLTableModel(FinancialSetup::$financial, 'items-manager', $columns, new HTMLTableSortingRule('activity_type', HTMLTableSortingRule::DESC));
        $table_model->set_layout_title($this->lang['financial.activity.requests']);
        $table_model->set_filters_menu_title($this->lang['financial.filter.items']);

        //filters
        $activity = array('jpo' => $this->lang['financial.jpo'], 'exam' => $this->lang['financial.exam']);
        $table_model->add_filter(new HTMLTableEqualsFromListSQLFilter('activity_type', 'activityfilter', $this->lang['financial.filter.choice'], $activity));
        $activity_table = new HTMLTable($table_model);
        $activity_table->set_filters_fieldset_class_HTML();
        $activity_table->hide_multiple_delete();

        $results = array();
        $result = $table_model->get_sql_results('activity_manager');
        foreach ($result as $row)
        {
            $item = new FinancialActivityItem();
            $item->set_properties($row);
            $this->items_number++;
            $this->ids[$this->items_number] = $item->get_id();
            $row = array(
                new HTMLTableRowCell($item->get_activity_type() == 'jpo' ? $this->lang['financial.jpo'] : $this->lang['financial.exam'], 'align-left'),
                new HTMLTableRowCell($item->get_club_name()),
                new HTMLTableRowCell($item->get_club_ffam_number()),
                new HTMLTableRowCell($item->get_club_activity_date()->format(Date::FORMAT_DAY_MONTH_YEAR)),
                new HTMLTableRowCell($item->get_club_request_date()->format(Date::FORMAT_DAY_MONTH_YEAR)),
            );

            $results[] = new HTMLTableRow($row);
        }
        $activity_table->set_rows($table_model->get_number_of_matching_rows(), $results);

        $this->activity = $activity_table;

        return $activity_table->get_page_number();
    }

    private function generate_response($page = 1)
    {
        $response = new SiteDisplayResponse($this->view);

        $graphical_environment = $response->get_graphical_environment();
        $graphical_environment->set_page_title($this->lang['financial.jpo'], $this->lang['financial.jpo'], $page);
        $graphical_environment->get_seo_meta_data()->set_canonical_url(FinancialUrlBuilder::activity());

        $breadcrumb = $graphical_environment->get_breadcrumb();
        $breadcrumb->add($this->lang['financial.jpo'], FinancialUrlBuilder::home());
        $breadcrumb->add($this->lang['financial.jpo'], FinancialUrlBuilder::activity());

        return $response;
    }
}
?>
