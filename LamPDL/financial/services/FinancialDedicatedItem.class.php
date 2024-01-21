<?php
/*
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 18
 * @since       PHPBoost 6.0 - 2024 01 18
 */
class FinancialDedicatedItem
{
    private $id;
    private $club_id;
    private $dedicated_object;
    private $dedicated_details;
    private $dedicated_budget;
    private $club_activity_location;
    private $club_activity_city;
    private $club_request_date;
    private $archived;
    private $archived_date;
    private $file_url;

    public function set_id($id)
    {
        $this->id = $id;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function set_club_id($club_id)
    {
        $this->club_id = $club_id;
    }

    public function get_club_id()
    {
        return $this->club_id;
    }

    public function set_dedicated_object($dedicated_object)
    {
        $this->dedicated_object = $dedicated_object;
    }

    public function get_dedicated_object()
    {
        return $this->dedicated_object;
    }

    public function set_dedicated_details($dedicated_details)
    {
        $this->dedicated_details = $dedicated_details;
    }

    public function get_dedicated_details()
    {
        return $this->dedicated_details;
    }

    public function set_dedicated_budget($dedicated_budget)
    {
        $this->dedicated_budget = $dedicated_budget;
    }

    public function get_dedicated_budget()
    {
        return $this->dedicated_budget;
    }

    public function set_dedicated_file_url(Url $file_url): void
    {
        $this->file_url = $file_url;
    }

    public function get_dedicated_file_url()
    {
        if (!$this->file_url instanceof Url) return new Url('');

        return $this->file_url;
    }

    public function set_club_ffam_number($club_ffam_number)
    {
        $this->club_ffam_number = $club_ffam_number;
    }

    public function get_club_ffam_number()
    {
        return $this->club_ffam_number;
    }

    public function set_club_name($club_name)
    {
        $this->club_name = $club_name;
    }

    public function get_club_name()
    {
        return $this->club_name;
    }

    public function set_club_dept($club_dept)
    {
        $this->club_dept = $club_dept;
    }

    public function get_club_dept()
    {
        return $this->club_dept;
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

    public function set_club_request_date(Date $club_request_date)
    {
        $this->club_request_date = $club_request_date;
    }

    public function get_club_request_date()
    {
        return $this->club_request_date;
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
            'id'                     => $this->get_id(),
            'club_id'                => $this->get_club_id(),
            'dedicated_object'       => $this->get_dedicated_object(),
            'dedicated_details'      => $this->get_dedicated_details(),
            'dedicated_budget'       => $this->get_dedicated_budget(),
            'dedicated_file_url'     => $this->get_dedicated_file_url()->relative(),
            'club_activity_location' => $this->get_club_activity_location(),
            'club_activity_city'     => $this->get_club_activity_city(),
            'club_request_date'      => $this->get_club_request_date() !== null ? $this->get_club_request_date()->get_timestamp() : 0,
            'archived'               => $this->get_archived(),
            'archived_date'          => $this->get_archived_date() !== null ? $this->get_archived_date()->get_timestamp() : 0,
        );
    }

    public function set_properties(array $properties)
    {
        $this->id = $properties['id'];
        $this->dedicated_object = $properties['dedicated_object'];
        $this->dedicated_details = $properties['dedicated_details'];
        $this->dedicated_budget = $properties['dedicated_budget'];
        $this->dedicated_file_url = new Url($properties['dedicated_file_url']);
        $this->club_name = $properties['club_name'];
        $this->club_ffam_number = $properties['club_ffam_number'];
        $this->club_dept = $properties['club_dept'];
        $this->club_activity_location = $properties['club_activity_location'];
        $this->club_activity_city = $properties['club_activity_city'];
        $this->club_request_date = !empty($properties['club_request_date']) ? new Date($properties['club_request_date'], Timezone::SERVER_TIMEZONE) : null;
        $this->archived = $properties['archived'];
        $this->archived_date = !empty($properties['archived_date']) ? new Date($properties['archived_date'], Timezone::SERVER_TIMEZONE) : null;
    }
}
?>
