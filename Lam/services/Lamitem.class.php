<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel85@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2022 12 27
 * @since       PHPBoost 6.0 - 2022 12 20
 */
class LamItem
{
    private $id;
    private $form_name;
    private $club_name;
    private $club_ffam_number;
    private $club_activity_date;
    private $club_activity_location;
    private $club_activity_city;
    private $club_activity_description;
    private $club_sender_name;
    private $club_sender_mail;

    public function set_id($id)
    {
        $this->id = $id;
    }

    public function get_id()
    {
        return $this->id;
    }
    
    public function set_form_name($form_name)
    {
        $this->form_name = $form_name;
    }

    public function get_form_name()
    {
        return $this->form_name;
    }

    public function set_club_name($club_name)
    {
        $this->club_name = $club_name;
    }

    public function get_club_name()
    {
        return $this->club_name;
    }

    public function set_club_ffam_number($club_ffam_number)
    {
        $this->club_ffam_number = $club_ffam_number;
    }

    public function get_club_ffam_number()
    {
        return $this->club_ffam_number;
    }

    public function set_club_activity_date(Date $club_activity_date)
    {
        $this->club_activity_date = $club_activity_date;
    }

    public function get_club_activity_date()
    {
        return $this->club_activity_date;
    }

    public function set_club_activity_location($club_activity_location)
    {
        return $this->club_activity_location = $club_activity_location;
    }

    public function get_club_activity_location()
    {
        return $this->club_activity_location;
    }
    
    public function set_club_activity_city($club_activity_city)
    {
        return $this->club_activity_city = $club_activity_city;
    }

    public function get_club_activity_city()
    {
        return $this->club_activity_city;
    }

    public function set_club_activity_description($club_activity_description)
    {
        return $this->club_activity_description = $club_activity_description;
    }

    public function get_club_activity_description()
    {
        return $this->club_activity_description;
    }
    
    public function set_club_sender_name($club_sender_name)
    {
        return $this->club_sender_name = $club_sender_name;
    }
    
    public function get_club_sender_name()
    {
        return $this->club_sender_name;
    }

    public function set_club_sender_mail($club_sender_mail)
    {
        return $this->club_sender_mail = $club_sender_mail;
    }
    
    public function get_club_sender_mail()
    {
        return $this->club_sender_mail;
    }

    public function get_properties()
    {
        return array(
            'id'                        => $this->get_id(),
            'form_name'                 => $this->get_form_name(),
            'club_name'                 => $this->get_club_name(),
            'club_ffam_number'          => $this->get_club_ffam_number(),
            'club_activity_date'        => $this->get_club_activity_date() !== null ? $this->get_club_activity_date()->get_timestamp() : 0,
            'club_activity_location'    => $this->get_club_activity_location(),
            'club_activity_city'        => $this->get_club_activity_city(),
            'club_activity_description' => $this->get_club_activity_description(),
        );
    }

    public function set_properties(array $properties)
    {
        $this->set_id = $properties['id'];
        $this->set_form_name = $properties['form_name'];
        $this->set_club_name = $properties['club_name'];
        $this->set_club_ffam_number = $properties['club_ffam_number'];
        $this->set_club_activity_date = !empty($properties['club_activity_date']) ? new Date($properties['club_activity_date'], Timezone::SERVER_TIMEZONE) : null;
        $this->set_club_activity_location = $properties['club_activity_location'];
        $this->set_club_activity_city = $properties['club_activity_city'];
        $this->set_club_activity_description = $properties['club_activity_description'];
    }
    
    
//	public function init_default_properties($id_category = Category::ROOT_CATEGORY)
//	{
//		if(SmalladsConfig::load()->is_max_weeks_number_displayed())
//			$max_weeks_config_number = SmalladsConfig::load()->get_max_weeks_number();
//		else
//			$max_weeks_config_number = null;
//
//		$this->id_category = $id_category;
//        $this->content = SmalladsConfig::load()->get_default_content();
//		$this->completed = self::NOT_COMPLETED;
//		$this->archived = self::NOT_ARCHIVED;
//		$this->displayed_author_name = self::DISPLAYED_AUTHOR_NAME;
//		$this->author_user = AppContext::get_current_user();
//		$this->published = self::PUBLISHED_NOW;
//		$this->publishing_start_date = new Date();
//		$this->publishing_end_date = new Date();
//		$this->creation_date = new Date();
//		$this->sources = array();
//		$this->carousel = array();
//		$this->thumbnail_url = FormFieldThumbnail::DEFAULT_VALUE;
//		$this->views_number = 0;
//		$this->price = 0;
//		$this->max_weeks = $max_weeks_config_number;
//		$this->custom_author_email = $this->author_user->get_email();
//		$this->custom_author_name = $this->author_user->get_display_name();
//		$this->enabled_author_email_customization = false;
//		$this->enabled_author_name_customization = false;
//		$this->displayed_author_pm = true;
//	}

}
?>