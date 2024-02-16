<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class FinancialRequestsMonitoringController extends DefaultModuleController
{
	private $hide_delete_input = array();

	public function execute(HTTPRequestCustom $request)
	{
		$this->check_authorizations();

        $c_clubs = ModulesManager::is_module_installed('lamclubs') && ModulesManager::is_module_activated('lamclubs');
        if ($c_clubs)
        {
            $current_page = $this->build_table();
        }
        else
        {
            $current_page = $this->build_warnings();
        }

		return $this->generate_response($current_page);
	}

	private function build_table()
	{
		$columns = array(
			new HTMLTableColumn($this->lang['financial.budget.domain'], 'domain'),
			new HTMLTableColumn($this->lang['financial.request.type'], '', array('css_class' => 'align-left')),
			new HTMLTableColumn($this->lang['financial.budget.annual'], ''),
			new HTMLTableColumn($this->lang['financial.budget.unit.amount'], ''),
			new HTMLTableColumn($this->lang['financial.budget.balance'] . '<br /><span class="smaller">' . $this->lang['financial.budget.real'] . '</span>', ''),
			new HTMLTableColumn($this->lang['financial.budget.balance'] . '<br /><span class="smaller">' . $this->lang['financial.budget.temp'] . '</span>', ''),
			new HTMLTableColumn($this->lang['financial.budget.quantities'] . '<br /><span class="smaller">' . $this->lang['financial.budget.real'] . '</span>', ''),
			new HTMLTableColumn($this->lang['financial.budget.quantities'] . '<br /><span class="smaller">' . $this->lang['financial.budget.temp'] . '</span>', '')
		);

		$table_model = new SQLHTMLTableModel(FinancialSetup::$financial_budget_table, 'items-list', $columns, new HTMLTableSortingRule('id', HTMLTableSortingRule::ASC));

		$table_model->set_layout_title($this->lang['financial.monitoring']);

		$table = new HTMLTable($table_model);
		$table->set_filters_fieldset_class_HTML();
        $table->hide_multiple_delete();
        $table->set_css_class('bordered-table');

		$results = array();
		$result = $table_model->get_sql_results('budget');

        // retrieve pending requests
            $pending_budgets = [];
            $pending_result = PersistenceContext::get_querier()->select('SELECT *
                FROM ' . FinancialSetup::$financial_request_table . '
                WHERE agreement = 1 OR agreement = 2
            ');
            while($row = $pending_result->fetch())
            {
                $pending_budgets[] = $row['budget_id'];
            }

        // Limits display to list of requests budget ids
            $request_budgets = [];
            $request_result = PersistenceContext::get_querier()->select('SELECT *
                FROM ' . FinancialSetup::$financial_request_table);
            while($row = $request_result->fetch())
            {
                $request_budgets[] = $row['budget_id'];
            }
            $request_budgets_filter = '(' . implode(', ', array_unique($request_budgets)) . ')';
            if(!empty($request_budgets))
                $table_model->add_permanent_filter('id IN ' . $request_budgets_filter);

		$budgets = array();
		foreach ($result as $row)
		{
			$budget = new FinancialBudgetItem();
			$budget->set_properties($row);
			$budgets[] = $budget;
		}

		foreach ($budgets as $budget)
		{
            $unit_amount = $budget->get_unit_amount() !== '0€' && $budget->get_unit_amount() !== '0%' ? $budget->get_unit_amount() : '';

            if ($budget->get_use_dl() && in_array($budget->get_id(), $pending_budgets))
                $temp_amount = '<span aria-label="' . $this->lang['financial.budget.pending'] . '"><i class="fa fa-lg fa-triangle-exclamation warning"></i></span>';
            elseif ($budget->get_use_dl() && $budget->get_real_quantity() == $budget->get_temp_quantity())
                $temp_amount = '<span aria-label="' . $this->lang['financial.budget.no.pending'] . '">--</span>';
            elseif ($budget->get_quantity() == '')
                $temp_amount = '<span aria-label="' . $this->lang['financial.budget.no.pending'] . '">--</span>';
            else
                $temp_amount = $budget->get_temp_amount() . '€';

            $row = array(
                new HTMLTableRowCell($budget->get_domain(), 'small'),
                new HTMLTableRowCell($budget->get_name(), 'align-left'),
                new HTMLTableRowCell($budget->get_annual_amount() . '€'),
                new HTMLTableRowCell($unit_amount),
                new HTMLTableRowCell($budget->get_real_amount() . '€'),
                new HTMLTableRowCell($temp_amount),
                new HTMLTableRowCell($budget->get_real_quantity()),
                new HTMLTableRowCell($budget->get_temp_quantity())
            );

            $table_row = new HTMLTableRow($row);
            if (in_array($budget->get_id(), $this->hide_delete_input))
                $table_row->hide_delete_input();

            if (in_array($budget->get_id(), $request_budgets))
            {
                $results[] = $table_row;
            }
		}
		$table->set_rows($table_model->get_number_of_matching_rows(), $results);

		$this->view->put('CONTENT', $table->display());

		return $table->get_page_number();
	}

    private function build_warnings()
    {
        $this->view = new FileTemplate('financial/FinancialWarningsController.tpl');
        $this->view->add_lang(LangLoader::get_all_langs('financial'));
        $c_clubs = ModulesManager::is_module_installed('lamclubs') && ModulesManager::is_module_activated('lamclubs');

        $this->view->put_all(array(
            'C_NO_LAMCLUBS' => !$c_clubs
        ));
    }

	private function check_authorizations()
	{
		if (!FinancialAuthorizationsService::check_authorizations()->read())
		{
			$error_controller = PHPBoostErrors::user_not_authorized();
			DispatchManager::redirect($error_controller);
		}
	}

	private function generate_response($page = 1)
	{
		$response = new SiteDisplayResponse($this->view);
		$graphical_environment = $response->get_graphical_environment();
		$graphical_environment->set_page_title($this->lang['financial.monitoring'], $page);
		$graphical_environment->get_seo_meta_data()->set_description(StringVars::replace_vars($this->lang['financial.seo.description.root'], array('site' => GeneralConfig::load()->get_site_name())));
		$graphical_environment->get_seo_meta_data()->set_canonical_url(FinancialUrlBuilder::home());

		$breadcrumb = $graphical_environment->get_breadcrumb();
		$breadcrumb->add($this->lang['financial.module.title'], FinancialUrlBuilder::home());
		$breadcrumb->add($this->lang['financial.monitoring'], FinancialUrlBuilder::home());

		return $response;
	}
}
?>
