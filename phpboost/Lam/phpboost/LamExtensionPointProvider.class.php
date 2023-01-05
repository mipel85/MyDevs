<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2022 12 27
 * @since       PHPBoost 6.0 - 2022 12 20
*/

class LamExtensionPointProvider extends ItemsModuleExtensionPointProvider
{
	public function home_page()
	{
		return new DefaultHomePageDisplay($this->get_id(), LamHomeController::get_view());
	}
	
	public function css_files()
        {
        	$module_css_files = new ModuleCssFiles();
        	$module_css_files->adding_running_module_displayed_file('Lam.css');
        	return $module_css_files;
        }
}
?>
