<?php
/**
 * @copyright   &copy; 2022 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel <mipel@gmail.com>
 * @version     PHPBoost 6.0 - last update: 2022 01 05
 * @since       PHPBoost 6.0 - 2022 01 10
 */
class ReviewCounters
{
    public static function get_counters()
    {
        $view = new FileTemplate('review/ReviewCounters.tpl');
        $view->add_lang(LangLoader::get_all_langs('review'));
        $cache_in_table = ReviewCacheInTable::load();
        $cache_in_folder = ReviewCacheInFolder::load();

        if (ReviewService::is_module_displayed('gallery'))
        {
            $view->put_all(array(
                'C_GALLERY_DISPLAYED'            => true,
                'NB_FILES_IN_GALLERY_TABLE'      => $cache_in_table->get_files_in_gallery_number(),
                'NB_FILES_NOT_IN_GALLERY_TABLE'  => count(ReviewService::get_count_files_not_in_ingallerytable()),
                'NB_FILES_NOT_IN_GALLERY_FOLDER' => count(ReviewService::get_count_files_not_ingalleryfolder()),
            ));
        }

        $view->put_all(array(
            'NB_FILES_ON_SERVER'             => $cache_in_folder->get_files_in_upload_number(),
            'U_FILES_ON_SERVER'              => ReviewUrlBuilder::home('inuploadfolder')->rel(),
            'NB_FILES_IN_UPLOAD'             => $cache_in_table->get_files_in_upload_number(),
            'U_FILES_IN_UPLOAD'              => ReviewUrlBuilder::home('inuploadtable')->rel(),
            'NB_FILES_IN_CONTENT'            => $cache_in_table->get_files_in_content_number(),
            'U_FILES_IN_CONTENT'             => ReviewUrlBuilder::home('incontenttable')->rel(),
            'NB_ALL_UNUSED_FILES'            => count(ReviewService::get_allunused_files()),
            'U_ALL_UNUSED_FILES'             => ReviewUrlBuilder::home('allunused')->rel(),
            // Gallery
            'U_FILES_IN_GALLERY_TABLE'       => ReviewUrlBuilder::home('ingallerytable')->rel(),
            'U_FILES_NOT_IN_GALLERY_TABLE'   => ReviewUrlBuilder::home('galleryunusedbutintable')->rel(),
            'U_FILES_NOT_IN_GALLERY_FOLDER'  => ReviewUrlBuilder::home('galleryusedbutmissing')->rel(),
            'C_GALLERY_FOLDER'               => ReviewService::is_folder_on_server('/gallery/pics'),  
            'NB_FILES_IN_GALLERY_FOLDER'     => $cache_in_folder->get_files_in_gallery_number(),
            'U_FILES_IN_GALLERY_FOLDER'      => ReviewUrlBuilder::home('ingalleryfolder')->rel(),
            // errors files list
            'NB_USED_FILES_NOT_ON_SERVER'    => count(ReviewService::get_count_used_files_not_on_server('/upload')),
            'U_USED_FILES_NOT_ON_SERVER'     => ReviewUrlBuilder::home('usedbutmissing')->rel(),
            'NB_UNUSED_FILES_USER'           => count(ReviewService::get_unused_files_with_users()),
            'U_UNUSED_FILES_USER'            => ReviewUrlBuilder::home('unusedbutintable')->rel(),
            'NB_ORPHAN_FILES'                => count(ReviewService::get_orphans_files()),
            'U_ORPHAN_FILES'                 => ReviewUrlBuilder::home('orphans')->rel(),
            'NB_TOTAL_DISCARDED_FILES'       => count(ReviewService::get_orphans_files()) + count(ReviewService::get_unused_files_with_users()) + count(ReviewService::get_count_used_files_not_on_server('/upload')),
        ));
        return $view;
    }
}
?>
