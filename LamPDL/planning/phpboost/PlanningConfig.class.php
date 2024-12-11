<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 11
 * @since       PHPBoost 6.0 - 2020 01 18
 */

class PlanningConfig extends AbstractConfigData
{
    const AUTHORIZATIONS = 'authorizations';

    public function is_googlemaps_available()
    {
        return ModulesManager::is_module_installed('GoogleMaps') && ModulesManager::is_module_activated('GoogleMaps') && GoogleMapsConfig::load()->get_api_key();
    }

    /**
     * @method Get authorizations
     */
    public function get_authorizations()
    {
        return $this->get_property(self::AUTHORIZATIONS);
    }

    /**
     * @method Set authorizations
     * @params string[] $array Array of authorizations
     */
    public function set_authorizations(Array $authorizations)
    {
        $this->set_property(self::AUTHORIZATIONS, $authorizations);
    }

    /**
     * @method Get default values.
     */
    public function get_default_values()
    {
        return array(
          self::AUTHORIZATIONS => array('r-1' => 1, 'r0' => 5, 'r1' => 15)
        );
    }

    /**
     * @method Load planning configuration.
     * @return PlanningConfig
     */
    public static function load()
    {
        return ConfigManager::load(__CLASS__, 'planning', 'config');
    }

    /**
     * @method Saves the planning configuration in the database. It becomes persistent.
     */
    public static function save()
    {
        ConfigManager::save('planning', self::load(), 'config');
    }
}
?>
