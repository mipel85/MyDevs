<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class PlanningCache implements CacheData
{
	private $items = array();

	public function synchronize()
	{
		$year = date('Y');
		$month = date('n');
		$bissextile = (date("L", mktime(0, 0, 0, 1, 1, $year)) == 1) ? 29 : 28;
		$array_month = array(31, $bissextile, 31, 30, 31, 30 , 31, 31, 30, 31, 30, 31);
		$month_days = $array_month[$month - 1];

		$this->items = PlanningService::get_all_current_month_items($month, $year, $month_days);
	}

	public function get_items()
	{
		return $this->items;
	}

	/**
	 * Loads and returns current month items cached data.
	 * @return PlanningCurrentMonthEventsCache The cached data
	 */
	public static function load()
	{
		return CacheManager::load(__CLASS__, 'planning', 'currentmonthevents');
	}

	/**
	 * Invalidates the current Planning month items cached data.
	 */
	public static function invalidate()
	{
		CacheManager::invalidate('planning', 'currentmonthevents');
	}
}
?>
