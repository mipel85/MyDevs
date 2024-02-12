<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class FinancialBudgetFormController extends DefaultModuleController
{
	public function execute(HTTPRequestCustom $request)
	{
		$this->check_authorizations();

		$this->build_form($request);

		if ($this->submit_button->has_been_submited() && $this->form->validate())
		{
			$this->save();
			$this->redirect();
		}

		$this->view->put('CONTENT', $this->form->display());

		return $this->generate_response($this->view);
	}

	private function build_form(HTTPRequestCustom $request)
	{
		$budget = $this->get_budget();

		$form = new HTMLForm(__CLASS__);
		$form->set_layout_title($budget->get_id() === null ? $this->lang['financial.budget.add'] : $this->lang['financial.budget.edit']);

		$fieldset = new FormFieldsetHTML('budget', $this->lang['form.parameters']);
		$form->add_fieldset($fieldset);

		$fieldset->add_field(new FormFieldTextEditor('domain', $this->lang['financial.budget.domain'], $this->get_budget()->get_domain(),
			array('required' => true)
		));

		$fieldset->add_field(new FormFieldTextEditor('name', $this->lang['financial.budget.name'], $this->get_budget()->get_name(),
			array('required' => true)
		));

		$fieldset->add_field(new FormFieldTextEditor('fiscal_year', $this->lang['financial.budget.fiscal.year'], $this->get_budget()->get_fiscal_year(),
            array('required' => true, 'pattern' => '[0-9]{4}')
        ));

		$fieldset->add_field(new FormFieldNumberEditor('annual_amount', $this->lang['financial.budget.annual.amount'], $this->get_budget()->get_annual_amount(),
			array('required' => true)
		));

		$fieldset->add_field(new FormFieldTextEditor('unit_amount', $this->lang['financial.budget.amount'], $this->get_budget()->get_unit_amount()));

		$fieldset->add_field(new FormFieldTextEditor('max_amount', $this->lang['financial.budget.max.amount'], $this->get_budget()->get_max_amount()));

		$fieldset->add_field(new FormFieldNumberEditor('quantity', $this->lang['financial.budget.quantity'], $this->get_budget()->get_quantity()));

        $fieldset->add_field(new FormFieldCheckbox('use_dl', $this->lang['financial.budget.upload'], $this->get_budget()->get_use_dl()));

        $fieldset->add_field(new FormFieldCheckbox('bill_needed', $this->lang['financial.budget.invoice.required'], $this->get_budget()->get_bill_needed()));

		$fieldset->add_field(new FormFieldMultiLineTextEditor('description', $this->lang['financial.budget.description'], $this->get_budget()->get_description()));

		$fieldset->add_field(new FormFieldHidden('referrer', $request->get_url_referrer()));

		$this->submit_button = new FormButtonDefaultSubmit();
		$form->add_button($this->submit_button);
		$form->add_button(new FormButtonReset());

		$this->form = $form;
	}

	private function get_budget()
	{
		if ($this->item === null)
		{
			$id = AppContext::get_request()->get_getint('id', 0);
			if (!empty($id))
			{
				try {
					$this->item = FinancialBudgetService::get_budget($id);
				} catch (RowNotFoundException $e) {
					$error_controller = PHPBoostErrors::unexisting_page();
					DispatchManager::redirect($error_controller);
				}
			}
			else
			{
				$this->is_new_item = true;
				$this->item = new FinancialBudgetItem();
            }
		}
		return $this->item;
	}

	private function check_authorizations()
	{
		$budget = $this->get_budget();

		if ($budget->get_id() === null)
		{
			if (!$budget->is_authorized_to_add())
			{
				$error_controller = PHPBoostErrors::user_not_authorized();
				DispatchManager::redirect($error_controller);
			}
		}
		else
		{
			if (!$budget->is_authorized_to_edit())
			{
				$error_controller = PHPBoostErrors::user_not_authorized();
				DispatchManager::redirect($error_controller);
			}
		}
		if (AppContext::get_current_user()->is_readonly())
		{
			$error_controller = PHPBoostErrors::user_in_read_only();
			DispatchManager::redirect($error_controller);
		}
	}

	private function save()
	{
		$budget = $this->get_budget();

        $budget->set_domain($this->form->get_value('domain'));
        $budget->set_name($this->form->get_value('name'));

		$budget->set_fiscal_year($this->form->get_value('fiscal_year'));
		$budget->set_annual_amount($this->form->get_value('annual_amount'));
		$budget->set_unit_amount($this->form->get_value('unit_amount'));
		$budget->set_max_amount($this->form->get_value('max_amount'));
        $budget->set_quantity($this->form->get_value('quantity'));
        $budget->set_use_dl($this->form->get_value('use_dl'));
        $budget->set_bill_needed($this->form->get_value('bill_needed'));
		$budget->set_description($this->form->get_value('description'));

		if ($this->is_new_item)
		{
            $budget->set_real_amount($this->form->get_value('annual_amount'));
            $budget->set_temp_amount($this->form->get_value('annual_amount'));
            $budget->set_real_quantity($this->form->get_value('quantity'));
            $budget->set_temp_quantity($this->form->get_value('quantity'));
			$budget_id = FinancialBudgetService::add_budget($budget);
			$budget->set_id($budget_id);
        }
		else
		{
			$budget_id = FinancialBudgetService::update_budget($budget);
        }

		FinancialBudgetService::clear_cache();
	}

	private function redirect()
	{
		$budget = $this->get_budget();
        if ($this->is_new_item)
        {
            AppContext::get_response()->redirect(FinancialUrlBuilder::home(), StringVars::replace_vars($this->lang['financial.message.success.add'], array('name' => $budget->get_name())));
        }
        else
            AppContext::get_response()->redirect(($this->form->get_value('referrer') ? $this->form->get_value('referrer') : FinancialUrlBuilder::home()), StringVars::replace_vars($this->lang['financial.message.success.edit'], array('name' => $budget->get_name())));
	}

	private function generate_response(View $view)
	{
		$budget = $this->get_budget();

		$location_id = $budget->get_id() ? 'budget-edit-'. $budget->get_id() : '';

		$response = new SiteDisplayResponse($view, $location_id);
		$graphical_environment = $response->get_graphical_environment();

		$breadcrumb = $graphical_environment->get_breadcrumb();
		$breadcrumb->add($this->lang['financial.module.title'], FinancialUrlBuilder::home());

		if ($budget->get_id() === null)
		{
			$graphical_environment->set_page_title($this->lang['financial.budget.add'], $this->lang['financial.module.title']);
			$breadcrumb->add($this->lang['financial.budget.add'], FinancialUrlBuilder::add_budget());
			$graphical_environment->get_seo_meta_data()->set_description($this->lang['financial.budget.add']);
			$graphical_environment->get_seo_meta_data()->set_canonical_url(FinancialUrlBuilder::add_budget());
		}
		else
		{
			if (!AppContext::get_session()->location_id_already_exists($location_id))
				$graphical_environment->set_location_id($location_id);

			$graphical_environment->set_page_title($this->lang['financial.budget.edit'], $this->lang['financial.module.title']);

			$breadcrumb->add($this->lang['financial.budget.edit'], FinancialUrlBuilder::edit_budget($budget->get_id()));
			$graphical_environment->get_seo_meta_data()->set_description($this->lang['financial.budget.edit']);
			$graphical_environment->get_seo_meta_data()->set_canonical_url(FinancialUrlBuilder::edit_budget($budget->get_id()));
		}

		return $response;
	}
}
?>
