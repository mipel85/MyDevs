<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel85@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2022 12 27
 * @since       PHPBoost 6.0 - 2022 12 20
 */
define('PATH_TO_ROOT', '..');

require_once PATH_TO_ROOT . '/kernel/init.php';
$url_controller_mappers = array(
    new UrlControllerMapper('LamActivityController', '`^/activity/?$`'),
    new UrlControllerMapper('LamHomeController', '`^(?:/([0-9]+))?/?$`'),
    new UrlControllerMapper('AdminLamConfigController', '`^/admin(?:/config)?/?$`'),
);
DispatchManager::dispatch($url_controller_mappers);
?>
