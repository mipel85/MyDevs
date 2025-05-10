<?php
/**
 * @copyright   &copy; 2005-2024 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      mipel <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 22
 * @since       PHPBoost 6.0 - 2024 12 22
 */

class LamdeskUrlBuilder
{
    private static $dispatcher = '/lamdesk';
    
    public static function menu()
    {
        return DispatchManager::get_url(self::$dispatcher, '/menu/');
    }
    
    public static function tdb()
    {
        return DispatchManager::get_url(self::$dispatcher, '/tdb/');
    }
    
    public static function tdb_ajax()
    {
        return DispatchManager::get_url(self::$dispatcher, '/tdb_ajax/');
    }
    
    public static function home()
    {
        return DispatchManager::get_url(self::$dispatcher, '/tdb/');
    }
}
?>
