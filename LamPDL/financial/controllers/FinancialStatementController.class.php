<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 10 17
 * @since       PHPBoost 6.0 - 2020 01 18
 */
class FinancialStatementController extends DefaultModuleController
{
    private static $db_querier;

    public static function __static()
    {
        self::$db_querier = PersistenceContext::get_querier();
    }

    protected function get_template_to_use()
    {
        return new FileTemplate('financial/FinancialStatementController.tpl');
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
        $section = $request->get_string('section', '');

        $this->view->put_all([
            'C_CHART'     => $section == 'chart',
            'U_CHART'     => FinancialUrlBuilder::statement('chart')->rel(),
            'C_STATEMENT' => $section == 'statement',
            'U_STATEMENT' => FinancialUrlBuilder::statement('statement')->rel(),
        ]);
        $this->build_chart_budgets_used();
        $this->build_statement_list();
    }

    private function build_chart_budgets_used()
    {
        $budgets_used = FinancialBudgetService::get_budgets_used();

        if ($budgets_used) foreach ($budgets_used as $value) {
                $this->view->assign_block_vars('budgets', array(
                    'NAME'          => $value['name'],
                    'ANNUAL_AMOUNT' => $value['annual_amount'],
                    'REAL_AMOUNT'   => $value['annual_amount'] - $value['real_amount']
                ));
        }
    }

    private function build_statement_list()
    {
        $statement = FinancialBudgetService::get_statement_view();

        $total_expenses = 0;
        if ($statement) foreach ($statement as $value) {
                $total_expenses += $value['Montant versé'];
                $total_expenses = number_format($total_expenses, 2, '.', '');

                $this->view->assign_block_vars('statement', array(
                    'DOMAIN'           => $value['Domaine'],
                    'TYPE'             => $value['Type de demande'],
                    'CLUB'             => $value['Club'],
                    'FFAM_NUM'         => $value['N° FFAM'],
                    'AUTHOR'           => $value['Demandeur'],
                    'CREATION_DATE'    => $value['Date_création'],
                    'EVENT_DATE'       => $value['Date_événement'],
                    'AMOUNT_PAID'      => $value['Montant versé'],
                    'BUDGET_PLANNED'   => number_format($value['Budget prévu'], 2, '.', ''),
                    'BUDGET_ACHIEVED'  => $value['Budget dépensé'],
                    'BUDGET_REMAINING' => $value['Budget restant'],
                    'C_ESTIMATE_LINK'  => $value['lien devis'],
                    'ESTIMATE_LINK'    => Url::to_rel($value['lien devis']),
                    'C_INVOICE_LINK'   => $value['lien facture'],
                    'INVOICE_LINK'     => Url::to_rel($value['lien facture']),
                    'ID'               => $value['id'],
                    'DESCRIPTION'      => $value['sender_description'],
                ));
        }
        $this->view->put('TOTAL_EXPENSES', $total_expenses);
    }

    private function generate_response(HTTPRequestCustom $request)
    {
        $response = new SiteDisplayResponse($this->view);
        $section = $request->get_string('section', '');

        $page_title = $this->lang['financial.charts.menu'];
        $page_title = ($section == 'chart') ? $this->lang['financial.chart.budgets.used'] : $page_title;
        $page_title = ($section == 'statement') ? $this->lang['financial.budgets.statement'] : $page_title;

        $graphical_environment = $response->get_graphical_environment();

        $graphical_environment->set_page_title($this->lang['financial.module.title'], '');
//
        $description = StringVars::replace_vars($this->lang['financial.seo.description.root'], array('site' => GeneralConfig::load()->get_site_name()));
        $graphical_environment->get_seo_meta_data()->set_description($description);
        $graphical_environment->get_seo_meta_data()->set_canonical_url(FinancialUrlBuilder::statement('budgets_used',));
//
        $breadcrumb = $graphical_environment->get_breadcrumb();
        $breadcrumb->add($this->lang['financial.module.title'], FinancialUrlBuilder::home());
        $breadcrumb->add('Graphiques', FinancialUrlBuilder::statement());
        $breadcrumb->add($page_title, FinancialUrlBuilder::statement($section));

        return $response;
    }
    }
?>
