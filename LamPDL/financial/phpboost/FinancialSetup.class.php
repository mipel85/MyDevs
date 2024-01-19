<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 18
 * @since       PHPBoost 6.0 - 2024 01 18
 */
class FinancialSetup extends DefaultModuleSetup
{
    public static $financial;

    public static function __static()
    {
        self::$financial = PREFIX . 'financial';
    }

    public function install()
    {
        $this->drop_tables();
        $this->create_tables();
    }

    public function uninstall()
    {
        $this->drop_tables();
        ConfigManager::delete('financial', 'config');
    }

    private function drop_tables()
    {
        PersistenceContext::get_dbms_utils()->drop(array(self::$financial));
    }

    private function create_tables()
    {
        $this->create_financial_table();
    }

    private function create_financial_table()
    {
        $fields = array(
            'id'                        => array('type' => 'integer', 'length' => 11, 'autoincrement' => true, 'notnull' => 1),
            'activity_type'             => array('type' => 'text', 'length' => 16777215, 'notnull' => 0),
            'club_id'                   => array('type' => 'integer', 'length' => 11, 'notnull' => 1),
            'club_activity_date'        => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
            'club_activity_location'    => array('type' => 'text', 'length' => 16777215),
            'club_activity_city'        => array('type' => 'text', 'length' => 16777215),
            'club_activity_description' => array('type' => 'string', 'length' => 255, 'notnull' => 0),
            'club_request_date'         => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
            'amount_paid'               => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
            'archived'                  => array('type' => 'boolean', 'length' => 1, 'notnull' => 1, 'default' => 0),
            'archived_date'             => array('type' => 'integer', 'length' => 11, 'notnull' => 0, 'default' => 0),
        );
        $options = array(
            'primary' => array('id'),
            'indexes' => array(
                'club_id' => array('type' => 'key', 'fields' => 'club_id'),
            )
        );
        PersistenceContext::get_dbms_utils()->create_table(self::$financial, $fields, $options);
    }
}
?>
