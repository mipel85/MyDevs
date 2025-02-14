<?php
/**
 * @copyright   &copy; 2005-2025 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2025 02 14
 * @since       PHPBoost 6.0 - 2020 01 18
 */

class PlanningExtensionPointProvider extends ExtensionPointProvider
{
    public function home_page()
    {
        return new DefaultHomePageDisplay($this->get_id(), PlanningHomeController::get_view());
    }

    public function css_files()
    {
        $module_css_files = new ModuleCssFiles();
        $module_css_files->adding_always_displayed_file('planning.css');
        return $module_css_files;
    }

    public function search()
    {
        return new PlanningSearchable();
    }

    public function tree_links()
    {
        return new PlanningTreeLinks();
    }

    public function url_mappings()
    {
        return new UrlMappings([new DispatcherUrlMapping('/planning/index.php')]);
    }
}
?>
