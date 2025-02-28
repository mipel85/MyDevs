<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 14
 * @since       PHPBoost 6.0 - 2024 02 09
 */

define('PATH_TO_ROOT', '..');

require_once PATH_TO_ROOT . '/kernel/init.php';

$url_controller_mappers = array(
// Admin
new UrlControllerMapper('AdminFinancialConfigController', '`^/admin(?:/config)?/?$`'),

// Manage items
new UrlControllerMapper('FinancialBudgetFormController', '`^/add_budget/?$`'),
new UrlControllerMapper('FinancialBudgetFormController', '`^/([0-9]+)/edit_budget/?$`', array('id')),
new UrlControllerMapper('FinancialDeleteBudgetController', '`^/([0-9]+)/delete_budget/?$`', array('id')),

// Manage budgets
new UrlControllerMapper('FinancialBudgetArchivedController', '`^/budgets/?([0-9]+)?/?$`', array('year')),
new UrlControllerMapper('FinancialBudgetMonitoringController', '`^/monitoring/?([0-9]+)?/?$`', array('page')),

// Manage budgets
new UrlControllerMapper('FinancialRequestFormController', '`^/add/?([0-9]+)?/?$`', array('budget_id')),
new UrlControllerMapper('FinancialRequestFormController', '`^/edit/?([0-9]+)?/?([0-9]+)?/?$`', array('id', 'budget_id')),
new UrlControllerMapper('FinancialRequestDeleteController', '`^/([0-9]+)/delete/?$`', array('id')),
new UrlControllerMapper('FinancialRequestsPendingController', '`^/pending/?([0-9]+)?/?$`', array('page')),
new UrlControllerMapper('FinancialRequestsMemberController', '`^/member/?([0-9]+)/?([0-9]+)?/?$`', array('user', 'page')),
new UrlControllerMapper('FinancialRequestsClubController', '`^/club/?([0-9]+)/?([0-9]+)?/?$`', array('club', 'page')),
new UrlControllerMapper('FinancialFileEstimateController', '`^/estimate/?([0-9]+)?/?$`', array('id')),
new UrlControllerMapper('FinancialFileInvoiceController', '`^/invoice/?([0-9]+)?/?$`', array('id')),
new UrlControllerMapper('FinancialRequestsArchivedController', '`^/requests/?([0-9]+)?/?$`', array('year')),

// Ajax
new UrlControllerMapper('FinancialRequestRejectController', '`^/reject/?([0-9]+)?/?$`', array('id')),
new UrlControllerMapper('FinancialRequestOngoingController', '`^/ongoing/?([0-9]+)?/?$`', array('id')),
new UrlControllerMapper('FinancialRequestAcceptController', '`^/accept/?([0-9]+)?/?([0-9]+_{0,1}[0-9]{0,2})?/?$`', array('id', 'amount_paid')),
new UrlControllerMapper('FinancialRequestsMonitoringChartController', '`^/requests_monitoring_chart/?$`'),
new UrlControllerMapper('FinancialRequestsMonitoringListController', '`^/requests_monitoring_list/?([0-9]+)?/?$`', array('year')),

// Display financial
new UrlControllerMapper('FinancialHomeController', '`^(?:/([0-9]+))?/?$`')
);

DispatchManager::dispatch($url_controller_mappers);
?>
