<?php
/**
 * @copyright   &copy; 2022 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel <mipel@gmail.com>
 * @version     PHPBoost 6.0 - last update: 2023 07 28
 * @since       PHPBoost 6.0 - 2022 01 10
 */

class ReviewDisplayController extends DefaultAdminModuleController
{
    public function execute(HTTPRequestCustom $request)
    {
        $this->build_form();

        $this->view = new FileTemplate('review/ReviewDisplayController.tpl');
		$this->view->add_lang($this->lang);

        $cache_in_table = ReviewCacheInTable::load();
        $cache_in_folder = ReviewCacheInFolder::load();
        $folders_to_scan = TextHelper::deserialize($this->config->get_folders());

        if ($this->submit_button->has_been_submited() && $this->form->validate()){
            $this->config->set_date(new Date());
            $this->config->set_scanned_by(AppContext::get_current_user());
            $this->config->set_first_scan(true);
            ReviewConfig::save();
            ReviewService::delete_files_incontenttable();
            foreach(TextHelper::deserialize($folders_to_scan) as $k => $folder)
            {
                ReviewService::insert_files_incontenttable($folder->get_id());
            }
            ReviewCacheInTable::invalidate();
            ReviewCacheInFolder::invalidate();
            AppContext::get_response()->redirect($request->get_url_referrer());
        }
        $date = $this->config->get_date()->get_timestamp();

        $folders_number = count($folders_to_scan);
        $i = 1;
        foreach ($folders_to_scan as $folder)
        {
            $this->view->assign_block_vars('folderstoscan', array(
                'C_SEPARATOR' => $i < $folders_number,
                'FOLDERS_TO_SCAN' => $folder->get_id(),
            ));
            $i++;
        }

        $this->view->put_all(array(
            'C_FOLDERS_TO_SCAN'   => !empty($folders_to_scan),
            'C_DISPLAY_COUNTERS'  => $this->config->get_first_scan(),
            'C_GALLERY_DISPLAYED' => ReviewService::is_module_displayed('gallery'),
            'C_GALLERY_FOLDER'    => ReviewService::is_folder_on_server('/gallery'),
            'DATE'                => Date::to_format($date, Date::FORMAT_DAY_MONTH_YEAR_HOUR_MINUTE),
            'SCANNED_BY'          => $this->config->get_scanned_by()->get_display_name(),
            'REVIEW_COUNTERS'     => ReviewCounters::get_counters(),
            'CACHE_BUTTON'        => $this->form->display(),
        ));

        $section = $request->get_string('section');
        switch($section)
        {
            case 'inuploadfolder':
                $this->view->put('C_FILES_IN_UPLOAD_FOLDER', true);

                foreach ($cache_in_folder->get_files_in_upload_list() as $file)
                {
                    $file_data = ReviewService::get_upload_data_file($file);
                    $this->view->assign_block_vars('inuploadfolder', array(
                        'C_IS_PICTURE_FILE' => ReviewService::is_picture_file($file),
                        'C_IS_PDF_FILE'     => ReviewService::is_pdf_file($file),
                        'FILE_NAME'         => $file,
                        'FILE_UPLOAD_BY'    => isset($file_data['display_name']) ? $file_data['display_name'] : '---',
                        'FILE_UPLOAD_DATE'  => isset($file_data['timestamp']) ? $file_data['timestamp'] : '---',
                        'FILE_UPLOAD_SIZE'  => isset($file_data['file_size']) ? $file_data['file_size'] : '---',
                    ));
                }
                break;

            case 'inuploadtable':
                $this->view->put('C_FILES_IN_UPLOAD_TABLE', true);

                foreach ($cache_in_table->get_files_in_upload_list() as $file)
                {
                    $file_in_upload = new File(PATH_TO_ROOT . '/upload/' . $file['path']);
                    $this->view->assign_block_vars('inuploadtable', array(
                        'C_FILE'            => $file_in_upload->exists(),
                        'C_IS_PICTURE_FILE' => ReviewService::is_picture_file($file['path']),
                        'C_IS_PDF_FILE'     => ReviewService::is_pdf_file($file['path']),
                        'FILE_NAME'         => $file['path'],
                        'FILE_UPLOAD_BY'    => isset($file['display_name']) ? $file['display_name'] : '---',
                        'FILE_UPLOAD_DATE'  => isset($file['timestamp']) ? Date::to_format($file['timestamp'], Date::FORMAT_DAY_MONTH_YEAR_HOUR_MINUTE) : '---',
                        'FILE_UPLOAD_SIZE'  => isset($file['size']) ? ($file['size'] > 1024 ? NumberHelper::round($file['size'] / 1024, 2) . ' ' . LangLoader::get_message('common.unit.megabytes', 'common-lang') : NumberHelper::round($file['size'], 0) . ' ' . LangLoader::get_message('common.unit.kilobytes', 'common-lang')) : '---',
                    ));
                }
                break;

            case 'incontenttable':
                $this->view->put('C_FILES_IN_CONTENT', true);

                foreach ($cache_in_table->get_files_in_content_list() as $file)
                {
                    $link = ReviewService::get_file_link($file);
                    $file_in_content = new File(PATH_TO_ROOT . '/upload/' . $file['path']);
                    $this->view->assign_block_vars('incontenttable', array(
                        'C_FILE'             => $file_in_content->exists(),
                        'C_IS_PICTURE_FILE'  => ReviewService::is_picture_file($file['path']),
                        'C_IS_PDF_FILE'      => ReviewService::is_pdf_file($file['path']),
                        'FILE_PATH'          => $file['path'],
                        'FILE_MODULE_SOURCE' => $file['module_source'],
                        'C_FILE_ITEM_TITLE'  => !empty($link),
                        'FILE_ITEM_TITLE'    => $file['item_title'],
                        'FILE_ITEM_LINK'     => isset($link) ? $link : '',
                        'FILE_UPLOAD_BY'     => isset($file['upload_by']) ? $file['upload_by'] : '---',
                        'FILE_UPLOAD_DATE'   => isset($file['upload_date']) ? $file['upload_date'] : '---',
                        'FILE_UPLOAD_SIZE'   => isset($file['file_size']) ? $file['file_size'] : '---',
                    ));
                }
                break;

            case 'allunused':
                $this->view->put('C_ALL_UNUSED_FILES', true);

                foreach (ReviewService::get_allunused_files() as $file)
                {
                    $this->view->assign_block_vars('allunused', array(
                        'C_IS_PICTURE_FILE' => ReviewService::is_picture_file($file),
                        'C_IS_PDF_FILE'     => ReviewService::is_pdf_file($file),
                        'FILE_PATH'         => $file,
                    ));
                }
                break;

            case 'usedbutmissing':
                $this->view->put('C_USED_FILES_NOT_ON_SERVER', true);

                foreach (ReviewService::get_data_used_files_not_on_server() as $file)
                {
                    $link = ReviewService::get_file_link($file);
                    $this->view->assign_block_vars('usedbutmissing', array(
                        'C_FILE_ITEM_TITLE'  => !empty($link),
                        'FILE_PATH'          => $file['path'],
                        'FILE_MODULE_SOURCE' => $file['module_source'],
                        'FILE_ITEM_TITLE'    => $file['item_title'],
                        'FILE_ITEM_LINK'     => isset($link) ? $link : ''
                    ));
                }
                break;

            case 'unusedbutintable':
                $this->view->put('C_UNUSED_FILES_IN_TABLE', true);

                foreach (ReviewService::get_unused_files_with_users() as $file)
                {
                    $file_size = $file['file_size'] > 1024 ? NumberHelper::round($file['file_size'] / 1024, 2) . ' ' . $this->lang['common.unit.megabytes'] : NumberHelper::round($file['file_size'], 0) . ' ' . $this->lang['common.unit.kilobytes'];

                    $file_in_upload = new File(PATH_TO_ROOT . '/upload/' . $file['path']);
                    $this->view->assign_block_vars('unusedbutintable', array(
                        'C_FILE'            => $file_in_upload->exists(),
                        'C_IS_PICTURE_FILE' => ReviewService::is_picture_file($file['path']),
                        'C_IS_PDF_FILE'     => ReviewService::is_pdf_file($file['path']),
                        'FILE_PATH'         => $file['path'],
                        'FILE_USER'         => $file['display_name'],
                        'FILE_UPLOAD_DATE'  => Date::to_format($file['timestamp'], Date::FORMAT_DAY_MONTH_YEAR_HOUR_MINUTE),
                        'FILE_SIZE'         => $file_size,
                    ));
                }
                break;

            case 'orphans':
                $this->view->put('C_ORPHAN_FILES', true);

                foreach (ReviewService::get_orphans_files() as $file)
                {
                    $this->view->assign_block_vars('orphans', array(
                        'C_IS_PICTURE_FILE' => ReviewService::is_picture_file($file),
                        'C_IS_PDF_FILE'     => ReviewService::is_pdf_file($file),
                        'FILE_PATH'         => $file,
                    ));
                }
                break;

            case 'ingalleryfolder':
                $this->view->put('C_FILES_IN_GALLERY_FOLDER', true);

                foreach ($cache_in_folder->get_files_in_gallery_list() as $file)
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

                foreach ($cache_in_table->get_files_in_gallery_list() as $file)
                {
                    $this->view->assign_block_vars('ingallerytable', array(
                        'C_IS_PICTURE_FILE'     => ReviewService::is_picture_file($file['path']),
                        'C_IS_PDF_FILE'         => ReviewService::is_pdf_file($file['path']),
                        'FILE_IN_GALLERY_TABLE' => $file['path'],
                        'FILE_USER'             => $file['display_name'],
                        'FILE_UPLOAD_DATE'      => Date::to_format($file['timestamp'], Date::FORMAT_DAY_MONTH_YEAR_HOUR_MINUTE),
                    ));
                }
                break;

            case 'galleryusedbutmissing':
                $this->view->put('C_FILES_NOT_IN_GALLERY_FOLDER', true);

                foreach (ReviewService::get_files_not_ingalleryfolder() as $file)
                {
                    $this->view->assign_block_vars('galleryusedbutmissing', array(
                        'FILE_PATH' => $file,
                    ));
                }
                break;

            case 'galleryunusedbutintable':
                $this->view->put('C_FILES_NOT_IN_GALLERY_TABLE', true);

                foreach (ReviewService::get_files_not_in_ingallerytable() as $file)
                {
                    $this->view->assign_block_vars('galleryunusedbutintable', array(
                        'FILE_PATH' => $file,
                    ));
                }
                break;
        }

        return new ReviewDisplayResponse($this->view, $this->lang['review.' . $section . ''] . $this->lang['review.module.title']);
    }

    private function build_form()
    {
        $this->config = ReviewConfig::load();
        $form = new HTMLForm(__CLASS__);
        $this->submit_button = new FormButtonSubmit($this->config->get_first_scan() == 0 ? $this->lang['review.run.scan'] : $this->lang['review.restart.scan'], '', '', 'submit preloader-button');
        $form->add_button($this->submit_button);

        $this->form = $form;
    }
}
?>
