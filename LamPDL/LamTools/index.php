<?php
/*
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2023 03 03
 * @since       PHPBoost 6.0 - 2022 12 20
 */
define('PATH_TO_ROOT', '..');

require_once PATH_TO_ROOT . '/kernel/init.php';
$url_controller_mappers = array(
    new UrlControllerMapper('FinancialFormActivityController', '`^/activity/?$`'),
    new UrlControllerMapper('FinancialHomeController', '`^(?:/([0-9]+))?/?$`'),
    new UrlControllerMapper('AdminFinancialConfigController', '`^/admin(?:/config)?/?$`'),
    
    new UrlControllerMapper('FinancialPendingRequestsController', '`^/pending_requests/?$`'),
    new UrlControllerMapper('FinancialStatementController', '`^/financial_statement/?$`'),
    new UrlControllerMapper('FinancialAjaxPaymentController', '`^/payment_validation/?$`'),
    
    new UrlControllerMapper('FinancialArchivedRequestsController', '`^/archived_requests/?$`'),
);
DispatchManager::dispatch($url_controller_mappers);
?>
