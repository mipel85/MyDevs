<?php
/**
 * @copyright   &copy; 2005-2022 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2022 11 18
 * @since       PHPBoost 6.0 - 2022 11 18
 */

class DocumentationItemContent
{
	private $content_id;
	private $item_id;
	private $content;
	private $active_content;
	private $change_reason;

	private $update_date;

	private $author_user;

	const THUMBNAIL_URL = '/templates/__default__/images/default_item.webp';

	const ASC  = 'ASC';
	const DESC = 'DESC';

	const NOT_PUBLISHED        = 0;
	const PUBLISHED            = 1;
	const DEFERRED_PUBLICATION = 2;

	public function get_content_id()
	{
		return $this->content_id;
	}

	public function set_content_id($content_id)
	{
		$this->content_id = $content_id;
	}

	public function get_item_id()
	{
		return $this->item_id;
	}

	public function set_item_id($item_id)
	{
		$this->item_id = $item_id;
	}

	public function get_content()
	{
		return $this->content;
	}

	public function set_content($content)
	{
		$this->content = $content;
	}

	public function get_active_content()
	{
		return $this->active_content;
	}

	public function set_active_content($active_content)
	{
		$this->active_content = $active_content;
	}

	public function get_change_reason()
	{
		return $this->change_reason;
	}

	public function set_change_reason($change_reason)
	{
		$this->change_reason = $change_reason;
	}

	public function get_update_date()
	{
		return $this->update_date;
	}
    
	public function set_update_date(Date $update_date)
	{
		$this->update_date = $update_date;
	}

	public function get_author_user()
	{
		return $this->author_user;
	}

	public function set_author_user(User $user)
	{
		$this->author_user = $user;
	}

	public function get_author_custom_name()
	{
		return $this->author_custom_name;
	}

	public function set_author_custom_name($author_custom_name)
	{
		$this->author_custom_name = $author_custom_name;
	}

	public function is_author_custom_name_enabled()
	{
		return $this->author_custom_name_enabled;
	}

	public function is_authorized_to_manage_history()
	{
		// return DocumentationAuthorizationsService::check_authorizations($this->id_category)->moderation() || ((DocumentationAuthorizationsService::check_authorizations($this->id_category)->write() || (DocumentationAuthorizationsService::check_authorizations($this->id_category)->contribution() && !DocumentationItem::is_published())) && $this->get_author_user()->get_id() == AppContext::get_current_user()->get_id() && AppContext::get_current_user()->check_level(User::MEMBER_LEVEL));
	}

	public function get_properties()
	{
		return array(
			'content_id' => $this->get_content_id(),
			'item_id' => $this->get_item_id(),
			'content' => $this->get_content(),
			'active_content' => $this->get_active_content(),
			'change_reason' => $this->get_change_reason(),
			'update_date' => $this->get_update_date()->get_timestamp(),
			'author_user_id' => $this->get_author_user()->get_id()
		);
	}

	public function set_properties(array $properties)
	{
		$this->content_id = $properties['content_id'];
		$this->item_id = $properties['item_id'];
		$this->content = $properties['content'];
		$this->active_content = $properties['active_content'];
		$this->change_reason = $properties['change_reason'];
		$this->update_date = new Date($properties['update_date'], Timezone::SERVER_TIMEZONE);
		
		$user = new User();
		if (!empty($properties['user_id']))
			$user->set_properties($properties);
		else
			$user->init_visitor_user();

		$this->set_author_user($user);
	}

	public function init_default_properties()
	{
        $this->content = DocumentationConfig::load()->get_default_content();
		$this->active_content = true;
		$this->author_user = AppContext::get_current_user();
		$this->update_date = new Date();
	}
}
?>
