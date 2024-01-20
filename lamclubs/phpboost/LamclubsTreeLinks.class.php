<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 18
 * @since       PHPBoost 6.0 - 2024 01 18
*/

class LamclubsTreeLinks implements ModuleTreeLinksExtensionPoint
{
	public function get_actions_tree_links()
	{
		$lang = LangLoader::get_all_langs('lamclubs');
		$tree = new ModuleTreeLinks();

		$tree->add_link(new ModuleLink($lang['lamclubs.add'], LamclubsUrlBuilder::add(), LamclubsAuthorizationsService::check_authorizations()->write()));
		$tree->add_link(new AdminModuleLink($lang['form.configuration'], LamclubsUrlBuilder::configuration()));

		return $tree;
	}
}
?>
