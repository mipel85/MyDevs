<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2024 01 18
*/

class LamclubsDeleteItemController extends ModuleController
{
	private $item;

	public function execute(HTTPRequestCustom $request)
	{
		AppContext::get_session()->csrf_get_protect();

		$item = $this->get_item($request);

		if (!$item->is_authorized_to_delete() || AppContext::get_current_user()->is_readonly())
		{
			$error_controller = PHPBoostErrors::user_not_authorized();
			DispatchManager::redirect($error_controller);
		}

		LamclubsService::delete($item->get_club_id());

		if (!LamclubsAuthorizationsService::check_authorizations()->write() && LamclubsAuthorizationsService::check_authorizations()->contribution())
			ContributionService::generate_cache();

		HooksService::execute_hook_action('delete', self::$module_id, $item->get_properties());

		AppContext::get_response()->redirect(LamclubsUrlBuilder::home(), StringVars::replace_vars(LangLoader::get_message('lamclubs.message.success.delete', 'common', 'lamclubs'), array('name' => $item->get_name())));
	}

	private function get_item(HTTPRequestCustom $request)
	{
		$club_id = $request->get_getint('club_id', 0);

		if (!empty($club_id))
		{
			try {
				return LamclubsService::get_item($club_id);
			} catch (RowNotFoundException $e) {
				$error_controller = PHPBoostErrors::unexisting_page();
				DispatchManager::redirect($error_controller);
			}
		}
	}
}
?>
