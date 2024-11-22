<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Julien BRISWALTER <j1.seth@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2022 12 14
 * @since       PHPBoost 4.0 - 2014 08 24
 * @contributor Kevin MASSY <reidlos@phpboost.com>
 * @contributor Arnaud GENET <elenwii@phpboost.com>
 * @contributor Sebastien LARTIGUE <babsolune@phpboost.com>
*/

class FinancialBudgetArchivesController extends DefaultModuleController
{

	protected function get_template_to_use()
	{
		return new FileTemplate('financial/FinancialBudgetArchivesController.tpl');
	}

	public function execute(HTTPRequestCustom $request)
	{
		$this->check_authorizations();

		$this->build_view($request);

		return $this->generate_response($request);
	}

	private function build_view(HTTPRequestCustom $request)
	{
        $budget_archive_tables = PersistenceContext::get_dbms_utils()->list_module_tables('financial_budget_');
        $requested_year = !is_null($request->get_value('year', '')) ? $request->get_value('year', '') : '';
        $this->view->put_all(array(
            'C_YEAR_SELECTED' => !empty($budget_archive_tables) && !empty($requested_year),
            'C_NO_TABLES'  => empty($budget_archive_tables),
            'YEAR_TITLE' => $requested_year,

        ));

        $table = PREFIX . 'financial_budget_' . $requested_year;
        if (in_array($table, $budget_archive_tables))
        {
            $this->view->put('C_TABLE_EXISTS', true);

            $result_thead = PersistenceContext::get_querier()->select('SHOW COLUMNS FROM ' . $table);
            while($row = $result_thead->fetch())
            {
                if(in_array($row['Field'], array('budget_domain', 'budget_type', 'annual_amount', 'real_amount', 'unit_amount', 'quantity', 'real_quantity')))
                    $this->view->assign_block_vars('thead', array(
                        'TH' => $this->lang['financial.budget.archive.th.'. $row['Field']]
                    ));
            }
            $result = PersistenceContext::get_querier()->select('SELECT * FROM ' . PREFIX . 'financial_budget_' . $requested_year);
            while($row = $result->fetch())
            {
                $this->view->assign_block_vars('tbody', array(
                    'C_DOMAIN' => isset($row['budget_domain']),
                    'C_NAME' => isset($row['budget_type']),
                    'C_ANNUAL_AMOUNT' => isset($row['annual_amount']),
                    'C_REAL_AMOUNT' => isset($row['real_amount']),
                    'C_UNIT_AMOUNT' => isset($row['unit_amount']),
                    'C_QUANTITY' => isset($row['quantity']),
                    'C_REAL_QUANTITY' => isset($row['real_quantity']),

                    'DOMAIN' => isset($row['budget_domain']) ? $row['budget_domain'] : '',
                    'NAME' => isset($row['budget_type']) ? $row['budget_type'] : '',
                    'ANNUAL_AMOUNT' => isset($row['annual_amount']) ? $row['annual_amount'] : '',
                    'REAL_AMOUNT' => isset($row['real_amount']) ? $row['real_amount'] : '',
                    'UNIT_AMOUNT' => isset($row['unit_amount']) ? $row['unit_amount'] :'',
                    'QUANTITY' => isset($row['quantity']) ? $row['quantity'] : '',
                    'REAL_QUANTITY' => isset($row['real_quantity']) ? $row['real_quantity'] : ''
                ));
            }
        }
        else {
            $this->view->put('C_TABLE_EXISTS', false);
        }
        
        if (count($budget_archive_tables) > 1 || empty($requested_year))
            $this->build_year_form($request);
    }

	private function build_year_form(HTTPRequestCustom $request)
	{
        $requested_year = $request->get_value('year', '');
		$form = new HTMLForm(__CLASS__, '', false);
		$form->set_css_class('options');

		$fieldset = new FormFieldsetHorizontal('filters', array('description' => $this->lang ['financial.display.year']));
		$form->add_fieldset($fieldset);

        $budget_archive_tables = PersistenceContext::get_dbms_utils()->list_module_tables('financial_budget_');
        if (in_array(PREFIX . 'financial_budget_' . $requested_year, $budget_archive_tables))
            $current_year = $requested_year;
        else
            $current_year = '';

        $years = [];
        $years[] = new FormFieldSelectChoiceOption('', '');
        foreach($budget_archive_tables as $budget)
        {
            $table_year = explode('_', $budget);
            $year = end($table_year);
            $years[] = new FormFieldSelectChoiceOption($year, $year);
        }

		$fieldset->add_field(new FormFieldSimpleSelectChoice('year', '', $current_year, $years,
			array(
                'events' => array('change' => '
                    document.location = "'. TPL_PATH_TO_ROOT . '/financial/budgets/" + HTMLForms.getField("year").getValue() + "/"
                ')
            )
        ));

		$this->view->put('YEARS_FORM', $form->display());
	}

	private function check_authorizations()
	{
	}

	private function generate_response(HTTPRequestCustom $request)
	{
		$response = new SiteDisplayResponse($this->view);

		$graphical_environment = $response->get_graphical_environment();

		$graphical_environment->set_page_title($this->lang['financial.module.title'], '');

		$description = StringVars::replace_vars($this->lang['financial.seo.description.root'], array('site' => GeneralConfig::load()->get_site_name()));
		$graphical_environment->get_seo_meta_data()->set_description($description);
		$graphical_environment->get_seo_meta_data()->set_canonical_url(FinancialUrlBuilder::display_archived_budgets($request->get_getvalue('year', '')));

		$breadcrumb = $graphical_environment->get_breadcrumb();
		$breadcrumb->add($this->lang['financial.module.title'], FinancialUrlBuilder::home());
		$breadcrumb->add($this->lang['financial.archived.budget'], FinancialUrlBuilder::display_archived_budgets($request->get_getvalue('year', '')));

		return $response;
	}
}
?>
