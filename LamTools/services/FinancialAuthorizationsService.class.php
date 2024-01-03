<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2023 04 04
 * @since       PHPBoost 6.0 - 2023 04 04
*/

class FinancialAuthorizationsService
{
	const REQUESTS_AUTHORIZATIONS = 1;
	const MANAGE_AUTHORIZATIONS = 2;

	public static function check_authorizations()
	{
		$instance = new self();
		return $instance;
	}

	public function officer()
	{
		return $this->get_authorizations(self::REQUESTS_AUTHORIZATIONS);
	}

	public function manager()
	{
		return $this->get_authorizations(self::MANAGE_AUTHORIZATIONS);
	}

	private function get_authorizations($bit)
	{
		return AppContext::get_current_user()->check_auth(LamToolsConfig::load()->get_authorizations(), $bit);
	}
}
?>
