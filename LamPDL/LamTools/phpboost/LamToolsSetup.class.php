<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2023 03 03
 * @since       PHPBoost 6.0 - 2022 12 20
 */
class LamToolsSetup extends DefaultModuleSetup
{
    public static $lamtools_financial;
    public static $lamtools_planning;
    public static $lamtools_clubs;

    public static function __static()
    {
        self::$lamtools_financial = PREFIX . 'lamtools_financial';
        self::$lamtools_planning = PREFIX . 'lamtools_planning';
        self::$lamtools_clubs = PREFIX . 'lamtools_clubs';
    }

    public function install()
    {
        $this->drop_tables();
        $this->create_tables();
    }

    public function uninstall()
    {
        $this->drop_tables();
        ConfigManager::delete('LamTools', 'config');
    }

    private function drop_tables()
    {
        PersistenceContext::get_dbms_utils()->drop(array(self::$lamtools_financial, self::$lamtools_planning, self::$lamtools_clubs));
    }

    private function create_tables()
    {
        $this->create_lamtools_financial_table();
        $this->create_lamtools_planning_table();
        $this->create_lamtools_clubs_table();
    }

    private function create_lamtools_financial_table()
    {
        $fields = array(
            'id'                        => array('type' => 'integer', 'length' => 11, 'autoincrement' => true, 'notnull' => 1),
            'activity_type'             => array('type' => 'text', 'length' => 16777215),
            'club_name'                 => array('type' => 'text', 'length' => 16777215),
            'club_ffam_number'          => array('type' => 'string', 'length' => 4, 'notnull' => 1),
            'club_activity_date'        => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
            'club_activity_location'    => array('type' => 'text', 'length' => 16777215),
            'club_activity_city'        => array('type' => 'text', 'length' => 16777215),
            'club_activity_description' => array('type' => 'string', 'length' => 255, 'notnull' => 1),
            'club_request_date'         => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
            'amount_paid'               => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
            'archived'                  => array('type' => 'boolean', 'length' => 1, 'notnull' => 1, 'default' => 0),
            'archived_date'             => array('type' => 'integer', 'length' => 11, 'notnull' => 0, 'default' => 0),
        );
        $options = array(
            'primary' => array('id'),
            'indexes' => array(
                'club_ffam_number' => array('type' => 'key', 'fields' => 'club_ffam_number'),
            )
        );
        PersistenceContext::get_dbms_utils()->create_table(self::$lamtools_financial, $fields, $options);
    }

    private function create_lamtools_planning_table()
    {
        $fields = array(
            'id'                        => array('type' => 'integer', 'length' => 11, 'autoincrement' => true, 'notnull' => 1),
            'activity_type'             => array('type' => 'text', 'length' => 16777215),
            'club_name'                 => array('type' => 'text', 'length' => 16777215),
            'club_ffam_number'          => array('type' => 'string', 'length' => 4, 'notnull' => 1),
            'club_activity_date'        => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
            'club_activity_location'    => array('type' => 'text', 'length' => 16777215),
            'club_activity_city'        => array('type' => 'text', 'length' => 16777215),
            'club_activity_description' => array('type' => 'string', 'length' => 255, 'notnull' => 1),
        );
        $options = array(
            'primary' => array('id'),
            'indexes' => array(
                'club_ffam_number' => array('type' => 'key', 'fields' => 'club_ffam_number'),
            )
        );
        PersistenceContext::get_dbms_utils()->create_table(self::$lamtools_planning, $fields, $options);
    }

    public static function create_lamtools_clubs_table()
    {
        $fields = array(
            'id'               => array('type' => 'integer', 'length' => 4, 'autoincrement' => true, 'notnull' => 1),
            'club_ffam_number' => array('type' => 'string', 'length' => 4, 'notnull' => 1),
            'club_Dept'        => array('type' => 'integer', 'length' => 2, 'notnull' => 1, 'default' => 0),
            'club_Name'        => array('type' => 'text', 'length' => 16777215),
        );
        $options = array(
            'primary' => array('id'),
            'indexes' => array(
                'club_ffam_number' => array('type' => 'key', 'fields' => 'club_ffam_number'),
                'club_Dept'        => array('type' => 'key', 'fields' => 'club_Dept')
            )
        );
        PersistenceContext::get_dbms_utils()->create_table(self::$lamtools_clubs, $fields, $options);
    }

}
?>
