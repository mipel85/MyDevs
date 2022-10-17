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

        if (ModulesManager::is_module_installed('gallery') && ModulesManager::is_module_activated('gallery'))
        {
            $view->put_all(array(    
                'C_GALLERY'                      => true,      
                'NB_FILES_IN_GALLERY_TABLE'      => count(ReviewService::get_files_in_table('gallery')),
                'U_FILES_IN_GALLERY_TABLE'       => ReviewUrlBuilder::home('ingallerytable')->rel(),
                'NB_FILES_NOT_IN_GALLERY_TABLE'  => count(ReviewService::get_count_files_not_in_gallery_table()),
                'U_FILES_NOT_IN_GALLERY_TABLE'   => ReviewUrlBuilder::home('nogallerytable')->rel(),
                'NB_FILES_NOT_IN_GALLERY_FOLDER' => count(ReviewService::get_count_files_not_in_gallery_folder()),
                'U_FILES_NOT_IN_GALLERY_FOLDER'  => ReviewUrlBuilder::home('nogalleryfolder')->rel(),
            ));
        }
        
        $view->put_all(array(
            'NB_FILES_ON_SERVER'             => count(ReviewService::get_files_on_server('/upload')),
            'U_FILES_ON_SERVER'              => ReviewUrlBuilder::home('onserver')->rel(),
            'NB_FILES_IN_UPLOAD'             => count(ReviewService::get_files_in_table('upload')),
            'U_FILES_IN_UPLOAD'              => ReviewUrlBuilder::home('inupload')->rel(),
            'NB_FILES_IN_CONTENT'            => count(ReviewService::get_files_in_content()),
            'U_FILES_IN_CONTENT'             => ReviewUrlBuilder::home('incontent')->rel(),
            'NB_ALL_UNUSED_FILES'            => count(ReviewService::get_all_unused_files()),
            'U_ALL_UNUSED_FILES'             => ReviewUrlBuilder::home('allunused')->rel(),
            // Gallery
            'NB_FILES_IN_GALLERY_FOLDER'     => count(ReviewService::get_files_on_server('/gallery/pics')),
            'U_FILES_IN_GALLERY_FOLDER'      => ReviewUrlBuilder::home('ingalleryfolder')->rel(),
            // errors files list
            'NB_USED_FILES_NOT_ON_SERVER'    => count(ReviewService::get_count_used_files_not_on_server('/upload')),
            'U_USED_FILES_NOT_ON_SERVER'     => ReviewUrlBuilder::home('usednoserver')->rel(),
            'NB_UNUSED_FILES_USER'           => count(ReviewService::get_unused_files_with_users()),
            'U_UNUSED_FILES_USER'            => ReviewUrlBuilder::home('unuseduser')->rel(),
            'NB_ORPHAN_FILES'                => count(ReviewService::get_orphan_files()),
            'U_ORPHAN_FILES'                 => ReviewUrlBuilder::home('orphan')->rel(),
            'NB_TOTAL_DISCARDED_FILES'       => count(ReviewService::get_orphan_files()) + count(ReviewService::get_unused_files_with_users()) + count(ReviewService::get_count_used_files_not_on_server('/upload')),
        ));
        return $view;
    }
}
?>
