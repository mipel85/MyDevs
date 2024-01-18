<?php
/*
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 18
 * @since       PHPBoost 6.0 - 2024 01 18
 */
class LamFinancialActivityItem
{
    private $id;
    private $activity_type;
    private $club_ffam_number;
    private $club_name;
    private $club_dept;
    private $club_activity_date;
    private $club_activity_location;
    private $club_activity_city;
    private $club_activity_description;
    private $club_request_date;
    private $amount_paid;
    private $archived;
    private $archived_date;
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

    public function set_activity_type($activity_type)
    {
        $this->activity_type = $activity_type;
    }

    public function get_activity_type()
    {
        return $this->activity_type;
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
    
    public function set_club_dept($club_dept)
    {
        $this->club_dept = $club_dept;
    }

    public function get_club_dept()
    {
        return $this->club_dept;
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

    public function set_club_request_date(Date $club_request_date)
    {
        $this->club_request_date = $club_request_date;
    }

    public function get_club_request_date()
    {
        return $this->club_request_date;
    }

    public function set_amount_paid($amount_paid)
    {
        $this->amount_paid = $amount_paid;
    }

    public function get_amount_paid()
    {
        return $this->amount_paid;
    }

    public function set_archived($archived)
    {
        $this->archived = $archived;
    }

    public function get_archived()
    {
        return $this->archived;
    }

    public function set_archived_date(Date $archived_date)
    {
        $this->archived_date = $archived_date;
    }

    public function get_archived_date()
    {
        return $this->archived_date;
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

    // properties

    public function get_properties()
    {
        return array(
            'id'                        => $this->get_id(),
            'activity_type'             => $this->get_activity_type(),
            'club_ffam_number'          => $this->get_club_ffam_number(),
            'club_name'                 => $this->get_club_name(),
            'club_dept'                 => $this->get_club_dept(),
            'club_activity_date'        => $this->get_club_activity_date() !== null ? $this->get_club_activity_date()->get_timestamp() : 0,
            'club_activity_location'    => $this->get_club_activity_location(),
            'club_activity_city'        => $this->get_club_activity_city(),
            'club_activity_description' => $this->get_club_activity_description(),
            'club_request_date'         => $this->get_club_request_date() !== null ? $this->get_club_request_date()->get_timestamp() : 0,
            'amount_paid'               => $this->get_amount_paid(),
            'archived'                  => $this->get_archived(),
            'archived_date'             => $this->get_archived_date() !== null ? $this->get_archived_date()->get_timestamp() : 0,
        );
    }

    public function set_properties(array $properties)
    {
        $this->id = $properties['id'];
        $this->activity_type = $properties['activity_type'];
        $this->club_ffam_number = $properties['club_ffam_number'];
        $this->club_name = $properties['club_name'];
        $this->club_dept = $properties['club_dept'];
        $this->club_activity_date = !empty($properties['club_activity_date']) ? new Date($properties['club_activity_date'], Timezone::SERVER_TIMEZONE) : null;
        $this->club_activity_location = $properties['club_activity_location'];
        $this->club_activity_city = $properties['club_activity_city'];
        $this->club_activity_description = $properties['club_activity_description'];
        $this->club_request_date = !empty($properties['club_request_date']) ? new Date($properties['club_request_date'], Timezone::SERVER_TIMEZONE) : null;
        $this->amount_paid = $properties['amount_paid'];
        $this->archived = $properties['archived'];
        $this->archived_date = !empty($properties['archived_date']) ? new Date($properties['archived_date'], Timezone::SERVER_TIMEZONE) : null;
    }
}
?>
