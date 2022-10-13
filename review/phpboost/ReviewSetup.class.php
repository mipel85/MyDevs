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
    public static $files_in_content_table;

    public static function __static()
    {
        self::$files_in_content_table = PREFIX . 'review_files_in_content';
    }

    public function install()
    {
        $this->drop_tables();
        $this->create_files_in_content_table();
        $this->insert_files_in_content_table();
    }

    public function uninstall()
    {
        $this->drop_tables();
        ConfigManager::delete('review', 'config');
    }

    private function drop_tables()
    {
        PersistenceContext::get_dbms_utils()->drop(array(self::$files_in_content_table));
    }

    private function create_files_in_content_table()
    {
        $fields = array(
            'id'                 => array('type' => 'integer', 'length' => 11, 'autoincrement' => true, 'notnull' => 1),
            'file_path'          => array('type' => 'text', 'length' => 16777215),
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
        PersistenceContext::get_dbms_utils()->create_table(self::$files_in_content_table, $fields, $options);
    }

    public static function insert_files_in_content_table()
    {

        $result = ReviewService::get_tables_with_content_field();
        foreach ($result as $values)
        {
            $matches = preg_match('`_([a-z]*)`us', $values['table'], $item_source); // récupération du module source du contenu
            $req = PersistenceContext::get_querier()->select(' SELECT *
            FROM ' . $values['table'] . '
            WHERE ' . $values['column'] . ' LIKE "%/upload%"
            ');
            $module = $item_source[1];
            if (ReviewService::check_module_compatibility($module))
            {
                while($data = $req->fetch())
                {
                    $cat_name = ReviewService::get_category_name($module, $data);

                    $id = array_values($data); // on cherche l'id (première valeur du tableau de résultats)
                    $content = TextHelper::htmlspecialchars($data[$values['column']]);
                    $matches = preg_match_all('`\/upload\/(\S+\.\w*+)`usU', $content, $files);
                    $unique_files_path = array_unique($files[1]);

                    if ($module == 'newsletter')
                    {
                        if (isset($data['stream_id']))
                            $data['title'] = Url::encode_rewrite(ReviewService::get_newsletter_title($data['stream_id']));                        
                    }
                    if ($module == 'wiki')
                        $data['title'] = Url::encode_rewrite(ReviewService::get_wiki_title($data['id_article']));                    
                    if ($module == 'forum')
                        $data['title'] = isset($data['name']) ? Url::encode_rewrite($data['name']) : ReviewService::get_topic_title($data['idtopic']);

                    $file_link = ReviewService::create_file_link($module, $data);
                    foreach ($unique_files_path as $file_path)
                    {
                        $upload_data = ReviewService::get_upload_data_file($file_path);
                        PersistenceContext::get_querier()->insert(ReviewSetup::$files_in_content_table, array(
                            'file_path'          => $file_path,
                            'file_link'          => ReviewService::check_module_compatibility($module) ? $file_link : '',
                            'file_size'          => isset($upload_data['file_size']) ? $upload_data['file_size'] : '',
                            'upload_by'          => isset($upload_data['display_name']) ? $upload_data['display_name'] : '',
                            'upload_date'        => isset($upload_data['timestamp']) ? $upload_data['timestamp'] : '',
                            'module_source'      => $module,
                            'id_module_category' => isset($data['id_category']) ? $data['id_category'] : 0,
                            'category_name'      => isset($cat_name) ? $cat_name : '---',
                            'item_id'            => isset($data['id_article']) ? $data['id_article'] : 0,
                            'item_title'         => isset($data['title']) ? $data['title'] : $data['name'],
                            'id_in_module'       => $id[0],
                            'id_in_module'       => $id[0],
                        ));
                    }
                }
            }
        }
    }
}
?>
