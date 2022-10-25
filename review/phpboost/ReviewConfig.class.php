<?php
/**
 * @copyright   &copy; 2005-2022 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2022 10 17
 * @since       PHPBoost 6.0 - 2022 08 26
 */

class ReviewConfig extends AbstractConfigData
{
	const DATE = 'date';

	public function set_date(Date $value)
	{
		$this->set_property(self::DATE, $value);
	}

	public function get_date()
	{
		return $this->get_property(self::DATE);
	}
	
	public function get_default_values()
	{
		return array(
			self::DATE => new Date(),
		);
	}

	/**
	 * Returns the configuration.
	 * @return ReviewConfig
	 */
	public static function load()
	{
		return ConfigManager::load(__CLASS__, 'review', 'config');
	}

	/**
	 * Saves the configuration in the database. Has it become persistent.
	 */
	public static function save()
	{
		ConfigManager::save('review', self::load(), 'config');
	}
}
?>
