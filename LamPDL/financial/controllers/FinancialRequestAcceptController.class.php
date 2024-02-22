<?php
/*
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 02 09
 * @since       PHPBoost 6.0 - 2024 02 09
 */
class FinancialRequestAcceptController extends DefaultModuleController
{
    public function execute(HTTPRequestCustom $request)
	{
		$item = $this->get_item($request);

		if (!$item->is_authorized_to_delete() || AppContext::get_current_user()->is_readonly())
		{
			$error_controller = PHPBoostErrors::user_not_authorized();
			DispatchManager::redirect($error_controller);
		}
        $budget = FinancialBudgetService::get_budget($item->get_budget_id());

        if ($request->get_value('amount_paid', '') !== '')
        {
            if(($budget->get_annual_amount() - $request->get_value('amount_paid', '')) >= 0)
            {
                FinancialMonitoringService::request_payment($item->get_id(), $request->get_value('amount_paid', ''));
                AppContext::get_response()->redirect(
                    ($request->get_url_referrer() && !TextHelper::strstr($request->get_url_referrer(), FinancialUrlBuilder::home()->rel()) ? $request->get_url_referrer() : FinancialUrlBuilder::display_pending_items()), 
                    StringVars::replace_vars($this->lang['financial.message.success.accept'], array('title' => $item->get_title())));
            }
            else
                AppContext::get_response()->redirect(
                    ($request->get_url_referrer() && !TextHelper::strstr($request->get_url_referrer(), FinancialUrlBuilder::home()->rel()) ? $request->get_url_referrer() : FinancialUrlBuilder::display_pending_items()), 
                    StringVars::replace_vars($this->lang['financial.message.error.accept'], array('title' => $item->get_title())), MessageHelper::ERROR);
        }
        else
            AppContext::get_response()->redirect(
                ($request->get_url_referrer() && !TextHelper::strstr($request->get_url_referrer(), FinancialUrlBuilder::home()->rel()) ? $request->get_url_referrer() : FinancialUrlBuilder::display_pending_items()), 
                StringVars::replace_vars($this->lang['financial.message.empty.accept'], array('title' => $item->get_title())), MessageHelper::ERROR);

		FinancialRequestService::clear_cache();
	}

	private function get_item(HTTPRequestCustom $request)
	{
		$id = $request->get_getint('id', 0);
		if (!empty($id))
		{
			try {
				return FinancialRequestService::get_item($id);
			} catch (RowNotFoundException $e) {
				$error_controller = PHPBoostErrors::unexisting_page();
				DispatchManager::redirect($error_controller);
			}
		}
	}
}
?>