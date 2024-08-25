<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class FinancialRequestService
{
	private static $db_querier;

	public static function __static()
	{
		self::$db_querier = PersistenceContext::get_querier();
	}

	/**
	 * @desc Create a new item.
	 * @param FinancialRequestItem $item new FinancialRequestItem
	 */
	public static function add_item(FinancialRequestItem $item)
	{
		$result = self::$db_querier->insert(FinancialSetup::$financial_request_table, $item->get_properties());

		return $result->get_last_inserted_id();
	}

	/**
	 * @desc Update an item.
	 * @param FinancialRequestItem $item FinancialRequestItem to update
	 */
	public static function update_item(FinancialRequestItem $item)
	{
		self::$db_querier->update(FinancialSetup::$financial_request_table, $item->get_properties(), 'WHERE id = :id', array(
			'id' => $item->get_id()
		));

		return $item->get_id();
	}

	/**
	 * @desc Delete an item.
	 * @param int $id id of the item
	 */
	public static function delete_item(int $id)
	{
		if (AppContext::get_current_user()->is_readonly())
		{
			$controller = PHPBoostErrors::user_in_read_only();
			DispatchManager::redirect($controller);
		}

		self::$db_querier->delete(FinancialSetup::$financial_request_table, 'WHERE id = :id', array('id' => $id));

		PersistenceContext::get_querier()->delete(DB_TABLE_EVENTS, 'WHERE module=:module AND id_in_module=:id', array('module' => 'financial', 'id' => $id));
    }

	/**
	 * @desc Return the content of an item.
	 * @param int $id Item identifier
	 */
	public static function get_item(int $id)
	{
		$row = self::$db_querier->select_single_row_query('SELECT *
		FROM ' . FinancialSetup::$financial_request_table . ' planning
		LEFT JOIN ' . DB_TABLE_MEMBER . ' author ON author.user_id = planning.author_user_id
		WHERE planning.id = :id', array(
			'id' => $id
		));

		$item = new FinancialRequestItem();
		$item->set_properties($row);

		return $item;
	}

	/**
	 * @desc Clears all module elements in cache.
	 */
	public static function clear_cache()
	{
		Feed::clear_cache('financial');
	}
}
?>