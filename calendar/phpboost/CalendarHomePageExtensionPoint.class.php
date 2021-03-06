<?php
/**
 * @copyright   &copy; 2005-2020 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Julien BRISWALTER <j1.seth@phpboost.com>
 * @version     PHPBoost 5.3 - last update: 2017 03 29
 * @since       PHPBoost 3.0 - 2012 02 07
*/

class CalendarHomePageExtensionPoint implements HomePageExtensionPoint
{
	 /**
	 * @method Get the module home page
	 */
	public function get_home_page()
	{
		return new DefaultHomePage($this->get_title(), CalendarDisplayCategoryController::get_view());
	}

	 /**
	 * @method Get the module title
	 */
	private function get_title()
	{
		return LangLoader::get_message('module_title', 'common', 'calendar');
	}
}
?>
