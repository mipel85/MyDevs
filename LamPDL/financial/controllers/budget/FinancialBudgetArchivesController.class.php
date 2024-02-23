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
        $this->build_sorting_form($request);
    }

	private function build_sorting_form(HTTPRequestCustom $request)
	{
        $year = $request->get_value('year', '');
		$form = new HTMLForm(__CLASS__, '', false);
		$form->set_css_class('options');

		$fieldset = new FormFieldsetHorizontal('filters', array('description' => $this->lang ['financial.display.year']));
		$form->add_fieldset($fieldset);

        $budget_archive_tables = PersistenceContext::get_dbms_utils()->list_module_tables('financial_budget_');

        $years = [];
        foreach($budget_archive_tables as $budget)
        {
            $table_year = explode('_', $budget);
            $year = end($table_year);
            $years[] = new FormFieldSelectChoiceOption($year, $year);
        }

		$fieldset->add_field(new FormFieldSimpleSelectChoice('year', '', $year, $years,
			array(
                'select_to_list' => true, 
                'events' => array('change' => '
                    document.location = "'. FinancialUrlBuilder::display_archived_budgets(` + 'HTMLForms.getField("year").getValue()' + `)->rel() . '"
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
		$graphical_environment->get_seo_meta_data()->set_canonical_url(FinancialUrlBuilder::display_archived_budgets($request->get_getvalue('year')));

		$breadcrumb = $graphical_environment->get_breadcrumb();
		$breadcrumb->add($this->lang['financial.module.title'], FinancialUrlBuilder::home());

		return $response;
	}
}
?>
