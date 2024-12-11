<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2024 12 11
 */

class LamclubsSetup extends DefaultModuleSetup
{
    public static $lamclubs_table;

    public static function __static()
    {
        self::$lamclubs_table = PREFIX . 'lamclubs';
    }

    public function upgrade($installed_version)
    {
        return '6.0.0';
    }

    public function install()
    {
        $this->drop_tables();
        $this->create_tables();
        $this->insert_data();
    }

    public function uninstall()
    {
        $this->drop_tables();
        ConfigManager::delete('lamclubs', 'config');
        CacheManager::invalidate('module', 'lamclubs');
    }

    private function drop_tables()
    {
        PersistenceContext::get_dbms_utils()->drop(array(self::$lamclubs_table));
    }

    private function create_tables()
    {
        $this->create_lamclubs_table();
    }

    private function create_lamclubs_table()
    {
        $fields = array(
            'club_id'     => array('type' => 'integer', 'length' => 11, 'autoincrement' => true, 'notnull' => 1),
            'name'        => array('type' => 'string', 'length' => 255, 'notnull' => 1, 'default' => "''"),
            'ffam_nb'     => array('type' => 'string', 'length' => 4, 'notnull' => 1, 'default' => "''"),
            'department'  => array('type' => 'integer', 'length' => 3, 'notnull' => 1, 'default' => 0),
            'website_url' => array('type' => 'string', 'length' => 255, 'notnull' => 0, 'default' => "''")
        );
        $options = array(
            'primary' => array('club_id'),
            'indexes' => array(
              'name' => array('type' => 'fulltext', 'fields' => 'name')
            )
        );
        PersistenceContext::get_dbms_utils()->create_table(self::$lamclubs_table, $fields, $options);
    }

    private function insert_data()
    {
        $file = PATH_TO_ROOT . '/lamclubs/data/lamclubs.csv';
        if (($handle = fopen($file, 'r')) !== FALSE)
        {
            while(($data = fgetcsv($handle, 1000, ';')) !== FALSE)
            {
                PersistenceContext::get_querier()->insert(self::$lamclubs_table, array(
                    'club_id'     => $data[0],
                    'name'        => $data[3],
                    'ffam_nb'     => $data[1],
                    'department'  => $data[2],
                    'website_url' => $data[4]
                ));
            }
            fclose($handle);
        }else
        {
            echo '<div class="message-helper bgc-full error">Erreur lors de l\'ouverture du fichier CSV.</div>';
        }
    }
}
?>
