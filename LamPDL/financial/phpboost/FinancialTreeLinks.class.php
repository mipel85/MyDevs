<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 18
 * @since       PHPBoost 6.0 - 2024 01 18
 */
class FinancialTreeLinks implements ModuleTreeLinksExtensionPoint
{

    public function get_actions_tree_links()
    {
        $lang = LangLoader::get_all_langs('financial');
        $tree = new ModuleTreeLinks();

        $tree->add_link(new AdminModuleLink($lang['form.configuration'], FinancialUrlBuilder::configuration()));

        $tree->add_link(new ModuleLink($lang['financial.pending.requests'], FinancialUrlBuilder::pending_requests(), FinancialAuthorizationsService::check_authorizations()->officer()));
        $tree->add_link(new ModuleLink($lang['financial.financial.statement'], FinancialUrlBuilder::financial_statement(), FinancialAuthorizationsService::check_authorizations()->manager()));
        $tree->add_link(new ModuleLink($lang['financial.archived.requests'], FinancialUrlBuilder::archived_requests(), FinancialAuthorizationsService::check_authorizations()->manager()));

        return $tree;
    }
}
?>
