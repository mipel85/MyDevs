<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 18
 * @since       PHPBoost 6.0 - 2024 01 18
 */
class FinancialExtensionPointProvider extends ExtensionPointProvider
{

    public function home_page()
    {
        return new DefaultHomePageDisplay($this->get_id(), FinancialHomeController::get_view());
    }

    public function css_files()
    {
        $module_css_files = new ModuleCssFiles();
        $module_css_files->adding_running_module_displayed_file('financial.css');
        return $module_css_files;
    }

    public function tree_links()
    {
        return new FinancialTreeLinks('financial');
    }

    public function url_mappings()
    {
        return new UrlMappings(array(new DispatcherUrlMapping('/financial/index.php')));
    }
}
?>
