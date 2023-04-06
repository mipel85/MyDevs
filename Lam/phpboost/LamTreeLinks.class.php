<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2023 03 03
 * @since       PHPBoost 6.0 - 2022 12 20
 */

class LamTreeLinks implements ModuleTreeLinksExtensionPoint
{
    public function get_actions_tree_links()
    {
        $module_id = 'Lam';
        $lang = LangLoader::get_all_langs($module_id);
		$tree = new ModuleTreeLinks();

        $tree->add_link(new ModuleLink($lang['lam.pending.requests'], LamUrlBuilder::pending_requests(), LamAuthorizationsService::check_authorizations()->officer()));
        $tree->add_link(new ModuleLink($lang['lam.financial.statement'], LamUrlBuilder::financial_statement(), LamAuthorizationsService::check_authorizations()->manager()));
        $tree->add_link(new ModuleLink($lang['lam.archived.requests'], LamUrlBuilder::archived_requests(), LamAuthorizationsService::check_authorizations()->manager()));

        $tree->add_link(new AdminModuleLink($lang['form.configuration'], LamUrlBuilder::configuration()));

        return $tree;
    }
}
?>
