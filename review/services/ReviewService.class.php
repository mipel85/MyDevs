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
    public static $files_in_content_table;

    public static function __static()
    {
        self::$db_querier = PersistenceContext::get_querier();
        self::$files_in_content_table = PREFIX . 'review_files_in_content';
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
            if (ReviewService::check_module_compatibility($module)){
                while($data = $req->fetch())
                {
                    $cat_name = ReviewService::get_category_name($module, $data);

                    $id = array_values($data); // on cherche l'id (première valeur du tableau de résultats)
                    $content = TextHelper::htmlspecialchars($data[$values['column']]);
                    $matches = preg_match_all('`\/upload\/(\S+\.\w*+)`usU', $content, $files);
                    $unique_files_path = array_unique($files[1]);

                    if ($module == 'newsletter'){
                        if (isset($data['stream_id'])) $data['title'] = Url::encode_rewrite(ReviewService::get_newsletter_title($data['stream_id']));
                    }
                    if ($module == 'wiki') $data['title'] = Url::encode_rewrite(ReviewService::get_wiki_title($data['id_article']));
                    if ($module == 'forum') $data['title'] = isset($data['name']) ? Url::encode_rewrite($data['name']) : ReviewService::get_topic_title(isset($data['idtopic']) ? $data['idtopic'] : '');

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

    public static function delete_files_in_content_table()
    {
        PersistenceContext::get_dbms_utils()->truncate(array(self::$files_in_content_table));
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

    public static function get_files_in_content()
    {
        $files_in_content = array();
        try {
            $req = self::$db_querier->select('SELECT * FROM ' . ReviewSetup::$files_in_content_table . '');
            while($row = $req->fetch())
            {
                if (!empty($row)) $files_in_content[] = $row;
            }
            return $files_in_content;
        }catch (RowNotFoundException $e){
            
        }
        $req->dispose();
    }

    public static function get_files_in_table($table)
    {
        $results = array();
        if (ModulesManager::is_module_installed($table) && ModulesManager::is_module_activated($table)){
            $results = array();
            try {
                $req = self::$db_querier->select('SELECT path
                FROM ' . PREFIX . $table . ' 
                ORDER BY path DESC'
                );
            }catch (RowNotFoundException $e){
                
            }

            while($row = $req->fetch())
            {
                $results[] = $row['path'];
            }
            $req->dispose();
        }
        return $results;
    }

    public static function get_all_unused_files()
    {
        $files_on_server = array();
        foreach (self::get_files_on_server('/upload') as $file)
        {
            $files_on_server[] = $file;
        }
        $files_in_content = array();
        foreach (self::get_files_in_content() as $file)
        {
            $files_in_content[] = $file['file_path'];
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
        foreach (self::get_files_in_content() as $file)
        {
            $files_in_content[] = $file['file_path'];
        }
        return array_diff($files_in_content, $files_on_server);
    }

    public static function get_data_used_files_not_on_server()
    {
        $data_used_files = array();
        foreach (self::get_count_used_files_not_on_server('/upload') as $file)
        {
            $result = self::$db_querier->select('SELECT file_path, module_source, item_title, id_module_category, id_in_module FROM ' . ReviewSetup::$files_in_content_table . '
            WHERE file_path = "' . $file . '"
            ');
            if ($result->get_rows_count() > 0){
                while($row = $result->fetch())
                {
                    $data_used_files[] = array('file_path' => $row['file_path'], 'module_source' => $row['module_source'], 'item_title' => $row['item_title'], 'id_module_category' => $row['id_module_category'], 'id_in_module' => $row['id_in_module']);
                }
                $result->dispose();
            }
        }
        return $data_used_files;
    }

    public static function get_count_files_not_in_gallery_folder()
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

    public static function get_files_not_in_gallery_folder()
    {
        $files = self::get_count_files_not_in_gallery_folder();
        return $files;
    }

    public static function get_count_files_not_in_gallery_table()
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

    public static function get_files_not_in_gallery_table()
    {
        $files = self::get_count_files_not_in_gallery_table();
        return $files;
    }

    public static function get_unused_files_with_users()
    {
        $upload_data = array();
        foreach (self::get_all_unused_files() as $file)
        {
            $result = self::$db_querier->select('SELECT id, upload.path, member.display_name, timestamp, size
            FROM ' . DB_TABLE_UPLOAD . ' upload
            LEFT JOIN ' . DB_TABLE_MEMBER . ' member ON upload.user_id = member.user_id
            WHERE upload.path = "' . $file . '"
            ');
            if ($result->get_rows_count() > 0){
                while($row = $result->fetch())
                {
                    $upload_data[] = array('file_path' => $row['path'], 'display_name' => $row['display_name'], 'timestamp' => $row['timestamp'], 'file_size' => $row['size']);
                }
                $result->dispose();
            }
        }
        return $upload_data;
    }

    public static function get_orphan_files()
    {
        $unused_files = array();
        foreach (self::get_all_unused_files() as $file)
        {
            $unused_files[] = $file;
        }
        $files_with_users = array();
        foreach (self::get_unused_files_with_users() as $file)
        {
            $files_with_users[] = $file['file_path'];
        }

        return array_diff($unused_files, $files_with_users);
    }

    public static function is_picture_file($file)
    {
            $file_ext = substr(strrchr($file, '.'), 1);
            $isPicture = array('jpg', 'jpeg', 'png', 'svg', 'gif', 'webp');
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
                $link = '/' . $db_name . '/wiki/' . url('wiki.php?title=' . $wiki_title, $wiki_title);
                return $link;
                break;
            case 'media' :
                if (isset($data['id_category'])){ // is not a category
                    $link = '/' . $db_name . '/media/' . url('media.php?id=' . $data['id'], 'media-' . $data['id_category'] . '-' . $data['id'] . '+' . Url::encode_rewrite($data['title']) . '.php');
                    return $link;
                }else{ //is a category
                    $link = '/' . $db_name . '/media/' . url('media.php?cat=' . $data['id']);
                    return $link;
                }
                break;
            case 'gallery' : // voir dossier pics
                $link = '/' . $db_name . '/gallery/gallery-' . $data['id'] . '+' . $data['rewrited_name'] . '.php';
                return $link;
                break;
            case 'faq' :
                if (isset($data['id_category'])){
                    $cat_name = self::get_category_name($module, $data);
                    $link = '/' . $db_name . '/faq/' . $data['id'] . '-' . $cat_name . '/#question' . $data['id'] . '';
                    return $link;
                }else{ // is a category
                    $link = '/' . $db_name . '/faq/' . $data['id'] . '-' . $data['rewrited_name'];
                    return $link;
                }
                break;
            case 'forum':
                if (isset($data['idtopic'])){ // is a topic or a msg
                     //'$pt=1' --> solution provisoire pour définir un n° de page --> utiliser les hook pour trouver le bon numéro
                    $link = '/' . $db_name . '/forum/' . url('topic.php?id=' . $data['idtopic'] . '&pt=1' . '#m' . $data['id']);
                    return $link;
                }else{ // is forum or subject
                    $link = '/' . $db_name . '/forum/' . url('forum.php?id=' . $data['id'], 'forum-' . $data['id'] . '+' . Url::encode_rewrite($data['title']) . '.php');
                    return $link;
                }
                break;
            case 'newsletter':
                if (isset($data['stream_id'])){ // is a newsletter content
                    $newsletter_title = ReviewService::get_newsletter_title($data['stream_id']);
                    $link = '/' . $db_name . '/newsletter/archives/' . $data['stream_id'] . '-' . $newsletter_title;
                    return $link;
                }else{
                    $link = '/' . $db_name . '/newsletter/streams/';
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
        if ($file['id_module_category'] != 0){ // if is not a category
            $req = self::$db_querier->select('SELECT rew.file_link, rew.file_path
            FROM ' . ReviewSetup::$files_in_content_table . ' AS rew
            WHERE rew.file_path = "' . $file['file_path'] . '"
            AND rew.id_module_category != 0
            ');
            while($row = $req->fetch())
            {
                return $row['file_link'];
            }
        }else{ // if is a category
            $req = self::$db_querier->select('SELECT rew.file_link, rew.file_path
            FROM ' . ReviewSetup::$files_in_content_table . ' AS rew
            WHERE rew.file_path = "' . $file['file_path'] . '"         
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
            return $data[] = array('file_path' => $row['path'], 'display_name' => $row['display_name'], 'timestamp' => Date::to_format($row['timestamp'], Date::FORMAT_DAY_MONTH_YEAR_HOUR_MINUTE), 'file_size' => $file_size);
        }
    }

}
?>   
