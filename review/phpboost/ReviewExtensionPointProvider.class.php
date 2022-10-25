<?php
/**
 * @copyright   &copy; 2022 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel <mipel@gmail.com>
 * @version     PHPBoost 6.0 - last update: 2022 01 05
 * @since       PHPBoost 6.0 - 2022 01 10
 */
class ReviewExtensionPointProvider extends ExtensionPointProvider
{
    public function __construct()
    {
        parent::__construct('review');
    }

    public function css_files()
    {
        $module_css_files = new ModuleCssFiles();
        $module_css_files->adding_running_module_displayed_file('/review/templates/DataTables/css/buttons.dataTables.css');
        $module_css_files->adding_running_module_displayed_file('/review/templates/DataTables/css/jquery.dataTables.css');
        $module_css_files->adding_running_module_displayed_file('review.css');
        return $module_css_files;
    }

    public function url_mappings()
    {
        return new UrlMappings(array(new DispatcherUrlMapping('/review/index.php')));
    }
}
?>
