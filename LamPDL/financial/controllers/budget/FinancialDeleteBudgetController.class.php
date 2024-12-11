<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 11
 * @since       PHPBoost 6.0 - 2020 01 18
 */

class FinancialDeleteBudgetController extends DefaultModuleController
{
    public function execute(HTTPRequestCustom $request)
    {
        AppContext::get_session()->csrf_get_protect();

        $budget = $this->get_budget($request);

        if (!$budget->is_authorized_to_delete() || AppContext::get_current_user()->is_readonly())
        {
            $error_controller = PHPBoostErrors::user_not_authorized();
            DispatchManager::redirect($error_controller);
        }

        FinancialBudgetService::delete_budget($budget->get_id());

        if (!FinancialAuthorizationsService::check_authorizations()->write() && FinancialAuthorizationsService::check_authorizations()->contribution()) ContributionService::generate_cache();

        FinancialBudgetService::clear_cache();
        HooksService::execute_hook_action('delete', self::$module_id, $budget->get_properties());

        AppContext::get_response()->redirect(FinancialUrlBuilder::home(), StringVars::replace_vars($this->lang['planning.message.success.delete'], array('title' => $budget->get_name())));
    }

    private function get_budget(HTTPRequestCustom $request)
    {
        $id = $request->get_getint('id', 0);
        if (!empty($id))
        {
            try
                {
                    return FinancialBudgetService::get_budget($id);
                }
            catch (RowNotFoundException $e)
                {
                    $error_controller = PHPBoostErrors::unexisting_page();
                    DispatchManager::redirect($error_controller);
                }
        }
    }
}
?>
