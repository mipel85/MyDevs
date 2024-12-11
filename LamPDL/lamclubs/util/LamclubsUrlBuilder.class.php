<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 11
 * @since       PHPBoost 6.0 - 2024 01 18
 */

class LamclubsUrlBuilder
{
    private static $dispatcher = '/lamclubs';

    /**
     * @return Url
     */
    public static function configuration()
    {
        return DispatchManager::get_url(self::$dispatcher, '/admin/config');
    }

    /**
     * @return Url
     */
    public static function add()
    {
        return DispatchManager::get_url(self::$dispatcher, '/add/');
    }

    /**
     * @return Url
     */
    public static function edit($club_id)
    {
        return DispatchManager::get_url(self::$dispatcher, '/' . $club_id . '/edit/');
    }

    /**
     * @return Url
     */
    public static function delete($club_id)
    {
        return DispatchManager::get_url(self::$dispatcher, '/' . $club_id . '/delete/?token=' . AppContext::get_session()->get_token());
    }

    /**
     * @return Url
     */
    public static function visit_item($id)
    {
        return DispatchManager::get_url(self::$dispatcher, '/visit/' . $id);
    }

    /**
     * @return Url
     */
    public static function home()
    {
        return DispatchManager::get_url(self::$dispatcher, '/');
    }
}
?>
