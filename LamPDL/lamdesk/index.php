<?php
/**
 * @copyright   &copy; 2005-2024 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      mipel <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 22
 * @since       PHPBoost 6.0 - 2024 12 22
 */

define('PATH_TO_ROOT', '..');

require_once PATH_TO_ROOT . '/kernel/init.php';

$url_controller_mappers = array(
    new UrlControllerMapper('LamdeskMenuController', '`^/menu/?$`'),
    
    new UrlControllerMapper('LamdeskTdbController', '`^/tdb/?$`'),
    new UrlControllerMapper('LamdeskTdbAjaxController', '`^/tdb_ajax/?$`'),
    
    // Homepage
    new UrlControllerMapper('LamdeskHomeController', '`^/tdb/?$`'),
);

DispatchManager::dispatch($url_controller_mappers);
?>
