<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 18
 * @since       PHPBoost 6.0 - 2024 01 18
*/

class LamClubsService
{
	private static $db_querier;
	protected static $module_id = 'LamClubs';

	public static function __static()
	{
		self::$db_querier = PersistenceContext::get_querier();
	}

    /**
	 * @desc Count items number.
	 * @param string $condition (optional) : Restriction to apply to the list of items
	 */
	public static function count($condition = '', $parameters = array())
	{
		return self::$db_querier->count(LamClubsSetup::$lamclubs_table, $condition, $parameters);
	}

    /**
	 * @desc Create a new entry in the database table.
	 * @param LamClubsItem $item : new LamClubsItem
	 */
	public static function add(LamClubsItem $item)
	{
		$result = self::$db_querier->insert(LamClubsSetup::$lamclubs_table, $item->get_properties());

		return $result->get_last_inserted_id();
	}

    /**
	 * @desc Update an entry.
	 * @param LamClubsItem $item : Item to update
	 */
	public static function update(LamClubsItem $item)
	{
		self::$db_querier->update(LamClubsSetup::$lamclubs_table, $item->get_properties(), 'WHERE id=:id', array('id' => $item->get_id()));
	}

    /**
	 * @desc Delete an entry.
	 * @param string $condition : Restriction to apply to the list
	 * @param string[] $parameters : Parameters of the condition
	 */
	public static function delete(int $id)
	{
		if (AppContext::get_current_user()->is_readonly())
        {
            $controller = PHPBoostErrors::user_in_read_only();
            DispatchManager::redirect($controller);
        }
			self::$db_querier->delete(LamClubsSetup::$lamclubs_table, 'WHERE id=:id', array('id' => $id));

			self::$db_querier->delete(DB_TABLE_EVENTS, 'WHERE module=:module AND id_in_module=:id', array('module' => 'LamClubs', 'id' => $id));
	}

    /**
	 * @desc Return the properties of an item.
	 * @param string $condition : Restriction to apply to the list
	 * @param string[] $parameters : Parameters of the condition
	 */
	public static function get_item(int $id)
	{
		$row = self::$db_querier->select_single_row_query('SELECT ' . self::$module_id . '.*
		FROM ' . LamClubsSetup::$lamclubs_table . ' ' . self::$module_id . '
		WHERE ' . self::$module_id . '.id=:id', array(
			'id'              => $id,
			'current_user_id' => AppContext::get_current_user()->get_id()
		));

		$item = new LamClubsItem();
		$item->set_properties($row);
		return $item;
	}

    public static function get_items_list()
    {
        $req = self::$db_querier->select('SELECT *
		FROM ' . LamClubsSetup::$lamclubs_table);
        while($row = $req->fetch())
        {
            $items[] = $row;
        }
        return $items;
        $req->dispose();
    }
}
?>
