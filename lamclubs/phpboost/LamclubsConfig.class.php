<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2024 01 18
*/

class LamclubsConfig extends AbstractConfigData
{
	const AUTHORIZATIONS = 'authorizations';

	public function get_authorizations()
	{
		return $this->get_property(self::AUTHORIZATIONS);
	}

	public function set_authorizations(Array $authorizations)
	{
		$this->set_property(self::AUTHORIZATIONS, $authorizations);
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_default_values()
	{
		return array(
			self::AUTHORIZATIONS => array('r-1' => 1, 'r0' => 3, 'r1' => 5),
		);
	}

	/**
	 * Returns the configuration.
	 * @return LamclubsConfig
	 */
	public static function load()
	{
		return ConfigManager::load(__CLASS__, 'lamclubs', 'config');
	}

	/**
	 * Saves the configuration in the database. Has it become persistent.
	 */
	public static function save()
	{
		ConfigManager::save('lamclubs', self::load(), 'config');
	}
}
?>
