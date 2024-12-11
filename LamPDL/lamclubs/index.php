<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 11
 * @since       PHPBoost 6.0 - 2024 01 18
 */

define('PATH_TO_ROOT', '..');

require_once PATH_TO_ROOT . '/kernel/init.php';

$url_controller_mappers = array(
  // Configuration
  new UrlControllerMapper('AdminLamclubsConfigController', '`^/admin(?:/config)?/?$`'),
  
// Item
  new UrlControllerMapper('LamclubsItemFormController', '`^/add/?$`'),
  new UrlControllerMapper('LamclubsItemFormController', '`^/([0-9]+)/edit/?$`', array('club_id')),
  new UrlControllerMapper('LamclubsDeleteItemController', '`^/([0-9]+)/delete/?$`', array('club_id')),
  new UrlControllerMapper('LamclubsVisitItemController', '`^/visit/([0-9]+)/?$`', array('id')),

// Homepage
  new UrlControllerMapper('LamclubsHomeController', '`^/?$`'),
);
DispatchManager::dispatch($url_controller_mappers);
?>
