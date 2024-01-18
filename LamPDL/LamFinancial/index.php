<?php
/*
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 18
 * @since       PHPBoost 6.0 - 2024 01 18
 */
define('PATH_TO_ROOT', '..');

require_once PATH_TO_ROOT . '/kernel/init.php';
$url_controller_mappers = array(
    new UrlControllerMapper('LamFinancialHomeController', '`^(?:/([0-9]+))?/?$`'),
    new UrlControllerMapper('LamFinancialFormActivityController', '`^/activity/?$`'),
    new UrlControllerMapper('LamFinancialFormDedicatedController', '`^/dedicated/?$`'),
    new UrlControllerMapper('AdminLamFinancialConfigController', '`^/admin(?:/config)?/?$`'),
    new UrlControllerMapper('LamFinancialPendingRequestsController', '`^/pending_requests/?$`'),
    new UrlControllerMapper('LamFinancialStatementController', '`^/financial_statement/?$`'),
    new UrlControllerMapper('LamFinancialAjaxPaymentController', '`^/payment_validation/?$`'),
    new UrlControllerMapper('LamFinancialArchivedRequestsController', '`^/archived_requests/?$`'),
);
DispatchManager::dispatch($url_controller_mappers);
?>
