<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 18
 * @since       PHPBoost 6.0 - 2024 01 18
*/

class LamClubsTreeLinks implements ModuleTreeLinksExtensionPoint
{
	public function get_actions_tree_links()
	{
		$lang = LangLoader::get_all_langs('LamClubs');
		$tree = new ModuleTreeLinks();

		$tree->add_link(new ModuleLink($lang['lamclubs.add'], LamClubsUrlBuilder::add(), LamClubsAuthorizationsService::check_authorizations()->write()));
		$tree->add_link(new AdminModuleLink($lang['form.configuration'], LamClubsUrlBuilder::configuration()));

		return $tree;
	}
}
?>
