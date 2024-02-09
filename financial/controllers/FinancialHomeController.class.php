<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class FinancialHomeController extends DefaultModuleController
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
			new HTMLTableColumn($this->lang['financial.budget.amount'], ''),
			new HTMLTableColumn($this->lang['financial.budget.available'], ''),
			new HTMLTableColumn($this->lang['financial.request.access'], ''),
			new HTMLTableColumn('')
		);

		$table_model = new SQLHTMLTableModel(FinancialSetup::$financial_budget_table, 'items-list', $columns, new HTMLTableSortingRule('id', HTMLTableSortingRule::ASC));

		$table_model->set_layout_title($this->lang['financial.module.title']);

		$table = new HTMLTable($table_model);
		$table->set_filters_fieldset_class_HTML();
        $table->hide_multiple_delete();

		$results = array();
		$result = $table_model->get_sql_results('budget');

		$budgets = array();
		$moderation_link_number = 0;
		foreach ($result as $row)
		{
			$budget = new FinancialBudgetItem();
			$budget->set_properties($row);
			$budgets[] = $budget;
			if ($budget->is_authorized_to_edit() || $budget->is_authorized_to_delete())
			{
				$moderation_link_number++;
			}
		}

		if (empty($moderation_link_number))
		{
			$table_model->delete_last_column();
		}

		foreach ($budgets as $budget)
		{
			$edit_link = new EditLinkHTMLElement(FinancialUrlBuilder::edit_budget($budget->get_id()));
			$edit_link = $budget->is_authorized_to_edit() ? $edit_link->display() : '';

			$delete_link = new DeleteLinkHTMLElement(FinancialUrlBuilder::delete_budget($budget->get_id()), '', array('data-confirmation' => 'delete-element'));
			$delete_link = $budget->is_authorized_to_delete() ? $delete_link->display() : '';
            $id = '<span class="hidden">' . $budget->get_id() . '</span>';

            $amount = '';
            if(!empty($budget->get_amount()))
            {
                $amount .= $budget->get_amount();
                if ($budget->get_use_dl())
                    $amount .= $this->lang['financial.bill'];
                if ($budget->get_max_amount())
                    $amount .= StringVars::replace_vars($this->lang['financial.bill.max.amount'], array('max_amount' => $budget->get_max_amount()));
            }

            $quantity = '';
            if($budget->get_quantity() !== '')
            {
                if($budget->get_real_quantity() == $budget->get_temp_quantity())
                    $quantity .= $budget->get_real_quantity() . '/';
                else
                    $quantity .= $budget->get_temp_quantity() . '/';
                $quantity .= $budget->get_quantity();
            }

			$br = new BrHTMLElement();
            $description = !empty($budget->get_description()) ? $br->display() . '<span class="smaller text-italic">' . $budget->get_description() . '</span>' : '';

            $row = array(
                new HTMLTableRowCell($budget->get_domain(), 'small'),
                new HTMLTableRowCell($budget->get_name() . $description, 'big align-left'),
                new HTMLTableRowCell($amount),
                new HTMLTableRowCell($quantity),
                new HTMLTableRowCell(new LinkHTMLElement(FinancialUrlBuilder::add_item($budget->get_id()), $this->lang['financial.request.choice'], array(), 'small button')),
                $moderation_link_number ? new HTMLTableRowCell($edit_link . $delete_link . $id, 'controls') : null
            );

            $table_row = new HTMLTableRow($row);
            if (in_array($budget->get_id(), $this->hide_delete_input))
                $table_row->hide_delete_input();

            $results[] = $table_row;
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
		$graphical_environment->set_page_title($this->lang['financial.module.title'], $page);
		$graphical_environment->get_seo_meta_data()->set_description(StringVars::replace_vars($this->lang['financial.seo.description.root'], array('site' => GeneralConfig::load()->get_site_name())));
		$graphical_environment->get_seo_meta_data()->set_canonical_url(FinancialUrlBuilder::home());

		$breadcrumb = $graphical_environment->get_breadcrumb();
		$breadcrumb->add($this->lang['financial.module.title'], FinancialUrlBuilder::home());

		return $response;
	}

	public static function get_view()
	{
		$object = new self('financial');
		$object->check_authorizations();
		$object->build_table();
		return $object->view;
	}
}
?>
