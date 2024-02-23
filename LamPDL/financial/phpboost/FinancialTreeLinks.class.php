<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class FinancialTreeLinks implements ModuleTreeLinksExtensionPoint
{
	public function get_actions_tree_links()
	{
		$tree = new ModuleTreeLinks();
		$lang = LangLoader::get_all_langs('financial');

        $tree->add_link(new ModuleLink($lang['financial.pending.items'], FinancialUrlBuilder::display_pending_items(), FinancialAuthorizationsService::check_authorizations()->contribution()));
        $tree->add_link(new ModuleLink($lang['financial.archived.items'], FinancialUrlBuilder::display_archived_items(), FinancialAuthorizationsService::check_authorizations()->moderation()));
        $tree->add_link(new ModuleLink($lang['financial.monitoring'], FinancialUrlBuilder::display_monitoring_items(), FinancialAuthorizationsService::check_authorizations()->write()));
        $tree->add_link(new ModuleLink($lang['financial.archived.budgets'], FinancialUrlBuilder::display_archived_budgets(), FinancialAuthorizationsService::check_authorizations()->write()));
        $tree->add_link(new ModuleLink($lang['financial.budget.add'], FinancialUrlBuilder::add_budget(), FinancialAuthorizationsService::check_authorizations()->moderation()));

		$tree->add_link(new AdminModuleLink($lang['form.configuration'], FinancialUrlBuilder::configuration()));

		return $tree;
	}
}
?>
