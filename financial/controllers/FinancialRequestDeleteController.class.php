<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class FinancialRequestDeleteController extends DefaultModuleController
{
	public function execute(HTTPRequestCustom $request)
	{
		AppContext::get_session()->csrf_get_protect();

		$item = $this->get_item($request);

		if (!$item->is_authorized_to_delete() || AppContext::get_current_user()->is_readonly())
		{
			$error_controller = PHPBoostErrors::user_not_authorized();
			DispatchManager::redirect($error_controller);
		}

        if ($item->get_agreement_state() == FinancialRequestItem::PENDING || $item->get_agreement_state() == FinancialRequestItem::ONGOING)
            FinancialMonitoringService::delete_pending_request($item->get_id());

		FinancialRequestService::delete_item($item->get_id());

		if (!FinancialAuthorizationsService::check_authorizations()->write() && FinancialAuthorizationsService::check_authorizations()->contribution())
			ContributionService::generate_cache();

		FinancialRequestService::clear_cache();
		HooksService::execute_hook_action('delete', self::$module_id, $item->get_properties());

        AppContext::get_response()->redirect(
            ($request->get_url_referrer() && !TextHelper::strstr($request->get_url_referrer(), FinancialUrlBuilder::home()->rel()) ? $request->get_url_referrer() : FinancialUrlBuilder::display_pending_items()), 
            StringVars::replace_vars($this->lang['financial.message.success.delete'], array('title' => $item->get_title())));
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
