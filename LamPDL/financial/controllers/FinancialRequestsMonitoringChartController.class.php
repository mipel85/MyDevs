<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 04
 * @since       PHPBoost 6.0 - 2020 01 18
 */

class FinancialRequestsMonitoringChartController extends DefaultModuleController
{
    private static $db_querier;

    public static function __static()
    {
        self::$db_querier = PersistenceContext::get_querier();
    }

    protected function get_template_to_use()
    {
        return new FileTemplate('financial/FinancialRequestsMonitoringChartController.tpl');
    }

    public function execute(HTTPRequestCustom $request)
    {
        $columns_disabled = ThemesManager::get_theme(AppContext::get_current_user()->get_theme())->get_columns_disabled();
        $columns_disabled->set_disable_left_columns(true);
        $columns_disabled->set_disable_right_columns(true);

        $this->build_view($request);
        return $this->generate_response($request);
    }

    private function build_view(HTTPRequestCustom $request)
    {
        $this->build_chart_budgets_used();
    }

    private function build_chart_budgets_used()
    {
        $fiscal_year = FinancialBudgetService::get_current_fiscal_year();  
        $this->view->put('FISCAL_YEAR', FinancialBudgetService::get_current_fiscal_year());      

        $budgets_used = FinancialBudgetService::get_budgets_used();
        if ($budgets_used) {
            foreach ($budgets_used as $value) {
                $this->view->assign_block_vars('budgets', array(
                    'NAME'          => $value['budget_type'],
                    'ANNUAL_AMOUNT' => $value['annual_amount'],
                    'REAL_AMOUNT'   => $value['annual_amount'] - $value['real_amount']
                ));
            }
        }
    }

    private function generate_response(HTTPRequestCustom $request)
    {
        $response = new SiteDisplayResponse($this->view);

        $page_title = $this->lang['financial.chart.budgets.used'];

        $graphical_environment = $response->get_graphical_environment();

        $graphical_environment->set_page_title($this->lang['financial.module.title'], '');

        $description = StringVars::replace_vars($this->lang['financial.seo.description.root'], array('site' => GeneralConfig::load()->get_site_name()));
        $graphical_environment->get_seo_meta_data()->set_description($description);
        $graphical_environment->get_seo_meta_data()->set_canonical_url(FinancialUrlBuilder::requests_monitoring_chart());

        $breadcrumb = $graphical_environment->get_breadcrumb();
        $breadcrumb->add($this->lang['financial.module.title'], FinancialUrlBuilder::home());
        $breadcrumb->add($page_title, FinancialUrlBuilder::requests_monitoring_chart());

        return $response;
    }
}
?>
