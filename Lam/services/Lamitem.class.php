<?php
/*
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2022 12 27
 * @since       PHPBoost 6.0 - 2022 12 20
 */
class LamItem
{
    private $id;
    private $form_name;
    private $form_date;
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

    public function set_form_date($form_date)
    {
        $this->form_date = $form_date;
    }

    public function get_form_date()
    {
        return $this->form_date;
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
            'form_date'                 => $this->get_form_date() !== null ? $this->get_form_date()->get_timestamp() : 0,
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
        $this->id = $properties['id'];
        $this->form_date = $properties['form_date'];
        $this->form_name = $properties['form_name'];
        $this->club_name = $properties['club_name'];
        $this->club_ffam_number = $properties['club_ffam_number'];
        $this->club_activity_date = !empty($properties['club_activity_date']) ? new Date($properties['club_activity_date'], Timezone::SERVER_TIMEZONE) : null;
        $this->club_activity_location = $properties['club_activity_location'];
        $this->club_activity_city = $properties['club_activity_city'];
        $this->club_activity_description = $properties['club_activity_description'];
    }
}
?>
