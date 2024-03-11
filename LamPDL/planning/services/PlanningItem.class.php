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
	private $lamclubs_id;
	private $id_category;
	private $activity_other;
	private $rewrited_link;
	private $start_date;
	private $end_date_enabled;
	private $end_date;
	private $author_user;
	private $email;
	private $more_infos;
	private $creation_date;
	private $update_date;

	private $cancelled;
	private $approved;

	private $phone;
	private $website_url;
	private $thumbnail_url;
	private $content;
	private $location;
	private $map_displayed;

	const THUMBNAIL_URL = '/templates/__default__/images/default_item.webp';

	public function set_id($id)
	{
		$this->id = $id;
	}

	public function get_id()
	{
		return $this->id;
	}

	public function set_lamclubs_id($lamclubs_id)
	{
		$this->lamclubs_id = $lamclubs_id;
	}

	public function get_lamclubs_id()
	{
		return $this->lamclubs_id;
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

	public function set_activity_other($activity_other)
	{
		$this->activity_other = $activity_other;
	}

	public function get_activity_other()
	{
		return $this->activity_other;
	}

	public function set_rewrited_link($rewrited_link)
	{
		$this->rewrited_link = $rewrited_link;
	}

	public function get_rewrited_link()
	{
		return $this->rewrited_link;
	}

	public function set_start_date(Date $start_date)
	{
		$this->start_date = $start_date;
	}

	public function get_start_date()
	{
		return $this->start_date;
	}

	public function set_end_date_enabled($end_date_enabled)
	{
		$this->end_date_enabled = $end_date_enabled;
	}

	public function get_end_date_enabled()
	{
		return $this->end_date_enabled;
	}

	public function set_end_date(Date $end_date)
	{
		$this->end_date = $end_date;
	}

	public function get_end_date()
	{
		return $this->end_date;
	}

	public function set_author_user(User $author)
	{
		$this->author_user = $author;
	}

	public function get_author_user()
	{
		return $this->author_user;
	}

	public function set_email($email)
	{
		$this->email = $email;
	}

	public function get_email()
	{
		return $this->email;
	}

	public function set_more_infos($more_infos)
	{
		$this->more_infos = $more_infos;
	}

	public function get_more_infos()
	{
		return $this->more_infos;
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

	public function set_phone($phone)
	{
		$this->phone = $phone;
	}

	public function get_phone()
	{
		return $this->phone;
	}

	public function get_website_url()
	{
		if (!$this->website_url instanceof Url)
			return new Url('');

		return $this->website_url;
	}

	public function set_website_url(Url $website_url)
	{
		$this->website_url = $website_url;
	}

	public function get_thumbnail()
	{
		if (!$this->thumbnail_url instanceof Url)
			return new Url($this->thumbnail_url == FormFieldThumbnail::DEFAULT_VALUE ? FormFieldThumbnail::get_default_thumbnail_url(self::THUMBNAIL_URL) : $this->thumbnail_url);

		return $this->thumbnail_url;
	}

	public function set_thumbnail($thumbnail)
	{
		$this->thumbnail_url = $thumbnail;
	}

	public function has_thumbnail()
	{
		$thumbnail = ($this->thumbnail_url instanceof Url) ? $this->thumbnail_url->rel() : $this->thumbnail_url;
		return !empty($thumbnail);
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
			'lamclubs_id' => $this->get_lamclubs_id(),
			'activity_other' => $this->get_activity_other(),
			'rewrited_link' => $this->get_rewrited_link(),
			'start_date' => ($this->get_start_date() !== null ? $this->get_start_date()->get_timestamp() : null),
			'end_date_enabled' => $this->get_end_date_enabled(),
			'end_date' => ($this->get_end_date_enabled() && $this->get_end_date() !== null ? $this->get_end_date()->get_timestamp() : null),
			'author_user_id' => $this->get_author_user()->get_id(),
			'email' => $this->get_email(),
			'more_infos' => $this->get_more_infos(),
			'creation_date' => $this->get_creation_date()->get_timestamp(),
			'update_date' => $this->get_update_date() !== null ? $this->get_update_date()->get_timestamp() : $this->get_creation_date()->get_timestamp(),
			'cancelled' => (int)$this->is_cancelled(),
			'approved' => (int)$this->is_approved(),
            'phone' => $this->get_phone(),
			'website_url' => $this->get_website_url()->absolute(),
            'thumbnail_url' => $this->get_thumbnail()->relative(),
			'content' => $this->get_content(),
			'location' => $this->get_location(),
			'map_displayed' => (int)$this->is_map_displayed()
		);
	}

	public function set_properties(array $properties)
	{
		$this->id = $properties['id'];
		$this->id_category = $properties['id_category'];
		$this->lamclubs_id = $properties['lamclubs_id'];
		$this->activity_other = $properties['activity_other'];
		$this->rewrited_link = $properties['rewrited_link'];
        $this->start_date = !empty($properties['start_date']) ? new Date($properties['start_date'], Timezone::SERVER_TIMEZONE) : null;
		$this->end_date_enabled = $properties['end_date_enabled'];
		$this->end_date = !empty($properties['end_date_enabled']) && !empty($properties['end_date']) ? new Date($properties['end_date'], Timezone::SERVER_TIMEZONE) : null;
		$this->email = $properties['email'];
		$this->more_infos = $properties['more_infos'];

		$this->creation_date = new Date($properties['creation_date'], Timezone::SERVER_TIMEZONE);
		$this->update_date = new Date($properties['update_date'], Timezone::SERVER_TIMEZONE);

		if ($properties['cancelled'])
			$this->cancel();
		else
			$this->uncancel();
		if ($properties['approved'])
			$this->approve();
		else
			$this->unapprove();

		$this->phone = $properties['phone'];
		$this->website_url = new Url($properties['website_url']);
        $this->thumbnail_url = new Url($properties['thumbnail_url']);
		$this->content = $properties['content'];
		$this->location = $properties['location'];
		if ($properties['map_displayed'])
			$this->display_map();
		else
			$this->hide_map();

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
        $club_id = LamclubsService::get_user_club(AppContext::get_current_user()->get_id());

        $this->lamclubs_id = $club_id;
        $this->website_url = new Url(LamclubsService::get_item($club_id)->get_website_url()->rel());
		$this->id_category = $id_category;
		$this->author_user = AppContext::get_current_user();
		$this->email = $user->get_email();
		$this->creation_date = new Date();
		$this->start_date = new Date($this->round_to_five_minutes($now->get_timestamp()), Timezone::SERVER_TIMEZONE);
		$this->end_date = new Date($this->round_to_five_minutes($now->get_timestamp() + 3600), Timezone::SERVER_TIMEZONE);

		$this->hide_map();

		if (CategoriesAuthorizationsService::check_authorizations()->write() || CategoriesAuthorizationsService::check_authorizations()->moderation())
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
		return PlanningUrlBuilder::display($category->get_id(), $category->get_rewrited_name(), $this->id, $this->rewrited_link)->rel();
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
			$map = new GoogleMapsDisplayMap($this->get_location(), 'location', $category->get_name());
			$location_map = $map->display();
			$has_location_map = $this->is_map_displayed();
		}

        $flyer = new File($this->get_thumbnail()->rel());

        $club = LamclubsService::get_item($this->lamclubs_id);

        $phone = $this->get_phone() ? $this->private_phone($this->get_phone(), 12, '/images/maths/', $club->get_name(), $club->get_ffam_nb()) : '';

		return array_merge(
			Date::get_array_tpl_vars($this->get_creation_date(), 'date'),
			Date::get_array_tpl_vars($this->get_update_date(), 'update_date'),
			Date::get_array_tpl_vars($this->start_date, 'start_date'),
			Date::get_array_tpl_vars($this->end_date, 'end_date'),
			array(
				'C_APPROVED'           => $this->is_approved(),
				'C_CONTROLS'           => $this->is_authorized_to_edit() || $this->is_authorized_to_delete(),
				'C_EDIT'               => $this->is_authorized_to_edit(),
				'C_DELETE'             => $this->is_authorized_to_delete(),
				'C_END_DATE'           => $this->get_end_date_enabled(),
				'C_CONTACT'            => $this->get_email() || $this->get_phone(),
				'C_CONTACT_EMAIL'      => $this->get_email(),
				'C_CONTACT_PHONE'      => $this->get_phone(),
				'C_LOCATION'           => !empty($location),
				'C_LOCATION_MAP'       => $has_location_map,
				'C_AUTHOR_GROUP_COLOR' => !empty($author_group_color),
				'C_AUTHOR_EXISTS'      => $author->get_id() !== User::VISITOR_LEVEL,
				'C_CANCELLED'          => $this->is_cancelled(),
				'C_NEW_CONTENT'        => ContentManagementConfig::load()->module_new_content_is_enabled_and_check_date('planning', $this->get_creation_date()->get_timestamp()),
				'C_HAS_UPDATE_DATE'    => $this->has_update_date(),
				'C_HAS_THUMBNAIL' 	   => $this->has_thumbnail(),
				'C_VISIT' 		       => $this->get_website_url(),
                'C_PDF'                => $flyer->get_extension() == 'pdf',

				//Category
				'C_ROOT_CATEGORY' => $category->get_id() == Category::ROOT_CATEGORY,
				'CATEGORY_ID'     => $category->get_id(),
				'CATEGORY_NAME'   => $category->get_name(),
				'U_EDIT_CATEGORY' => $category->get_id() == Category::ROOT_CATEGORY ? PlanningUrlBuilder::configuration()->rel() : CategoriesUrlBuilder::edit($category->get_id(), 'planning')->rel(),

				//Event
				'ID'           => $this->id,
				'TITLE'        => $category->get_id() == Category::ROOT_CATEGORY ? $this->get_activity_other() : $category->get_name(),
				'CLUB_NAME'    => $club->get_name(),
				'CLUB_DPT'     => $club->get_department(),
				'CLUB_ID'      => $club->get_club_id(),
				'PHONE'        => $phone,
				'CONTENT'      => $rich_content,
				'LOCATION'     => $location,
				'LOCATION_MAP' => $location_map,

				'U_SYNDICATION'    => SyndicationUrlBuilder::rss('planning', $category->get_id())->rel(),
				'U_AUTHOR_PROFILE' => UserUrlBuilder::profile($author->get_id())->rel(),
				'U_AUTHOR_CONTRIB' => PlanningUrlBuilder::display_member_items($author->get_id())->rel(),
				'U_ITEM'           => $this->get_item_url(),
				'U_THUMBNAIL'      => $this->get_thumbnail()->rel(),
				'U_VISIT'          => PlanningUrlBuilder::visit_item($this->id)->rel(),
				'U_EDIT'           => PlanningUrlBuilder::edit_item($this->id)->rel(),
				'U_DELETE'         => PlanningUrlBuilder::delete_item($this->id)->rel()
			)
		);
	}

    function private_phone($text, $size, $pathtoimg, $alt = '', $prefix = '')
    {
        require_once PATH_TO_ROOT . '/kernel/lib/php/mathpublisher/mathpublisher.php';
        /*
    Creates the formula image (if the image is not in the cache) and returns the <img src=...></img> html code.
    */
        $prefix_img = !empty($prefix) ? $prefix . '-' : '';
        $nameimg = md5(trim($prefix_img . $text) . $size) . '.png';
        $v = detectimg($nameimg);
        if ($v == 0) {
            //the image doesn't exist in the cache directory. we create it.
            $formula = new expression_math(tableau_expression(trim($text)));
            $formula->dessine($size);
            $v = 1000 - imagesy($formula->image) + $formula->base_verticale + 3;
            //1000+baseline ($v) is recorded in the name of the image
            ImagePNG($formula->image, PHP_MATH_PUBLISHER_CACHE_DIR . "/" . $prefix_img . "phone_" . $v . "_" . $nameimg);
        }
        $valign = $v - 1000;
        $alt_img = !empty($alt) ? $alt : $text;
        return '<img src="' . Url::to_rel($pathtoimg . $prefix_img . "phone_" . $v . "_" . $nameimg) . '" style="vertical-align:' . $valign . 'px;' . ' display: inline-block ;" alt="' . $alt_img . '" />';
    }
}
?>
