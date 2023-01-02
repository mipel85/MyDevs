<?php
/**
 * @copyright   &copy; 2022 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel <mipel@gmail.com>
 * @version     PHPBoost 6.0 - last update: 2022 01 05
 * @since       PHPBoost 6.0 - 2022 01 10
 */

class ReviewService
{
    private static $db_querier;
    public static $files_incontenttable;
    public static $cache_in_table;
    public static $cache_in_folder;


    public static function __static()
    {
        self::$db_querier = PersistenceContext::get_querier();
        self::$files_incontenttable = PREFIX . 'review_files_in_content';
        self::$cache_in_table = ReviewCacheInTable::load();
        self::$cache_in_folder = ReviewCacheInFolder::load();
    }

    public static function insert_files_incontenttable()
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
            if (ReviewService::check_module_compatibility($module)){
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
                        $data['title'] = isset($data['name']) ? Url::encode_rewrite($data['name']) : ReviewService::get_topic_title(isset($data['idtopic']) ? $data['idtopic'] : '');

                    $file_link = ReviewService::create_file_link($module, $data);
                    foreach ($unique_files_path as $path)
                    {
                        $upload_data = ReviewService::get_upload_data_file($path);
                        PersistenceContext::get_querier()->insert(ReviewSetup::$files_incontenttable, array(
                            'path'          => $path,
                            'file_link'          => ReviewService::check_module_compatibility($module) ? $file_link : '#',
                            'file_size'          => isset($upload_data['file_size']) ? $upload_data['file_size'] : '',
                            'upload_by'          => isset($upload_data['display_name']) ? $upload_data['display_name'] : '',
                            'upload_date'        => isset($upload_data['timestamp']) ? $upload_data['timestamp'] : '',
                            'module_source'      => $module,
                            'id_module_category' => isset($data['id_category']) ? $data['id_category'] : 0,
                            'category_name'      => isset($cat_name) ? $cat_name : '---',
                            'item_id'            => isset($data['id_article']) ? $data['id_article'] : 0,
                            'item_title'         => isset($data['title']) ? $data['title'] : (isset($data['name']) ? $data['name'] : ''),
                            'id_in_module'       => $id[0],
                        ));
                    }
                }
            }
        }
    }

    public static function check_module_compatibility($module)
    {
        $modules_list = array();
        foreach (ModulesManager::get_installed_modules_map_sorted_by_localized_name() as $installed_module)
        {
            $modules_list[] = $installed_module->get_id();
        }
        if (in_array($module, $modules_list)){
            return true;
        }
    }

    public static function delete_files_incontenttable()
    {
        PersistenceContext::get_dbms_utils()->truncate(array(self::$files_incontenttable));
    }

    public static function get_tables_with_content_field()
    {
        $db_name = PersistenceContext::get_dbms_utils()->get_database_name();
        $req = self::$db_querier->select('SELECT TABLE_NAME, COLUMN_NAME  
		FROM information_schema.columns c 
        WHERE c.table_schema = "' . $db_name . '"
        AND (c.column_type LIKE "%text"
		OR c.column_type LIKE "%varchar%")
        ');
        while($row = $req->fetch())
        {
            $results[] = array('table' => $row['TABLE_NAME'], 'column' => $row['COLUMN_NAME']);
        }
        return($results);
    }

    public static function get_files_on_server($folder)
    {
        $data = new Folder(PATH_TO_ROOT . $folder);
        $results = array();
        if ($data->exists()){
            $files = $data->get_files();
            foreach ($files as $file)
            {
                if (!strpos($file->get_name(), '.') != 1) $results[] = $file->get_name();
            }
        }
        return $results;
    }

    public static function get_files_in_table($table)
    {
        $results = array();
        try {
            $req = self::$db_querier->select('SELECT path
            FROM ' . PREFIX . $table . ' 
            ORDER BY path DESC'
            );
        } catch (RowNotFoundException $e) {}

        while($row = $req->fetch())
        {
            $results[] = $row['path'];
        }
        $req->dispose();
        
        return $results;
    }

    public static function get_allunused_files()
    {
        $files_on_server = array();
        foreach (self::$cache_in_folder->get_files_in_upload_list() as $file)
        {
            $files_on_server[] = $file;
        }
        $files_in_content = array();
        foreach (self::$cache_in_table->get_files_in_content_list() as $file)
        {
            $files_in_content[] = $file['path'];
        }
        return array_diff($files_on_server, $files_in_content);
    }

    // errors files lists  
    public static function get_count_used_files_not_on_server($folder)
    {
        $files_on_server = array();
        foreach (self::get_files_on_server($folder) as $file)
        {
            $files_on_server[] = $file;
        }
        $files_in_content = array();
        foreach (self::$cache_in_table->get_files_in_content_list() as $file)
        {
            $files_in_content[] = $file['path'];
        }
        return array_diff($files_in_content, $files_on_server);
    }

    public static function get_data_used_files_not_on_server()
    {
        $data_used_files = array();
        foreach (self::get_count_used_files_not_on_server('/upload') as $file)
        {
            $result = self::$db_querier->select('SELECT path, module_source, item_title, id_module_category, id_in_module 
            FROM ' . ReviewSetup::$files_incontenttable . '
            WHERE path = "' . $file . '"
            ');
            if ($result->get_rows_count() > 0){
                while($row = $result->fetch())
                {
                    $data_used_files[] = array('path' => $row['path'], 'module_source' => $row['module_source'], 'item_title' => $row['item_title'], 'id_module_category' => $row['id_module_category'], 'id_in_module' => $row['id_in_module']);
                }
                $result->dispose();
            }
        }
        return $data_used_files;
    }

    public static function get_count_files_not_ingalleryfolder()
    {
        $files_in_folder = array();
        foreach (self::get_files_on_server('/gallery/pics') as $file)
        {
            $files_in_folder[] = $file;
        }
        $files_in_table = array();
        foreach (self::get_files_in_table('gallery') as $file)
        {
            $files_in_table[] = $file;
        }
        return array_diff($files_in_table, $files_in_folder);
    }

    public static function get_files_not_ingalleryfolder()
    {
        $files = self::get_count_files_not_ingalleryfolder();
        return $files;
    }

    public static function get_count_files_not_in_ingallerytable()
    {
        $files_in_folder = array();
        foreach (self::get_files_on_server('/gallery/pics') as $file)
        {
            $files_in_folder[] = $file;
        }
        $files_in_table = array();
        foreach (self::get_files_in_table('gallery') as $file)
        {
            $files_in_table[] = $file;
        }
        return array_diff($files_in_folder, $files_in_table);
    }

    public static function get_files_not_in_ingallerytable()
    {
        $files = self::get_count_files_not_in_ingallerytable();
        return $files;
    }

    public static function get_unused_files_with_users()
    {
        $upload_data = array();
        foreach (self::get_allunused_files() as $file)
        {
            $result = self::$db_querier->select('SELECT id, upload.path, member.display_name, timestamp, size
            FROM ' . DB_TABLE_UPLOAD . ' upload
            LEFT JOIN ' . DB_TABLE_MEMBER . ' member ON upload.user_id = member.user_id
            WHERE upload.path = "' . $file . '"
            ');
            if ($result->get_rows_count() > 0){
                while($row = $result->fetch())
                {
                    $upload_data[] = array('path' => $row['path'], 'display_name' => $row['display_name'], 'timestamp' => $row['timestamp'], 'file_size' => $row['size']);
                }
                $result->dispose();
            }
        }
        return $upload_data;
    }

    public static function get_orphans_files()
    {
        $unused_files = array();
        foreach (self::get_allunused_files() as $file)
        {
            $unused_files[] = $file;
        }
        $files_with_users = array();
        foreach (self::get_unused_files_with_users() as $file)
        {
            $files_with_users[] = $file['path'];
        }

        return array_diff($unused_files, $files_with_users);
    }

    public static function is_picture_file($file)
    {
        $file_ext = substr(strrchr($file, '.'), 1);
        $isPicture = array('jpg', 'jpeg', 'png', 'svg', 'gif', 'webp', 'bmp');
        return in_array($file_ext, $isPicture);
    }

    public static function is_pdf_file($file)
    {
        $file_ext = substr(strrchr($file, '.'), 1);
        $isPdf = array('pdf');
        return in_array($file_ext, $isPdf);
    }

    public static function create_file_link($module, $data)
    {
        $request = AppContext::get_request();
        $db_name = PersistenceContext::get_dbms_utils()->get_database_name();
        switch($module)
        {
            case 'wiki' :
                $wiki_title = Url::encode_rewrite(ReviewService::get_wiki_title($data['id_article']));
                $link = TPL_PATH_TO_ROOT . '/wiki/' . url('wiki.php?title=' . $wiki_title, $wiki_title);
                return $link;
                break;
            case 'media' :
                if (isset($data['id_category'])){ // is not a category
                    $link = TPL_PATH_TO_ROOT . '/media/' . url('media.php?id=' . $data['id'], 'media-' . $data['id_category'] . '-' . $data['id'] . '+' . Url::encode_rewrite($data['title']) . '.php');
                    return $link;
                }else{ //is a category
                    $link = TPL_PATH_TO_ROOT . '/media/' . url('media.php?cat=' . $data['id']);
                    return $link;
                }
                break;
            case 'gallery' : // voir dossier pics
                $link = TPL_PATH_TO_ROOT . '/gallery/gallery-' . $data['id'] . '+' . $data['rewrited_name'] . '.php';
                return $link;
                break;
            case 'faq' :
                if (isset($data['id_category']))
                {
                    $cat_name = self::get_category_name($module, $data);
                    $link = TPL_PATH_TO_ROOT . '/faq/' . $data['id'] . '-' . $cat_name . '/#question' . $data['id'] . '';
                    return $link;
                }
                else // is a category
                {
                    $link = TPL_PATH_TO_ROOT . '/faq/' . $data['id'] . '-' . $data['rewrited_name'];
                    return $link;
                }
                break;
            case 'forum':
                if (isset($data['idtopic'])){ // is a topic or a msg
                     //'$pt=1' --> solution provisoire pour définir un n° de page --> utiliser les hook pour trouver le bon numéro
                    $link = TPL_PATH_TO_ROOT . '/forum/' . url('topic.php?id=' . $data['idtopic'] . '&pt=1' . '#m' . $data['id']);
                    return $link;
                }else{ // is forum or subject
                    $link = TPL_PATH_TO_ROOT . '/forum/' . url('forum.php?id=' . $data['id'], 'forum-' . $data['id'] . '+' . Url::encode_rewrite($data['title']) . '.php');
                    return $link;
                }
                break;
            case 'newsletter':
                if (isset($data['stream_id'])){ // is a newsletter content
                    $newsletter_title = ReviewService::get_newsletter_title($data['stream_id']);
                    $link = TPL_PATH_TO_ROOT . '/newsletter/archives/' . $data['stream_id'] . '-' . $newsletter_title;
                    return $link;
                }else{
                    $link = TPL_PATH_TO_ROOT . '/newsletter/streams/';
                    return $link;
                }
                break;
            default :
                if (isset($data['id_category'])){
                    $cat_name = self::get_category_name($module, $data);
                    $link = ItemsUrlBuilder::display($data['id_category'], $data['id_category'] != Category::ROOT_CATEGORY ? $cat_name : 'root', $data['id'], $data['rewrited_title'], $module);
                    return $link->absolute();
                }else{ // is not a category
                    $link = ItemsUrlBuilder::display_category($data['id'], isset($data['rewrited_name']) ? $data['rewrited_name'] : '', $module);
                    return $link->absolute();
                }
        }
    }

    public static function get_file_link($file)
    {
        if ($file['id_module_category'] != 0) // if is not a category
        {
            $req = self::$db_querier->select('SELECT rew.file_link, rew.path
            FROM ' . ReviewSetup::$files_incontenttable . ' AS rew
            WHERE rew.path = "' . $file['path'] . '"
            AND rew.id_module_category != 0
            ');
            while($row = $req->fetch())
            {
                return $row['file_link'];
            }
        }
        else // if is a category
        {
            $req = self::$db_querier->select('SELECT rew.file_link, rew.path
            FROM ' . ReviewSetup::$files_incontenttable . ' AS rew
            WHERE rew.path = "' . $file['path'] . '"         
            AND rew.id_module_category = 0 
            AND rew.id_in_module = ' . $file['id_in_module'] . '
            ');
            while($row = $req->fetch())
            {
                return $row['file_link'];
            }
        }
        $req->dispose();
    }

    public static function get_wiki_title($id)
    {
        $result = self::$db_querier->select('SELECT wa.id, wa.title
        FROM ' . PREFIX . 'wiki_articles wa
        LEFT JOIN ' . PREFIX . 'wiki_contents wc ON wc.id_article =  ' . $id . '
        WHERE wa.id = ' . $id . '
        ');
        if ($result->get_rows_count() > 0){
            while($row = $result->fetch())
            {
                return $row['title'];
            }
            $result->dispose();
        }
    }

    public static function get_topic_title($idtopic)
    {
        $result = self::$db_querier->select('SELECT ft.id, ft.title
        FROM ' . PREFIX . 'forum_topics ft
        WHERE ft.id = :id_topic', array(
            'id_topic' => $idtopic
        ));
        if ($result->get_rows_count() > 0){
            while($row = $result->fetch())
            {
                return $row['title'];
            }
            $result->dispose();
        }
    }

    public static function get_newsletter_title($stream_id)
    {
        $result = self::$db_querier->select('SELECT ns.rewrited_name
        FROM ' . PREFIX . 'newsletter_streams ns
        WHERE ns.id = ' . $stream_id . '
        ');
        if ($result->get_rows_count() > 0){
            while($row = $result->fetch())
            {
                return $row['rewrited_name'];
            }
            $result->dispose();
        }
    }

    public static function get_category_name($module, $data)
    {
        if (isset($data['id_category']) && ($data['id_category'] != 0)){
            $result = self::$db_querier->select('SELECT cats.id, cats.rewrited_name
            FROM ' . PREFIX . $module . '_cats cats
            WHERE cats.id = ' . $data['id_category'] . '
            ');

            while($row = $result->fetch())
            {
                return $row['rewrited_name'];
            }
        }elseif (isset($data['id_category']) && $data['id_category'] == 0){
            return 'root';
        }elseif (isset($data['name'])) return $data['name'];
    }

    public static function get_upload_data_file($file)
    {
        $data = array();
        $result = self::$db_querier->select('SELECT up.path, up.user_id, up.size, up.timestamp, me.display_name 
        FROM ' . PREFIX . 'upload up
        LEFT JOIN ' . PREFIX . 'member me ON me.user_id = up.user_id 
        WHERE up.path ="' . $file . '" 
        ');
        while($row = $result->fetch())
        {
            $file_size = $row['size'] > 1024 ? NumberHelper::round($row['size'] / 1024, 2) . ' ' . LangLoader::get_message('common.unit.megabytes', 'common-lang') : NumberHelper::round($row['size'], 0) . ' ' . LangLoader::get_message('common.unit.kilobytes', 'common-lang');
            return $data[] = array('path' => $row['path'], 'display_name' => $row['display_name'], 'timestamp' => Date::to_format($row['timestamp'], Date::FORMAT_DAY_MONTH_YEAR_HOUR_MINUTE), 'file_size' => $file_size);
        }
    }

    public static function is_module_displayed($folder)
    {
        return ModulesManager::is_module_installed($folder) && ModulesManager::is_module_activated($folder);
    }

    public static function is_folder_on_server($folder)
    {
        $folder_on_server = new Folder(PATH_TO_ROOT . $folder);
        return $folder_on_server->exists();
    }

}
?>   
