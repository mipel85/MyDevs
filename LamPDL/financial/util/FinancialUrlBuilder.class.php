<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 14
 * @since       PHPBoost 6.0 - 2020 01 18
 */

class FinancialUrlBuilder
{
    const DEFAULT_SORT_FIELD   = 'date';
    const DEFAULT_SORT_MODE    = 'desc';
    private static $dispatcher = '/financial';

    public static function configuration() : Url
    {
        return DispatchManager::get_url(self::$dispatcher, '/admin/config');
    }

    public static function display_archived_budgets($year) : Url
    {
        return DispatchManager::get_url(self::$dispatcher, '/budgets/' . $year . '/');
    }

    public static function display_archived_requests($year) : Url
    {
        return DispatchManager::get_url(self::$dispatcher, '/requests/' . $year . '/');
    }

    public static function add_budget() : Url
    {
        return DispatchManager::get_url(self::$dispatcher, '/add_budget/');
    }

    public static function edit_budget($id) : Url
    {
        return DispatchManager::get_url(self::$dispatcher, '/' . $id . '/edit_budget/');
    }

    public static function delete_budget($id) : Url
    {
        return DispatchManager::get_url(self::$dispatcher, '/' . $id . '/delete_budget/?' . 'token=' . AppContext::get_session()->get_token());
    }

    public static function display($item_id, $rewrited_title) : Url
    {
        return DispatchManager::get_url(self::$dispatcher, '/' . $item_id . '-' . $rewrited_title . '/');
    }

    public static function display_pending_items($page = 1) : Url
    {
        $page = $page !== 1 ? $page . '/' : '';
        return DispatchManager::get_url(self::$dispatcher, '/pending/' . $page);
    }

    public static function display_member_items($user_id, $page = 1) : Url
    {
        $page = $page !== 1 ? $page . '/' : '';
        return DispatchManager::get_url(self::$dispatcher, '/member/' . $user_id . '/' . $page);
    }

    public static function display_club_items($club_id, $page = 1) : Url
    {
        $page = $page !== 1 ? $page . '/' : '';
        return DispatchManager::get_url(self::$dispatcher, '/club/' . $club_id . '/' . $page);
    }

    public static function display_monitoring_items($page = 1) : Url
    {
        $page = $page !== 1 ? $page . '/' : '';
        return DispatchManager::get_url(self::$dispatcher, '/monitoring/' . '/' . $page);
    }

    public static function add_item($budget_id) : Url
    {
        return DispatchManager::get_url(self::$dispatcher, '/add/' . $budget_id);
    }

    public static function edit_item($id, $budget_id) : Url
    {
        return DispatchManager::get_url(self::$dispatcher, '/edit/' . $id . '/' . $budget_id . '/');
    }

    public static function delete_item($id) : Url
    {
        return DispatchManager::get_url(self::$dispatcher, '/' . $id . '/delete/?' . 'token=' . AppContext::get_session()->get_token());
    }

    public static function dl_estimate($id) : Url
    {
        return DispatchManager::get_url(self::$dispatcher, '/estimate/' . $id);
    }

    public static function dl_invoice($id) : Url
    {
        return DispatchManager::get_url(self::$dispatcher, '/invoice/' . $id);
    }

    public static function reject_request($id) : Url
    {
        return DispatchManager::get_url(self::$dispatcher, '/reject/' . $id);
    }

    public static function ongoing_request($id) : Url
    {
        return DispatchManager::get_url(self::$dispatcher, '/ongoing/' . $id);
    }

    public static function accept_request($id, $amount_paid) : Url
    {
        return DispatchManager::get_url(self::$dispatcher, '/accept/' . $id . '/' . $amount_paid);
    }

    public static function requests_monitoring_chart() : Url
    {
        return DispatchManager::get_url(self::$dispatcher, '/requests_monitoring_chart/');
    }

    public static function requests_monitoring_list($year) : Url
    {
        return DispatchManager::get_url(self::$dispatcher, '/requests_monitoring_list/' . $year . '/');
    }

    public static function home() : Url
    {
        return DispatchManager::get_url(self::$dispatcher, '/');
    }
}
?>
