<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2025 01 29
 * @since       PHPBoost 6.0 - 2020 01 18
 */

class FinancialConfig extends AbstractConfigData
{
    public const RESET_DATE = 'reset_date';
    public const WINTER_BREAK = 'winter_break';
    public const AUTHORIZATIONS = 'authorizations';

    public function get_winter_break()
    {
        return $this->get_property(self::WINTER_BREAK);
    }

    public function set_winter_break($winter_break)
    {
        $this->set_property(self::WINTER_BREAK, $winter_break);
    }

    public function get_reset_date()
    {
        return $this->get_property(self::RESET_DATE);
    }

    public function set_reset_date($reset_date)
    {
        $this->set_property(self::RESET_DATE, $reset_date);
    }

    /**
     * @method Get authorizations
     * @return array
     */
    public function get_authorizations()
    {
        return $this->get_property(self::AUTHORIZATIONS);
    }

    /**
     * @method Set authorizations
     * @param array Array of authorizations
     */
    public function set_authorizations(array $authorizations)
    {
        $this->set_property(self::AUTHORIZATIONS, $authorizations);
    }

    /**
     * @method Get default values.
     */
    public function get_default_values()
    {
        return array(
            self::WINTER_BREAK     => false,
            self::RESET_DATE       => '',
            self::AUTHORIZATIONS   => array('r0' => 5, 'r1' => 13)
        );
    }

    /**
     * @method Load financial configuration.
     * @return FinancialConfig
     */
    public static function load()
    {
        return ConfigManager::load(__CLASS__, 'financial', 'config');
    }

    /**
     * @method Saves financial configuration in database. It becomes persistent.
     */
    public static function save()
    {
        ConfigManager::save('financial', self::load(), 'config');
    }
}