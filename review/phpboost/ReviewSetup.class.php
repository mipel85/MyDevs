<?php
/**
 * @copyright   &copy; 2022 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel <mipel@gmail.com>
 * @version     PHPBoost 6.0 - last update: 2022 01 05
 * @since       PHPBoost 6.0 - 2022 01 10
 */
class ReviewSetup extends DefaultModuleSetup
{
    public static $files_incontenttable;

    public static function __static()
    {
        self::$files_incontenttable = PREFIX . 'review_files_in_content';
    }

    public function install()
    {
        $this->drop_tables();
        $this->create_fields_incontenttable();
    }

    public function uninstall()
    {
        $this->drop_tables();
        ConfigManager::delete('review', 'config');
    }

    private function drop_tables()
    {
        PersistenceContext::get_dbms_utils()->drop(array(self::$files_incontenttable));
    }

    private function create_fields_incontenttable()
    {
        $fields = array(
            'id'                 => array('type' => 'integer', 'length' => 11, 'autoincrement' => true, 'notnull' => 1),
            'path'               => array('type' => 'text', 'length' => 16777215),
            'file_link'          => array('type' => 'text', 'length' => 16777215),
            'file_size'          => array('type' => 'text', 'length' => 16777215),
            'upload_by'          => array('type' => 'string', 'length' => 255, 'notnull' => 1),
            'upload_date'        => array('type' => 'text', 'length' => 16777215),
            'module_source'      => array('type' => 'string', 'length' => 255, 'notnull' => 1),
            'id_module_category' => array('type' => 'integer', 'length' => 11, 'notnull' => 1),
            'category_name'      => array('type' => 'string', 'length' => 255),
            'item_id'            => array('type' => 'integer', 'length' => 11, 'notnull' => 1),
            'item_title'         => array('type' => 'string', 'length' => 255, 'notnull' => 1),
            'id_in_module'       => array('type' => 'integer', 'length' => 11, 'notnull' => 1),
        );
        $options = array(
            'primary' => array('id'),
        );
        PersistenceContext::get_dbms_utils()->create_table(self::$files_incontenttable, $fields, $options);
    }

}
?>
