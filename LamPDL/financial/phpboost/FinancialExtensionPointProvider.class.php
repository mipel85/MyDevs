<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 11
 * @since       PHPBoost 6.0 - 2020 01 18
 */
class FinancialExtensionPointProvider extends ItemsModuleExtensionPointProvider
{
    public function home_page()
    {
        return new DefaultHomePageDisplay($this->get_id(), FinancialHomeController::get_view());
    }

    public function user()
    {
        return false;
    }

    public function js_files()
    {
        $js_file = new ModuleJsFiles();
        $js_file->adding_running_module_displayed_file('chart.min.js');
        $js_file->adding_running_module_displayed_file('https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2');
        return $js_file;
    }

    public function search()
    {
        return false;
    }
}
