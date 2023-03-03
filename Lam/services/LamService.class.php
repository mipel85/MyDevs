<?php
/*
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2023 03 03
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
        $nb_activity_requests = self::$db_querier->select_single_row_query('SELECT COUNT(form_name) AS "' . $activity . '"
		FROM ' . LamSetup::$lam_forms . ' 
		WHERE  form_name LIKE "' . $activity . '"'
        );
        return $nb_activity_requests;
    }

    /** remaining requests :
     * nb_max_activity = jpo_total_amount/jpo_day_amount 
     * 
     */
    public static function get_remaining_requests_activity($type)
    {
        $config = LamConfig::load();
        // activity
        $nb_jpo_requests = self::get_requests_number($type[0]);
        $nb_jpo_max = round($config->get_jpo_total_amount() / $config->get_jpo_day_amount());
        $nb_jpo_remaining = $nb_jpo_max - $nb_jpo_requests[$type[0]];

        // examen
        $nb_exam_requests = self::get_requests_number($type[1]);
        $nb_exam_max = round($config->get_exam_total_amount() / $config->get_exam_day_amount());
        $nb_exam_remaining = $nb_exam_max - $nb_exam_requests[$type[1]];

        return array(
            'nb_jpo_max'        => $nb_jpo_max, 'nb_jpo_remaining'  => $nb_jpo_remaining,
            'nb_exam_max'       => $nb_exam_max, 'nb_exam_remaining' => $nb_exam_remaining,
        );
    }
}
?>
