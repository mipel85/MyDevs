<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 18
 * @since       PHPBoost 6.0 - 2024 01 18
*/

class LamclubsExtensionPointProvider extends ItemsModuleExtensionPointProvider
{
	public function __construct()
	{
		parent::__construct('lamclubs');
	}

	public function home_page()
	{
		return new DefaultHomePageDisplay($this->get_id(), LamclubsHomeController::get_view());
	}
}
?>
