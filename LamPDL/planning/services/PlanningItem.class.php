<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class PlanningItem
{
	private $id;
	private $id_category;
	private $club_id;
	private $title;
	private $rewrited_title;
	private $content;

	private $location;
	private $map_displayed;

	private $cancelled;
	private $approved;

	private $start_date;
	private $end_date;
	private $creation_date;
	private $update_date;
	private $author_user;
	private $email;

	public function set_id($id)
	{
		$this->id = $id;
	}

	public function get_id()
	{
		return $this->id;
	}

	public function set_id_category($id_category)
	{
		$this->id_category = $id_category;
	}

	public function get_id_category()
	{
		return $this->id_category;
	}

	public function get_category()
	{
		return CategoriesService::get_categories_manager('planning')->get_categories_cache()->get_category($this->id_category);
	}

	public function set_club_id($club_id)
	{
		$this->club_id = $club_id;
	}

	public function get_club_id()
	{
		return $this->club_id;
	}

	public function set_email($email)
	{
		$this->email = $email;
	}

	public function get_email()
	{
		return $this->email;
	}

	public function set_title($title)
	{
		$this->title = $title;
	}

	public function get_title()
	{
		return $this->title;
	}

	public function set_rewrited_title($rewrited_title)
	{
		$this->rewrited_title = $rewrited_title;
	}

	public function get_rewrited_title()
	{
		return $this->rewrited_title;
	}

	public function set_content($content)
	{
		$this->content = $content;
	}

	public function get_content()
	{
		return $this->content;
	}

	public function set_location($location)
	{
		$this->location = $location;
	}

	public function get_location()
	{
		return $this->location;
	}

	public function display_map()
	{
		$this->map_displayed = true;
	}

	public function hide_map()
	{
		$this->map_displayed = false;
	}

	public function is_map_displayed()
	{
		return $this->map_displayed;
	}

	public function approve()
	{
		$this->approved = true;
	}

	public function unapprove()
	{
		$this->approved = false;
	}

	public function is_approved()
	{
		return $this->approved;
	}

	public function set_creation_date(Date $creation_date)
	{
		$this->creation_date = $creation_date;
	}

	public function get_creation_date()
	{
		return $this->creation_date;
	}

	public function set_update_date(Date $update_date)
	{
		$this->update_date = $update_date;
	}

	public function get_update_date()
	{
		return $this->update_date;
	}

	public function has_update_date()
	{
		return $this->update_date !== null && $this->update_date > $this->creation_date;
	}

	public function set_author_user(User $author)
	{
		$this->author_user = $author;
	}

	public function get_author_user()
	{
		return $this->author_user;
	}

	public function cancel()
	{
		$this->cancelled = true;
	}

	public function uncancel()
	{
		$this->cancelled = false;
	}

	public function is_cancelled()
	{
		return $this->cancelled;
	}

	public function set_start_date(Date $start_date)
	{
		$this->start_date = $start_date;
	}

	public function get_start_date()
	{
		return $this->start_date;
	}

	public function set_end_date(Date $end_date)
	{
		$this->end_date = $end_date;
	}

	public function get_end_date()
	{
		return $this->end_date;
	}

	public function is_authorized_to_add()
	{
		return CategoriesAuthorizationsService::check_authorizations($this->id_category)->write() || CategoriesAuthorizationsService::check_authorizations($this->id_category)->contribution();
	}

	public function is_authorized_to_edit()
	{
		return CategoriesAuthorizationsService::check_authorizations($this->id_category)->moderation() || ((CategoriesAuthorizationsService::check_authorizations($this->id_category)->write() || (CategoriesAuthorizationsService::check_authorizations($this->id_category)->contribution())) && $this->get_author_user()->get_id() == AppContext::get_current_user()->get_id() && AppContext::get_current_user()->check_level(User::MEMBER_LEVEL));
	}

	public function is_authorized_to_delete()
	{
		return CategoriesAuthorizationsService::check_authorizations($this->id_category)->moderation() || ((CategoriesAuthorizationsService::check_authorizations($this->id_category)->write() || (CategoriesAuthorizationsService::check_authorizations($this->id_category)->contribution() && !$this->is_approved())) && $this->get_author_user()->get_id() == AppContext::get_current_user()->get_id() && AppContext::get_current_user()->check_level(User::MEMBER_LEVEL));
	}

	public function get_properties()
	{
		return array(
			'id' => $this->get_id(),
			'id_category' => $this->get_id_category(),
			'club_id' => $this->get_club_id(),
			'title' => $this->get_title(),
			'rewrited_title' => $this->get_rewrited_title(),
			'start_date' => ($this->get_start_date() !== null ? $this->get_start_date()->get_timestamp() : ''),
			'end_date' => ($this->get_end_date() !== null ? $this->get_end_date()->get_timestamp() : ''),
			'content' => $this->get_content(),
			'location' => $this->get_location(),
			'cancelled' => (int)$this->is_cancelled(),
			'approved' => (int)$this->is_approved(),
			'map_displayed' => (int)$this->is_map_displayed(),
			'creation_date' => $this->get_creation_date()->get_timestamp(),
			'update_date' => $this->get_update_date() !== null ? $this->get_update_date()->get_timestamp() : $this->get_creation_date()->get_timestamp(),
			'author_user_id' => $this->get_author_user()->get_id(),
			'email' => $this->get_email()
		);
	}

	public function set_properties(array $properties)
	{
		$this->id = $properties['id'];
		$this->id_category = $properties['id_category'];
		$this->club_id = $properties['club_id'];
		$this->title = $properties['title'];
		$this->rewrited_title = $properties['rewrited_title'];
		$this->email = $properties['email'];
		$this->content = $properties['content'];
		$this->location = $properties['location'];
        $this->start_date = !empty($properties['start_date']) ? new Date($properties['start_date'], Timezone::SERVER_TIMEZONE) : null;
		$this->end_date = !empty($properties['end_date']) ? new Date($properties['end_date'], Timezone::SERVER_TIMEZONE) : null;


		if ($properties['map_displayed'])
			$this->display_map();
		else
			$this->hide_map();

		if ($properties['approved'])
			$this->approve();
		else
			$this->unapprove();

		if ($properties['cancelled'])
			$this->cancel();
		else
			$this->uncancel();

		$this->creation_date = new Date($properties['creation_date'], Timezone::SERVER_TIMEZONE);
		$this->update_date = new Date($properties['update_date'], Timezone::SERVER_TIMEZONE);

		$user = new User();
		if (!empty($properties['user_id']))
			$user->set_properties($properties);
		else
			$user->init_visitor_user();

		$this->set_author_user($user);
	}

	public function init_default_properties($id_category = Category::ROOT_CATEGORY)
	{
        $user = AppContext::get_current_user();
        $now = new Date();
        $this->club_id = '';
		$this->id_category = $id_category;
		$this->author_user = $user;
		$this->email = $user->get_email();
		$this->creation_date = new Date();
		$this->start_date = new Date($this->round_to_five_minutes($now->get_timestamp()), Timezone::SERVER_TIMEZONE);
		$this->end_date = new Date($this->round_to_five_minutes($now->get_timestamp() + 3600), Timezone::SERVER_TIMEZONE);

		$this->hide_map();

		if (CategoriesAuthorizationsService::check_authorizations()->write())
			$this->approve();
		else
			$this->unapprove();

		$this->cancelled = false;
	}

	private function round_to_five_minutes($timestamp)
	{
		if (($timestamp % 300) < 150)
			return $timestamp - ($timestamp % 300);
		else
			return $timestamp - ($timestamp % 300) + 300;
	}

	public function get_item_url()
	{
		$category = $this->get_category();
		return PlanningUrlBuilder::display($category->get_id(), $category->get_rewrited_name(), $this->id, $this->rewrited_title)->rel();
	}

	public function get_template_vars()
	{
		$category = $this->get_category();
		$content = FormatingHelper::second_parse($this->get_content());
		$rich_content = HooksService::execute_hook_display_action('planning', $content, $this->get_properties());
		$author = $this->get_author_user();
		$author_group_color = User::get_group_color($author->get_groups(), $author->get_level(), true);

		$location_value = TextHelper::deserialize($this->get_location());

		$location = '';
		if (is_array($location_value) && isset($location_value['address']))
			$location = $location_value['address'];
		else if (!is_array($location_value))
			$location = $location_value;

		$location_map = '';
		$has_location_map = false;
		if (PlanningConfig::load()->is_googlemaps_available())
		{
			$map = new GoogleMapsDisplayMap($this->get_location(), 'location', $this->get_title());
			$location_map = $map->display();
			$has_location_map = $this->is_map_displayed();
		}

		$start_date = $this->get_start_date()->format(Date::FORMAT_DAY_MONTH_YEAR);
		$end_date = $this->get_end_date()->format(Date::FORMAT_DAY_MONTH_YEAR);

		return array_merge(
			Date::get_array_tpl_vars($this->get_creation_date(), 'date'),
			Date::get_array_tpl_vars($this->get_update_date(), 'update_date'),
			Date::get_array_tpl_vars($this->start_date, 'start_date'),
			Date::get_array_tpl_vars($this->end_date, 'end_date'),
			array(
				'C_APPROVED'                 => $this->is_approved(),
				'C_CONTROLS'                 => $this->is_authorized_to_edit() || $this->is_authorized_to_delete(),
				'C_EDIT'                     => $this->is_authorized_to_edit(),
				'C_DELETE'                   => $this->is_authorized_to_delete(),
				'C_DIFFERENT_DATE'           => $start_date != $end_date,
				'C_LOCATION'                 => !empty($location),
				'C_LOCATION_MAP'             => $has_location_map,
				'C_AUTHOR_GROUP_COLOR'       => !empty($author_group_color),
				'C_AUTHOR_EXISTS'             => $author->get_id() !== User::VISITOR_LEVEL,
				'C_CANCELLED'                => $this->is_cancelled(),
				'C_NEW_CONTENT'              => ContentManagementConfig::load()->module_new_content_is_enabled_and_check_date('planning', $this->get_creation_date()->get_timestamp()),
				'C_HAS_UPDATE_DATE' 		 => $this->has_update_date(),

				//Category
				'C_ROOT_CATEGORY' => $category->get_id()   == Category::ROOT_CATEGORY,
				'CATEGORY_ID'     => $category->get_id(),
				'CATEGORY_NAME'   => $category->get_name(),
				'U_EDIT_CATEGORY' => $category->get_id()   == Category::ROOT_CATEGORY ? PlanningUrlBuilder::configuration()->rel() : CategoriesUrlBuilder::edit($category->get_id(), 'planning')->rel(),
				'U_CATEGORY'      => $category->get_id() != Category::ROOT_CATEGORY ? PlanningUrlBuilder::display_category($category->get_id(), $category->get_rewrited_name(), $this->get_start_date()->get_year(), $this->get_start_date()->get_month())->rel() : '',

				//Event
				'ID'                       => $this->id,
				'TITLE'                    => $this->get_title(),
				'CONTENT'                  => $rich_content,
				'LOCATION'                 => $location,
				'LOCATION_MAP'             => $location_map,
				'AUTHOR'                   => $author->get_display_name(),
				'AUTHOR_LEVEL_CLASS'       => UserService::get_level_class($author->get_level()),
				'AUTHOR_GROUP_COLOR'       => $author_group_color,

				'U_SYNDICATION'    => SyndicationUrlBuilder::rss('planning', $category->get_id())->rel(),
				'U_AUTHOR_PROFILE' => UserUrlBuilder::profile($author->get_id())->rel(),
				'U_AUTHOR_CONTRIB' => PlanningUrlBuilder::display_member_items($author->get_id())->rel(),
				'U_ITEM'           => $this->get_item_url(),
				'U_EDIT'           => PlanningUrlBuilder::edit_item($this->id)->rel(),
				'U_DELETE'         => PlanningUrlBuilder::delete_item($this->id)->rel()
			)
		);
	}
}
?>
