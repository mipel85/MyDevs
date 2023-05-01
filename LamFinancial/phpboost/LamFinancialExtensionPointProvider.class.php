<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2023 03 03
 * @since       PHPBoost 6.0 - 2022 12 20
 */
class LamFinancialExtensionPointProvider extends ExtensionPointProvider
{

    public function home_page()
    {
        return new DefaultHomePageDisplay($this->get_id(), LamFinancialHomeController::get_view());
    }

    public function css_files()
    {
        $module_css_files = new ModuleCssFiles();
        $module_css_files->adding_running_module_displayed_file('/LamFinancial/templates/DataTables/css/buttons.dataTables.css');
        $module_css_files->adding_running_module_displayed_file('/LamFinancial/templates/DataTables/css/jquery.dataTables.css');
        $module_css_files->adding_running_module_displayed_file('lamFinancial.css');
        return $module_css_files;
    }

    public function tree_links()
    {
        return new LamFinancialTreeLinks('LamFinancial');
    }

    public function url_mappings()
    {
        return new UrlMappings(array(new DispatcherUrlMapping('/LamFinancial/index.php')));
    }
}
?>
