<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2024 01 18
*/

class LamclubsItem
{
	private $club_id;
	private $name;
	private $ffam_nb;
	private $department;

	public function get_club_id()
	{
		return $this->club_id;
	}

	public function set_club_id($club_id)
	{
		$this->club_id = $club_id;
	}

	public function get_name()
	{
		return $this->name;
	}

	public function set_name($name)
	{
		$this->name = $name;
	}

	public function get_ffam_nb()
	{
		return $this->ffam_nb;
	}

	public function set_ffam_nb($ffam_nb)
	{
		$this->ffam_nb = $ffam_nb;
	}

	public function get_department()
	{
		return $this->department;
	}

	public function set_department($department)
	{
		$this->department = $department;
	}

	public function is_authorized_to_add()
	{
		return LamclubsAuthorizationsService::check_authorizations()->write();
	}

	public function is_authorized_to_edit()
	{
		return LamclubsAuthorizationsService::check_authorizations()->moderation() || LamclubsAuthorizationsService::check_authorizations()->write();
	}

	public function is_authorized_to_delete()
	{
		return LamclubsAuthorizationsService::check_authorizations()->moderation() || LamclubsAuthorizationsService::check_authorizations()->write();
	}

	public function get_properties()
	{
		return array(
			'club_id'         => $this->get_club_id(),
			'name'       => $this->get_name(),
			'ffam_nb'    => $this->get_ffam_nb(),
			'department' => $this->get_department()
		);
	}

	public function set_properties(array $properties)
	{
		$this->club_id           = $properties['club_id'];
		$this->name         = $properties['name'];
		$this->ffam_nb      = $properties['ffam_nb'];
		$this->department   = $properties['department'];
	}

	public function get_item_url()
	{
		return LamclubsUrlBuilder::home()->rel();
	}
}
?>
