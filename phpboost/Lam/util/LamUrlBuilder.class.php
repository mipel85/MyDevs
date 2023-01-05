<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel85@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2022 12 27
 * @since       PHPBoost 6.0 - 2022 12 20
*/

class LamUrlBuilder
{
    private static $dispatcher = '/Lam';
    
    /**
	 * @return Url
	 */
	public static function configuration()
	{
		return DispatchManager::get_url(self::$dispatcher, '/admin/config');
	}

    public static function activity()
	{
		return DispatchManager::get_url(self::$dispatcher, '/activity/');
	}

    public static function home()
    {
        return DispatchManager::get_url(self::$dispatcher, '/');
    }
}
?>

	