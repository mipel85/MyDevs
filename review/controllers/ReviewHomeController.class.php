<?php
/**
 * @copyright   &copy; 2022 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel <mipel@gmail.com>
 * @version     PHPBoost 6.0 - last update: 2022 01 05
 * @since       PHPBoost 6.0 - 2022 01 10
 */
class ReviewHomeController extends DefaultAdminModuleController
{

	public function execute(HTTPRequestCustom $request)
	{
		ReviewService::delete_files_in_content_table();
        ReviewSetup::insert_files_in_content_table();
        
        $this->view = new FileTemplate('review/ReviewHomeController.tpl');
		$this->view->add_lang($this->lang);

		// call counters menu //        
		$this->view->put('REVIEW_COUNTERS', ReviewCounters::get_counters());

		return new AdminDisplayResponse($this->view);
	}
}
?>
