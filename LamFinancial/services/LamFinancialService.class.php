<?php
/*
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2023 03 03
 * @since       PHPBoost 6.0 - 2022 12 20
 */
class LamFinancialService
{
    private static $db_querier;
    protected static $module_id = 'LamFinancial';

    public static function __static()
    {
        self::$db_querier = PersistenceContext::get_querier();
    }

    /**
     * @desc Create a new entry in the database table.
     * @param string[] $item : new LamItem
     */
    public static function add(LamFinancialItem $item)
    {
        $result = self::$db_querier->insert(LamFinancialSetup::$lam_financial, $item->get_properties());
        return $result->get_last_inserted_id();
    }

    public static function delete(int $id)
    {
        if (AppContext::get_current_user()->is_readonly()){
            $controller = PHPBoostErrors::user_in_read_only();
            DispatchManager::redirect($controller);
        }
        self::$db_querier->delete(LamFinancialSetup::$lam_financial, 'WHERE id=:id', array('id' => $id));
        self::$db_querier->delete(DB_TABLE_EVENTS, 'WHERE module=:module AND id_in_module=:id', array('module' => 'Lam', 'id' => $id));
    }

    public static function payment_validation(int $id, int $amount_paid)
    {
        if (AppContext::get_current_user()->is_readonly()){
            $controller = PHPBoostErrors::user_in_read_only();
            DispatchManager::redirect($controller);
        }
        $now = new Date();
        self::$db_querier->update(LamFinancialSetup::$lam_financial, array('archived' => '1', 'archived_date' => $now->get_timestamp(), 'amount_paid' => $amount_paid), 'WHERE id=:id', array(
            'id' => $id
        ));
    }

    public static function get_requests($archived)
    {
        $result = array();
        $req = self::$db_querier->select('SELECT *
		FROM ' . LamFinancialSetup::$lam_financial . '
        WHERE  archived = "' . $archived . '"');
        while($row = $req->fetch())
        {
            $result[] = $row;
        }
        $req->dispose();
        return $result;
    }

    public static function get_pending_requests_number($activity)
    {
        $nb_activity_requests = self::$db_querier->select_single_row_query('SELECT COUNT(activity_type) AS "' . $activity . '"
		FROM ' . LamFinancialSetup::$lam_financial . ' 
		WHERE  activity_type LIKE "' . $activity . '"
        AND archived = 0 '    
        );
        return $nb_activity_requests;
    }

    /** remaining requests :
     * nb_max_activity = jpo_total_amount/jpo_day_amount 
     * 
     */
    public static function get_remaining_requests_activity($type)
    {
        $config = LamFinancialConfig::load();
        // activity
        $nb_jpo_requests = self::get_pending_requests_number($type[0]);
        $nb_jpo_max = round($config->get_jpo_total_amount() / $config->get_jpo_day_amount());
        $nb_jpo_remaining = $nb_jpo_max - $nb_jpo_requests[$type[0]];

        // examen
        $nb_exam_requests = self::get_pending_requests_number($type[1]);
        $nb_exam_max = round($config->get_exam_total_amount() / $config->get_exam_day_amount());
        $nb_exam_remaining = $nb_exam_max - $nb_exam_requests[$type[1]];

        return array(
            'nb_jpo_max'        => $nb_jpo_max, 'nb_jpo_remaining'  => $nb_jpo_remaining,
            'nb_exam_max'       => $nb_exam_max, 'nb_exam_remaining' => $nb_exam_remaining,
        );
    }

    public static function get_archived_amount_paid($activity)
    {
        $req = self::$db_querier->select('SELECT SUM(amount_paid) AS amount_paid
		FROM ' . LamFinancialSetup::$lam_financial . '
        WHERE  activity_type LIKE "' . $activity . '"'
        );
        while($row = $req->fetch())
        {
            return $row;
        }
        $req->dispose();
    }

    public static function check_config()
    {
        $config = LamFinancialConfig::load();
        if ($config->get_property('jpo_total_amount') != 1 && $config->get_property('jpo_day_amount') != 1 &&
            $config->get_property('exam_total_amount') != 1 && $config->get_property('exam_day_amount') != 1){

            return true;
        }
    }
}
?>
