<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 18
 * @since       PHPBoost 6.0 - 2024 01 18
*/

class LamClubsItem
{
	private $id;
	private $name;
	private $ffam_nb;
	private $department;
	private $published;

	const NOT_PUBLISHED = 0;
	const PUBLISHED = 1;

	public function get_id()
	{
		return $this->id;
	}

	public function set_id($id)
	{
		$this->id = $id;
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

	public function get_published()
	{
		return $this->published;
	}

	public function set_published($published)
	{
		$this->published = $published;
	}

	public function is_published()
	{
		return LamClubsAuthorizationsService::check_authorizations()->read() && ($this->get_published() == self::PUBLISHED );
	}

	public function get_status()
	{
		switch ($this->published) {
			case self::PUBLISHED:
				return LangLoader::get_message('common.status.approved', 'common-lang');
			break;
			case self::NOT_PUBLISHED:
				return LangLoader::get_message('common.status.draft', 'common-lang');
			break;
		}
	}

	public function is_authorized_to_add()
	{
		return LamClubsAuthorizationsService::check_authorizations()->write();
	}

	public function is_authorized_to_edit()
	{
		return LamClubsAuthorizationsService::check_authorizations()->moderation() || LamClubsAuthorizationsService::check_authorizations()->write();
	}

	public function is_authorized_to_delete()
	{
		return LamClubsAuthorizationsService::check_authorizations()->moderation() || LamClubsAuthorizationsService::check_authorizations()->write();
	}

	public function get_properties()
	{
		return array(
			'id'         => $this->get_id(),
			'name'       => $this->get_name(),
			'ffam_nb'    => $this->get_ffam_nb(),
			'department' => $this->get_department(),
			'published'  => $this->get_published()
		);
	}

	public function set_properties(array $properties)
	{
		$this->id           = $properties['id'];
		$this->name         = $properties['name'];
		$this->ffam_nb      = $properties['ffam_nb'];
		$this->department   = $properties['department'];
		$this->published    = $properties['published'];
	}

	public function init_default_properties()
	{
		$this->published = self::PUBLISHED;
	}

	public function get_item_url()
	{
		return LamClubsUrlBuilder::home()->rel();
	}
}
?>
