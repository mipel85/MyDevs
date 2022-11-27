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
	const SCANNED_BY = 'scanned_by';
	const FIRST_SCAN = 'first_scan';
	const FOLDERS = 'folders';

	public function set_date(Date $date)
	{
		$this->set_property(self::DATE, $date);
	}

	public function get_date()
	{
		return $this->get_property(self::DATE);
	}

	public function set_scanned_by(User $user)
	{
		$this->set_property(self::SCANNED_BY, $user);
	}

	public function get_scanned_by()
	{
		return $this->get_property(self::SCANNED_BY);
	}

	public function set_first_scan($first_scan)
	{
		$this->set_property(self::FIRST_SCAN, $first_scan);
	}

	public function get_first_scan()
	{
		return $this->get_property(self::FIRST_SCAN);
	}

	public function add_folder($folder)
	{
		$this->folders[] = $folder;
	}

	public function set_folders($folders)
	{
		$this->folders = $folders;
	}

	public function get_folders()
	{
		return $this->folders;
	}
	
	public function get_default_values()
	{
		return array(
			self::DATE => new Date(),
			self::SCANNED_BY => AppContext::get_current_user(),
			self::FIRST_SCAN => false,
			self::FOLDERS => array(),
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
