<?php

/*
 * Class of the events
*/

error_reporting(E_ALL);
ini_set('display_errors', true);

class Players {
    private $id;
    private $day_id;
    private $round_id;
    private $match_id;
    private $member_id;
    private $member_name;
    private $points_for;
    private $points_against;

    public function __construct($id = null)
    {
        if (!is_null($id)){
            $req = 'SELECT * FROM rankings WHERE id = ' . $id;
            if ($result = Connection::query($req)){
                $result = $result[0];
                $this->set_id($result['id']);
                $this->set_day_id($result['day_id']);
                $this->set_round_id($result['round_id']);
                $this->set_match_id($result['match_id']);
                $this->set_member_id($result['member_id']);
                $this->set_member_name($result['member_name']);
                $this->set_points_for($result['points_for']);
                $this->set_points_against($result['points_against']);
            }
        }
    }

// start getters setters
    public function get_id() { return $this->id; }
    public function set_id($id) { $this->id = $id; }

    public function get_day_id() { return $this->day_id; }
    public function set_day_id($day_id) { $this->day_id = $day_id; }

    public function get_round_id() { return $this->round_id; }
    public function set_round_id($round_id) { $this->round_id = $round_id; }

    public function get_match_id() { return $this->match_id; }
    public function set_match_id($match_id) { $this->match_id = $match_id; }

    public function get_member_id() { return $this->member_id; }
    public function set_member_id($member_id) { $this->member_id = $member_id; }

    public function get_member_name() { return $this->member_name; }
    public function set_member_name($member_name) { $this->member_name = $member_name; }

    public function get_points_for() { return $this->points_for; }
    public function set_points_for($points_for) { $this->points_for = $points_for; }

    public function get_points_against() { return $this->points_against; }
    public function set_points_against($points_against) { $this->points_against = $points_against; }
// end getters setters

    function add_player()
    {
        $req = 'INSERT INTO players values (
                    NULL,
                    "' . $this->get_day_id() . '",
                    "' . $this->get_round_id() . '",
                    "' . $this->get_match_id() . '",
                    "' . $this->get_member_id() . '",
                    "' . $this->get_member_name() . '",
                    "' . $this->get_points_for() . '",
                    "' . $this->get_points_against() . '",
                )';
        return Connection::query($req);
    }

    function remove_day_players($day_id)
    {
        $req = 'DELETE FROM players WHERE day_id = "' . $day_id . '"';
        return Connection::query($req);
    }

    function remove_round_players($day_id, $round_id)
    {
        $req = 'DELETE FROM players WHERE day_id = "' . $day_id . '" AND round_id = "' . $round_id . '"';
        return Connection::query($req);
    }

    function remove_all_players()
    {
        $req = 'DELETE FROM players';
        return Connection::query($req);
    }
}