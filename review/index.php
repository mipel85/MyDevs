<?php
/**
 * @copyright   &copy; 2022 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel <mipel@gmail.com>
 * @version     PHPBoost 6.0 - last update: 2022 01 05
 * @since       PHPBoost 6.0 - 2022 01 10
 */
define('PATH_TO_ROOT', '..');

require_once PATH_TO_ROOT . '/kernel/init.php';

$url_controller_mappers = array(
    new UrlControllerMapper('ReviewHomeController', '`^(?:/([0-9]+))?/?$`'),
    new UrlControllerMapper('ReviewDisplayController', '`^/([a-z]+)/?$`', array('section')),
);
DispatchManager::dispatch($url_controller_mappers);
?>