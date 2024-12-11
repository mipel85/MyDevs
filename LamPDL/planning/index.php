<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 11
 * @since       PHPBoost 6.0 - 2020 01 18
 */

define('PATH_TO_ROOT', '..');

require_once PATH_TO_ROOT . '/kernel/init.php';

$url_controller_mappers = array(
  // Admin
  new UrlControllerMapper('AdminPlanningConfigController', '`^/admin(?:/config)?/?$`'),

  //Categories
  new UrlControllerMapper('DefaultCategoriesManagementController', '`^/categories/?$`'),
  new UrlControllerMapper('DefaultCategoriesFormController', '`^/categories/add/?([0-9]+)?/?$`', array('id_parent')),
  new UrlControllerMapper('DefaultCategoriesFormController', '`^/categories/([0-9]+)/edit/?$`', array('id')),
  new UrlControllerMapper('DefaultDeleteCategoryController', '`^/categories/([0-9]+)/delete/?$`', array('id')),
  
// Display items
  new UrlControllerMapper('PlanningItemController', '`^/([0-9]+)-([a-z0-9-_]+)/([0-9]+)-([a-z0-9-_]+)/?$`', array('id_category', 'rewrited_name_category', 'id', 'rewrited_link')),
  
// Manage items
  new UrlControllerMapper('PlanningItemsManagerController', '`^/manage/?$`'),
  new UrlControllerMapper('PlanningItemFormController', '`^/add/?([0-9]+)?/?([0-9]+)?/?([0-9]+)?/?([0-9]+)?/?([0-9]+)?/?$`', array('id_category')),
  new UrlControllerMapper('PlanningItemFormController', '`^/([0-9]+)/edit/?$`', array('id')),
  new UrlControllerMapper('PlanningDeleteItemController', '`^/([0-9]+)/delete/?$`', array('id')),
  new UrlControllerMapper('PlanningPendingItemsController', '`^/pending/?([0-9]+)?/?$`', array('page')),
  new UrlControllerMapper('PlanningMemberItemsController', '`^/member/([0-9]+)?/?([0-9]+)?/?$`', array('user_id', 'page')),
  new UrlControllerMapper('PlanningVisitItemController', '`^/visit/([0-9]+)/?$`', array('id')),
  
// Display planning
  new UrlControllerMapper('PlanningHomeController', '`^(?:/([0-9]+))?/?$`'),
);
DispatchManager::dispatch($url_controller_mappers);
?>
