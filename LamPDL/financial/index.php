<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 08 14
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
	new UrlControllerMapper('FinancialBudgetArchivesController', '`^/budgets/?([0-9]+)?/?$`', array('year')),
	new UrlControllerMapper('FinancialBudgetMonitoringController', '`^/monitoring/?([0-9]+)?/?$`', array('page')),
	new UrlControllerMapper('FinancialRequestFormController', '`^/add/?([0-9]+)?/?$`', array('budget_id')),
	new UrlControllerMapper('FinancialRequestFormController', '`^/edit/?([0-9]+)?/?([0-9]+)?/?$`', array('id', 'budget_id')),
	new UrlControllerMapper('FinancialRequestDeleteController', '`^/([0-9]+)/delete/?$`', array('id')),

	new UrlControllerMapper('FinancialRequestsArchivedController', '`^/archived/?$`'),
	new UrlControllerMapper('FinancialRequestsPendingController', '`^/pending/?([0-9]+)?/?$`', array('page')),
    new UrlControllerMapper('FinancialFileEstimateController', '`^/estimate/?([0-9]+)?/?$`', array('id')),
    new UrlControllerMapper('FinancialFileInvoiceController', '`^/invoice/?([0-9]+)?/?$`', array('id')),

    // Ajax
    new UrlControllerMapper('FinancialRequestRejectController', '`^/reject/?([0-9]+)?/?$`', array('id')),
    new UrlControllerMapper('FinancialRequestOngoingController', '`^/ongoing/?([0-9]+)?/?$`', array('id')),

    /* création url montant forfaitaire : /accept/3/50 --- 3 = id de la ddemande --- 50 montant rempli automatiquement   
     [0-9]{1,4}_{0,1} si valeur forfaitaire, unserscore pas utile donc 0 caractère
     création url montant saisi : /accept/3/562_55 --- 3 = id de la demande --- 562_55 montant saisi par le trésorier   
     [0-9]{1,4}_{0,1} si valeur saisie selon pourcentage, unserscore utile donc 1 caractère
     unités entre 1 et 4 chiffres ou zéro (si montant forfaitaire) avec 2 décimales  */
    new UrlControllerMapper('FinancialRequestAcceptController', '`^/accept/?([0-9]+)?/?([0-9]+_{0,1}[0-9]{0,2})?/?$`', array('id', 'amount_paid')),
	
    // Display financial
	new UrlControllerMapper('FinancialHomeController', '`^(?:/([0-9]+))?/?$`'),
);
DispatchManager::dispatch($url_controller_mappers);
?>
