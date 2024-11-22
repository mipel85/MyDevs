<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 11 22
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class FinancialTreeLinks implements ModuleTreeLinksExtensionPoint
{
    public function get_actions_tree_links()
    {
        $tree = new ModuleTreeLinks();
        $lang = LangLoader::get_all_langs('financial');
        $budget_archive_tables = PersistenceContext::get_dbms_utils()->list_module_tables('financial_budget_');
        $budget = end($budget_archive_tables);
        $table_year = explode('_', $budget);
        $year = end($table_year);

        $tree->add_link(new ModuleLink($lang['financial.pending.items'], FinancialUrlBuilder::display_pending_items(), FinancialAuthorizationsService::check_authorizations()->contribution()));
        $tree->add_link(new ModuleLink($lang['financial.archived.items'], FinancialUrlBuilder::display_archived_items(), FinancialAuthorizationsService::check_authorizations()->moderation()));
        
        if (!empty($budget_archive_tables)) {
            $tree->add_link(new ModuleLink($lang['financial.archived.budget'], FinancialUrlBuilder::display_archived_budgets($year), FinancialAuthorizationsService::check_authorizations()->write()));
        }
        $tree->add_link(new ModuleLink($lang['financial.budget.add'], FinancialUrlBuilder::add_budget(), FinancialAuthorizationsService::check_authorizations()->moderation()));

        
        $statement = new AdminModuleLink($lang['financial.statement'], FinancialUrlBuilder::statement());
        $statement->add_sub_link(new AdminModuleLink($lang['financial.chart.budgets.used'], FinancialUrlBuilder::statement()));
        $statement->add_sub_link(new AdminModuleLink($lang['financial.budgets.statement'], FinancialUrlBuilder::expenses_list()));
		$tree->add_link($statement);
        
        $tree->add_link(new AdminModuleLink($lang['form.configuration'], FinancialUrlBuilder::configuration()));
        return $tree;
    }
}
