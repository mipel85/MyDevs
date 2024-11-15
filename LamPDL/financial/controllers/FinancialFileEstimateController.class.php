<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 02 08
 * @since       PHPBoost 6.0 - 2024 02 08
*/

class FinancialFileEstimateController extends AbstractController
{
	private $item;

	public function execute(HTTPRequestCustom $request)
	{
		$id = $request->get_getint('id', 0);

		if (!empty($id))
		{
			try {
				$this->item = FinancialRequestService::get_item($id);
			} catch (RowNotFoundException $e) {
				$error_controller = PHPBoostErrors::unexisting_page();
				DispatchManager::redirect($error_controller);
			}
		}

		if ($this->item !== null && !FinancialAuthorizationsService::check_authorizations()->read())
		{
			$error_controller = PHPBoostErrors::user_not_authorized();
			DispatchManager::redirect($error_controller);
		}
		else if ($this->item !== null)
		{
			if (Url::check_url_validity($this->item->get_estimate_url()->absolute()) || Url::check_url_validity($this->item->get_estimate_url()->relative()))
			{
				header('Content-Description: File Transfer');
				header('Content-Transfer-Encoding: binary');
                header('Cache-Control: no-cache');
				header('Accept-Ranges: bytes');
				header('Content-Type: application/force-download');
				header('Content-Disposition: attachment; filename=' . basename($this->item->get_estimate_url()->absolute()));
                ob_clean();
				set_time_limit(0);
                readfile($this->item->get_estimate_url()->absolute());
                exit;

				return $this->generate_response();
			}
			else
			{
				$error_controller = new UserErrorController(LangLoader::get_message('warning.error', 'warning-lang'), LangLoader::get_message('warning.unexisting.file', 'warning-lang'), UserErrorController::WARNING);
				DispatchManager::redirect($error_controller);
			}
		}
		else
		{
			$error_controller = PHPBoostErrors::unexisting_page();
			DispatchManager::redirect($error_controller);
		}
	}

	private function generate_response()
	{
		$response = new SiteDisplayResponse(new StringTemplate(''));

		$graphical_environment = $response->get_graphical_environment();
		$graphical_environment->set_page_title($this->item->get_request_type(), LangLoader::get_message('financial.module.title', 'common', 'financial'));
		$graphical_environment->get_seo_meta_data()->set_description($this->item->get_real_summary());
		$graphical_environment->get_seo_meta_data()->set_canonical_url(FinancialUrlBuilder::download($this->item->get_id()));

		return $response;
	}
}
?>
