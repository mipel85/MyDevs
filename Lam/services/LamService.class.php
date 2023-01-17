<?php
/*
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2023 01 23
 * @since       PHPBoost 6.0 - 2022 12 20
 */
class LamService
{
    private static $db_querier;
    protected static $module_id = 'Lam';

    public static function __static()
    {
        self::$db_querier = PersistenceContext::get_querier();
    }

    /**
     * @desc Create a new entry in the database table.
     * @param string[] $item : new LamItem
     */
    public static function add(LamItem $item)
    {
        $result = self::$db_querier->insert(LamSetup::$lam_forms, $item->get_properties());
        return $result->get_last_inserted_id();
    }

    public static function delete(int $id)
    {
        if (AppContext::get_current_user()->is_readonly()){
            $controller = PHPBoostErrors::user_in_read_only();
            DispatchManager::redirect($controller);
        }
        self::$db_querier->delete(LamSetup::$lam_forms, 'WHERE id=:id', array('id' => $id));
        self::$db_querier->delete(DB_TABLE_EVENTS, 'WHERE module=:module AND id_in_module=:id', array('module' => 'Lam', 'id' => $id));
    }

    /**
     * @desc Return the item with all its properties from its id.
     * @param int $id Item identifier
     */
    public static function get_item(int $id)
    {
        $row = self::$db_querier->select_single_row_query('SELECT ' . self::$module_id . '.*
		FROM ' . LamSetup::$lam_forms . ' ' . self::$module_id . '
		WHERE ' . self::$module_id . '.id=:id', array(
            'id' => $id
        ));
        $item = new LamItem();
        $item->set_properties($row);
        return $item;
    }

    public static function get_requests_number($activity)
    {
        $nb_activity_requests = self::$db_querier->select_single_row_query('SELECT COUNT(form_name) AS nb
		FROM ' . LamSetup::$lam_forms . ' 
		WHERE  form_name LIKE "' . $activity . '"'
        );

        return $nb_activity_requests;
    }
}
?>
