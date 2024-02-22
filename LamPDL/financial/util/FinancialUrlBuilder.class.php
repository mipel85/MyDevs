<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class FinancialUrlBuilder
{
	const DEFAULT_SORT_FIELD = 'date';
	const DEFAULT_SORT_MODE = 'desc';

	private static $dispatcher = '/financial';

	/**
	 * @return Url
	 */
	public static function configuration()
	{
		return DispatchManager::get_url(self::$dispatcher, '/admin/config');
	}

	/**
	 * @return Url
	 */
	public static function manage_budgets()
	{
		return DispatchManager::get_url(self::$dispatcher, '/manage_budgets/');
	}

	/**
	 * @return Url
	 */
	public static function add_budget()
	{
		return DispatchManager::get_url(self::$dispatcher, '/add_budget/');
	}

	/**
	 * @return Url
	 */
	public static function edit_budget($id)
	{
		return DispatchManager::get_url(self::$dispatcher, '/' . $id . '/edit_budget/');
	}

	/**
	 * @return Url
	 */
	public static function delete_budget($id)
	{
		return DispatchManager::get_url(self::$dispatcher, '/' . $id . '/delete_budget/?' . 'token=' . AppContext::get_session()->get_token());
	}

	/**
	 * @return Url
	 */
	public static function archived_items()
	{
		return DispatchManager::get_url(self::$dispatcher, '/archived/');
	}

	/**
	 * @return Url
	 */
	public static function display($item_id, $rewrited_title)
	{
		return DispatchManager::get_url(self::$dispatcher, '/' . $item_id . '-' . $rewrited_title . '/');
	}

	/**
	 * @return Url
	 */
	public static function display_pending_items($page = 1)
	{
		$page = $page !== 1 ? $page . '/' : '';
		return DispatchManager::get_url(self::$dispatcher, '/pending/' . $page);
	}

	public static function display_member_items($user_id, $page = 1)
	{
		$page = $page !== 1 ? $page . '/' : '';
		return DispatchManager::get_url(self::$dispatcher, '/member/' . $user_id . '/'  . $page);
	}

	public static function display_archived_items($page = 1)
	{
		$page = $page !== 1 ? $page . '/' : '';
		return DispatchManager::get_url(self::$dispatcher, '/archived/' . '/'  . $page);
	}

	public static function display_monitoring_items($page = 1)
	{
		$page = $page !== 1 ? $page . '/' : '';
		return DispatchManager::get_url(self::$dispatcher, '/monitoring/' . '/'  . $page);
	}

	public static function add_item($budget_id)
	{
		return DispatchManager::get_url(self::$dispatcher, '/add/' . $budget_id);
	}

	/**
	 * @return Url
	 */
	public static function edit_item($id, $budget_id)
	{
		return DispatchManager::get_url(self::$dispatcher,'/edit/' . $id . '/' . $budget_id . '/');
	}

	/**
	 * @return Url
	 */
	public static function delete_item($id)
	{
		return DispatchManager::get_url(self::$dispatcher, '/' . $id . '/delete/?' . 'token=' . AppContext::get_session()->get_token());
	}

	/**
	 * @return Url
	 */
	public static function dl_estimate($id)
	{
		return DispatchManager::get_url(self::$dispatcher, '/estimate/' . $id);
	}

	/**
	 * @return Url
	 */
	public static function dl_invoice($id)
	{
		return DispatchManager::get_url(self::$dispatcher, '/invoice/' . $id);
	}

	/**
	 * @return Url
	 */
	public static function reject_request($id)
	{
		return DispatchManager::get_url(self::$dispatcher, '/reject/' . $id);
	}

	/**
	 * @return Url
	 */
	public static function ongoing_request($id)
	{
		return DispatchManager::get_url(self::$dispatcher, '/ongoing/' . $id);
	}

	/**
	 * @return Url
	 */
	public static function accept_request($id, $amount_paid)
	{
		return DispatchManager::get_url(self::$dispatcher, '/accept/' . $id . '/' . $amount_paid);
	}

	/**
	 * @return Url
	 */
	public static function home()
	{
		return DispatchManager::get_url(self::$dispatcher, '/');
	}
}
?>
