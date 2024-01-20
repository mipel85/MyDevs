<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2024 01 18
*/

class LamclubsAuthorizationsService
{
	const READ_AUTHORIZATIONS = 1;
	const WRITE_AUTHORIZATIONS = 2;
	const MODERATION_AUTHORIZATIONS = 4;

	public static function check_authorizations()
	{
		$instance = new self();
		return $instance;
	}

	public function read()
	{
		return $this->is_authorized(self::READ_AUTHORIZATIONS);
	}

	public function write()
	{
		return $this->is_authorized(self::WRITE_AUTHORIZATIONS);
	}

	public function moderation()
	{
		return $this->is_authorized(self::MODERATION_AUTHORIZATIONS);
	}

	private function is_authorized($bit)
	{
		return AppContext::get_current_user()->check_auth(LamclubsConfig::load()->get_authorizations(), $bit);
	}
}
?>
