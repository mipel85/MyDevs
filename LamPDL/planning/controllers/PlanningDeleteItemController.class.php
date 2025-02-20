<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 11
 * @since       PHPBoost 6.0 - 2020 01 18
 */

class PlanningDeleteItemController extends DefaultModuleController
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

        PlanningService::delete_item($item->get_id());

        if (!categoriesAuthorizationsService::check_authorizations()->write() && categoriesAuthorizationsService::check_authorizations()->contribution()) ContributionService::generate_cache();

        HooksService::execute_hook_action('delete', self::$module_id, $item->get_properties());

        $c_root_category = $item->get_category()->get_id() == Category::ROOT_CATEGORY;
        $title = $c_root_category ? $item->get_activity_other() : $item->get_category()->get_name();
        AppContext::get_response()->redirect(($request->get_url_referrer() && !TextHelper::strstr($request->get_url_referrer(), PlanningUrlBuilder::display($item->get_category()->get_id(), $item->get_category()->get_rewrited_name(), $item->get_id(), $item->get_rewrited_link())->rel()) ? $request->get_url_referrer() : PlanningUrlBuilder::home()), StringVars::replace_vars($this->lang['planning.message.success.delete'], array('title' => $title)));
    }

    private function get_item(HTTPRequestCustom $request)
    {
        $id = $request->get_getint('id', 0);
        if (!empty($id))
        {
            try
                {
                    return PlanningService::get_item($id);
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
