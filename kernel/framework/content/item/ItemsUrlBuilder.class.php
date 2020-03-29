<?php
/**
 * @package     Content
 * @subpackage  Item
 * @copyright   &copy; 2005-2020 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Julien BRISWALTER <j1.seth@phpboost.com>
 * @version     PHPBoost 5.3 - last update: 2020 02 18
 * @since       PHPBoost 5.3 - 2019 12 20
*/

class ItemsUrlBuilder
{
	protected static function get_module_id($module_id = '')
	{
		return !empty($module_id) ? $module_id : Environment::get_running_module_name();
	}

	protected static function get_dispatcher($module_id = '')
	{
		return '/' . self::get_module_id($module_id);
	}

	/**
	 * @return Url
	 */
	public static function manage($module_id = '')
	{
		return DispatchManager::get_url(self::get_dispatcher($module_id), '/manage/');
	}

	/**
	 * @return Url
	 */
	public static function add($id_category = null, $module_id = '', $additional_parameter = null)
	{
		$id_category = !empty($id_category) ? $id_category . '/' : '';
		$additional_parameter = (!empty($additional_parameter) ? ((is_int($additional_parameter) && $additional_parameter > 1) || !is_int($additional_parameter) ? $additional_parameter . '/' : '') : '');
		return DispatchManager::get_url(self::get_dispatcher($module_id), '/add/' . $id_category . $additional_parameter);
	}

	/**
	 * @return Url
	 */
	public static function edit($id, $module_id = '', $additional_parameter = null)
	{
		$additional_parameter = (!empty($additional_parameter) ? ((is_int($additional_parameter) && $additional_parameter > 1) || !is_int($additional_parameter) ? $additional_parameter . '/' : '') : '');
		return DispatchManager::get_url(self::get_dispatcher($module_id), '/'. $id .'/edit/' . $additional_parameter);
	}

	/**
	 * @return Url
	 */
	public static function delete($id, $module_id = '', $additional_parameter = null)
	{
		$additional_parameter = (!empty($additional_parameter) ? ((is_int($additional_parameter) && $additional_parameter > 1) || !is_int($additional_parameter) ? $additional_parameter . '/' : '') : '');
		return DispatchManager::get_url(self::get_dispatcher($module_id), '/' . $id . '/delete/' . $additional_parameter . '?token=' . AppContext::get_session()->get_token());
	}

	/**
	 * @return Url
	 */
	public static function display($id_category, $rewrited_name_category, $id, $rewrited_name, $module_id = '', $anchor = '', $additional_parameter = null)
	{
		$additional_parameter = (!empty($additional_parameter) ? ((is_int($additional_parameter) && $additional_parameter > 1) || !is_int($additional_parameter) ? $additional_parameter . '/' : '') : '');
		return DispatchManager::get_url(self::get_dispatcher($module_id), '/' . $id_category . '-' . $rewrited_name_category . '/' . $id . '-' . $rewrited_name . '/' . $additional_parameter . $anchor);
	}
	/**
	 * @return Url
	 */
	public static function display_item($id, $rewrited_title, $module_id = '', $anchor = '', $additional_parameter = null)
	{
		$additional_parameter = (!empty($additional_parameter) ? ((is_int($additional_parameter) && $additional_parameter > 1) || !is_int($additional_parameter) ? $additional_parameter . '/' : '') : '');
		return DispatchManager::get_url(self::get_dispatcher($module_id), '/' . $id . '-' . $rewrited_title . '/' . $additional_parameter . $anchor);
	}

	/**
	 * @return Url
	 */
	public static function display_comments($id_category, $rewrited_name_category, $id, $rewrited_title, $module_id = '')
	{
		return self::display($id_category, $rewrited_name_category, $id, $rewrited_title, '#comments-list', $module_id);
	}

	/**
	 * @return Url
	 */
	public static function display_item_comments($id, $rewrited_title, $module_id = '')
	{
		return self::display_item($id, $rewrited_title, '#comments-list', $module_id);
	}

	/**
	 * @return Url
	 */
	public static function display_category($id, $rewrited_name, $module_id = '', $sort_field = '', $sort_mode = '', $page = 1, $subcategories_page = 1)
	{
		$category = $id > 0 ? $id . '-' . $rewrited_name . '/' : '';
		$sort_field = $sort_field !== '' ? $sort_field . '/' : '';
		$sort_mode = $sort_mode !== '' ? $sort_mode . '/' : '';
		$page = $page !== 1 || $subcategories_page !== 1 ? $page . '/' : '';
		$subcategories_page = $subcategories_page !== 1 ? $subcategories_page . '/' : '';
		return DispatchManager::get_url(self::get_dispatcher($module_id), '/' . $category . $sort_field . $sort_mode . $page . $subcategories_page);
	}

	/**
	 * @return Url
	 */
	public static function display_tag($rewrited_name, $module_id = '', $sort_field = '', $sort_mode = '', $page = 1)
	{
		$sort_field = $sort_field !== '' ? $sort_field . '/' : '';
		$sort_mode = $sort_mode !== '' ? $sort_mode . '/' : '';
		$page = $page !== 1 ? $page . '/' : '';
		return DispatchManager::get_url(self::get_dispatcher($module_id), '/tag/' . $rewrited_name . '/' . $sort_field . $sort_mode . $page);
	}

	/**
	 * @return Url
	 */
	public static function display_pending($module_id = '', $sort_field = '', $sort_mode = '', $page = 1)
	{
		$sort_field = $sort_field !== '' ? $sort_field . '/' : '';
		$sort_mode = $sort_mode !== '' ? $sort_mode . '/' : '';
		$page = $page !== 1 ? $page . '/' : '';
		return DispatchManager::get_url(self::get_dispatcher($module_id), '/pending/' . $sort_field . $sort_mode . $page);
	}
}
?>
