<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 11
 * @since       PHPBoost 6.0 - 2020 01 18
 */
class LamdeskExtensionPointProvider extends ModuleExtensionPointProvider
{
    public function __construct()
    {
        parent::__construct('lamdesk');
    }

    public function css_files()
    {
        $module_css_files = new ModuleCssFiles();
        $module_css_files->adding_running_module_displayed_file('lamdesk.css');
        return $module_css_files;
    }
    
    public function home_page()
    {
        return new DefaultHomePageDisplay($this->get_id(), LamdeskTdbController::get_view());
    }
}
