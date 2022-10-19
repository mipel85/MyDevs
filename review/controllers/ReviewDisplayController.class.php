<?php
/**
 * @copyright   &copy; 2022 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel <mipel@gmail.com>
 * @version     PHPBoost 6.0 - last update: 2022 10 19
 * @since       PHPBoost 6.0 - 2022 01 10
 */
class ReviewDisplayController extends DefaultAdminModuleController
{

    public function execute(HTTPRequestCustom $request)
    {
        $this->view = new FileTemplate('review/ReviewDisplayController.tpl');
        $this->view->add_lang($this->lang);

        ReviewService::delete_files_in_content_table();
        ReviewService::insert_files_in_content_table();

        // call counters menu //        
        $this->view->put('REVIEW_COUNTERS', ReviewCounters::get_counters());

        $section = $request->get_string('section');
        switch($section)
        {
            case 'onserver':
                $this->view->put('C_FILES_ON_SERVER', true);

                foreach (ReviewService::get_files_on_server('/upload') as $file)
                {
                    $file_data = ReviewService::get_upload_data_file($file);
                    $this->view->assign_block_vars('onserver', array(
                        'C_IS_PICTURE_FILE' => ReviewService::is_picture_file($file),
                        'C_IS_PDF_FILE'     => ReviewService::is_pdf_file($file),
                        'FILE_ON_SERVER'    => $file,
                        'FILE_UPLOAD_BY'    => isset($file_data['display_name']) ? $file_data['display_name'] : '---',
                        'FILE_UPLOAD_DATE'  => isset($file_data['timestamp']) ? $file_data['timestamp'] : '---',
                        'FILE_UPLOAD_SIZE'  => isset($file_data['file_size']) ? $file_data['file_size'] : '---',
                    ));
                }
                break;

            case 'ingalleryfolder':
                $this->view->put('C_FILES_IN_GALLERY_FOLDER', true);

                foreach (ReviewService::get_files_on_server('/gallery/pics') as $file)
                {
                    $this->view->assign_block_vars('ingalleryfolder', array(
                        'C_IS_PICTURE_FILE'      => ReviewService::is_picture_file($file),
                        'C_IS_PDF_FILE'          => ReviewService::is_pdf_file($file),
                        'FILE_IN_GALLERY_FOLDER' => $file,
                    ));
                }
                break;

            case 'ingallerytable':
                $this->view->put('C_FILES_IN_GALLERY_TABLE', true);

                foreach (ReviewService::get_files_in_table('gallery') as $file)
                {
                    $this->view->assign_block_vars('ingallerytable', array(
                        'C_IS_PICTURE_FILE'     => ReviewService::is_picture_file($file),
                        'C_IS_PDF_FILE'         => ReviewService::is_pdf_file($file),
                        'FILE_IN_GALLERY_TABLE' => $file,
                    ));
                }
                break;

            case 'inupload':
                $this->view->put('C_FILES_IN_UPLOAD', true);

                foreach (ReviewService::get_files_in_table('upload') as $file)
                {
                    $this->view->assign_block_vars('inupload', array(
                        'C_IS_PICTURE_FILE' => ReviewService::is_picture_file($file),
                        'C_IS_PDF_FILE'     => ReviewService::is_pdf_file($file),
                        'FILE_IN_UPLOAD'    => $file
                    ));
                }
                break;

            case 'incontent':
                $this->view->put('C_FILES_IN_CONTENT', true);

                foreach (ReviewService::get_files_in_content() as $file)
                {
                    $link = ReviewService::get_file_link($file);
                    $this->view->assign_block_vars('incontent', array(
                        'C_IS_PICTURE_FILE'  => ReviewService::is_picture_file($file['file_path']),
                        'C_IS_PDF_FILE'      => ReviewService::is_pdf_file($file['file_path']),
                        'FILE_PATH'          => $file['file_path'],
                        'FILE_MODULE_SOURCE' => $file['module_source'],
                        'C_FILE_ITEM_TITLE'  => !empty($link),
                        'FILE_ITEM_TITLE'    => $file['item_title'],
                        'FILE_ITEM_LINK'     => isset($link) ? $link : ''
                    ));
                }
                break;

            case 'allunused':
                $this->view->put('C_ALL_UNUSED_FILES', true);

                foreach (ReviewService::get_all_unused_files() as $file)
                {
                    $this->view->assign_block_vars('allunused', array(
                        'C_IS_PICTURE_FILE' => ReviewService::is_picture_file($file),
                        'C_IS_PDF_FILE'     => ReviewService::is_pdf_file($file),
                        'FILE_PATH'         => $file,
                    ));
                }
                break;

            case 'usednoserver':
                $this->view->put('C_USED_FILES_NOT_ON_SERVER', true);

                foreach (ReviewService::get_data_used_files_not_on_server() as $file)
                {
                    $link = ReviewService::get_file_link($file);
                    $this->view->assign_block_vars('usednoserver', array(
                        'FILE_PATH'          => $file['file_path'],
                        'FILE_MODULE_SOURCE' => $file['module_source'],
                        'C_FILE_ITEM_TITLE'  => !empty($link),
                        'FILE_ITEM_TITLE'    => $file['item_title'],
                        'FILE_ITEM_LINK'     => isset($link) ? $link : ''
                    ));
                }
                break;

            case 'unuseduser':
                $this->view->put('C_UNUSED_FILES_USER', true);

                foreach (ReviewService::get_unused_files_with_users() as $file)
                {
                    $upload_date = Date::to_format($file['timestamp'], Date::FORMAT_DAY_MONTH_YEAR_HOUR_MINUTE);
                    $file_size = $file['file_size'] > 1024 ? NumberHelper::round($file['file_size'] / 1024, 2) . ' ' . $this->lang['common.unit.megabytes'] : NumberHelper::round($file['file_size'], 0) . ' ' . $this->lang['common.unit.kilobytes'];

                    $this->view->assign_block_vars('unuseduser', array(
                        'C_IS_PICTURE_FILE' => ReviewService::is_picture_file($file),
                        'C_IS_PDF_FILE'     => ReviewService::is_pdf_file($file),
                        'FILE_PATH'         => $file['file_path'],
                        'FILE_USER'         => $file['display_name'],
                        'FILE_UPLOAD_DATE'  => $upload_date,
                        'FILE_SIZE'         => $file_size,
                    ));
                }
                break;

            case 'orphan':
                $this->view->put('C_ORPHAN_FILES', true);

                foreach (ReviewService::get_orphan_files() as $file)
                {
                    $this->view->assign_block_vars('orphan', array(
                        'C_IS_PICTURE_FILE' => ReviewService::is_picture_file($file),
                        'C_IS_PDF_FILE'     => ReviewService::is_pdf_file($file),
                        'FILE_PATH'         => $file,
                    ));
                }
                break;

            case 'nogalleryfolder':
                $this->view->put('C_FILES_NOT_IN_GALLERY_FOLDER', true);

                foreach (ReviewService::get_files_not_in_gallery_folder() as $file)
                {
                    $this->view->assign_block_vars('nogalleryfolder', array(
                        'FILE_PATH' => $file,
                    ));
                }
                break;

            case 'nogallerytable':
                $this->view->put('C_FILES_NOT_IN_GALLERY_TABLE', true);

                foreach (ReviewService::get_files_not_in_gallery_table() as $file)
                {
                    $this->view->assign_block_vars('nogallerytable', array(
                        'FILE_PATH' => $file,
                    ));
                }
                break;
        }

        return new ReviewDisplayResponse($this->view, $this->lang['review.module.title'] . $this->lang['review.' . $section . '']);
    }
}
?>
