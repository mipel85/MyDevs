<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel85@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2023 03 03
 * @since       PHPBoost 6.0 - 2022 12 20
*/

class ToolsUrlBuilder
{
    private static $dispatcher = '/LamTools';

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

    /**
	 * @return Url
	 */
	public static function pending_requests()
	{
		return DispatchManager::get_url(self::$dispatcher, '/pending_requests/');
	}

    /**
	 * @return Url
	 */
	public static function financial_statement()
	{
		return DispatchManager::get_url(self::$dispatcher, '/financial_statement/');
	}

    /**
	 * @return Url
	 */
	public static function archived_requests()
	{
		return DispatchManager::get_url(self::$dispatcher, '/archived_requests/');
	}

    /**
	 * @return Url
	 */
	public static function payment_validation()
	{
		return DispatchManager::get_url(self::$dispatcher, '/payment_validation/');
	}

    public static function home()
    {
        return DispatchManager::get_url(self::$dispatcher, '/');
    }
}
?>

	