<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class PlanningScheduledJobs extends AbstractScheduledJobExtensionPoint
{
	/**
	 * {@inheritDoc}
	 */
	public function on_changeday(Date $yesterday, Date $today)
	{
		if ($today->get_day() == 1)
			PlanningCache::invalidate();
	}
}
?>
