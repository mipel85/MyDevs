<?php
/**
 * @copyright   &copy; 2005-2025 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2025 02 14
 * @since       PHPBoost 6.0 - 2020 01 18
 */

class FinancialExtensionPointProvider extends ExtensionPointProvider
{
    public function home_page()
    {
        return new DefaultHomePageDisplay($this->get_id(), FinancialHomeController::get_view());
    }

    public function js_files()
    {
        $js_file = new ModuleJsFiles();
        $js_file->adding_running_module_displayed_file('chart.min.js');
        $js_file->adding_running_module_displayed_file('https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2');
        return $js_file;
    }

    public function css_files()
    {
        $module_css_files = new ModuleCssFiles();
        $module_css_files->adding_always_displayed_file('financial.css');
        return $module_css_files;
    }

    public function search()
    {
        return new FinancialSearchable();
    }

    public function tree_links()
    {
        return new FinancialTreeLinks();
    }

    public function url_mappings()
    {
        return new UrlMappings([new DispatcherUrlMapping('/financial/index.php')]);
    }
}
?>