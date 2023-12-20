<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

class Matches {
    private $id;
    private $day_id;
    private $round_id;
    private $team_1_id;
    private $team_1_score;
    private $team_2_id;
    private $team_2_score;
    private $playground;
    private $score_status;

    public function __construct($id = null)
    {
        if (!is_null($id)){
            $req = 'SELECT * FROM matches WHERE id = ' . $id;
            if ($result = Connection::query($req)){
                $result = $result[0];
                $this->set_id($result['id']);
                $this->set_day_id($result['day_id']);
                $this->set_round_id($result['round_id']);
                $this->set_team_1_id($result['team_1_id']);
                $this->set_team_1_score($result['team_1_score']);
                $this->set_team_2_id($result['team_2_id']);
                $this->set_team_2_score($result['team_2_score']);
                $this->set_playground($result['playground']);
                $this->set_score_status($result['score_status']);
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

    public function get_team_1_id() { return $this->team_1_id; }
    public function set_team_1_id($team_1_id) { $this->team_1_id = $team_1_id; }

    public function get_team_1_score() { return $this->team_1_score; }
    public function set_team_1_score($team_1_score) { $this->team_1_score = $team_1_score; }

    public function get_team_2_id() { return $this->team_2_id; }
    public function set_team_2_id($team_2_id) { $this->team_2_id = $team_2_id; }

    public function get_team_2_score() { return $this->team_2_score; }
    public function set_team_2_score($team_2_score) { $this->team_2_score = $team_2_score; }

    public function get_playground() { return $this->playground; }
    public function set_playground($playground) { $this->playground = $playground; }

    public function get_score_status() { return $this->score_status; }
    public function set_score_status($score_status) { $this->score_status = $score_status; }
// end getters setters
    
    function insert_match()
    {
        $req = 'INSERT INTO matches values (
                    NULL,
                    "' . $this->get_day_id() . '",
                    "' . $this->get_round_id() . '",
                    "' . $this->get_team_1_id() . '",
                    "0",
                    "' . $this->get_team_2_id() . '",
                    "0",
                    "' . $this->get_playground() . '",
                    "0"
                )';
        return Connection::query($req);
    }

    function remove_day_matches($day_id)
    {
        $req = 'DELETE FROM matches WHERE day_id = "' . $day_id . '"';
        return Connection::query($req);
    }

    function remove_round_matches($day_id, $round_id)
    {
        $req = 'DELETE FROM matches WHERE day_id = "' . $day_id . '" AND round_id = "' . $round_id . '"';
        return Connection::query($req);
    }

    function remove_all_matches()
    {
        $req = 'DELETE FROM matches';
        return Connection::query($req);
    }

    function update_score_1($value)
    {
        $req = 'UPDATE matches SET `team_1_score` = "' . $value . '" WHERE `matches`.`id` = ' . $this->get_id() . '';
        return Connection::query($req);
    }

    function update_score_2($value)
    {
        $req = 'UPDATE matches SET `team_2_score` = "' . $value . '" WHERE `matches`.`id` = ' . $this->get_id() . '';
        return Connection::query($req);
    }

    function update_score_status($score_status)
    {
        $req = 'UPDATE matches SET `score_status` = "' . $score_status . '" WHERE `matches`.`id` = ' . $this->get_id() . '';
        return Connection::query($req);
    }

    static function matches_list()
    {
        $matches = array();
        $req = 'SELECT matches.* FROM matches ';

        if ($result = Connection::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    $matches[] = $value;
                }
            }
        }
        return $matches;
    }

    static function round_matches_list($day_id, $round_id)
    {
        $matches = array();
        $req = 'SELECT matches.* FROM matches '
            . ' LEFT JOIN days ON days.id = matches.day_id'
            . ' LEFT JOIN rounds ON rounds.id = matches.round_id'
            . ' WHERE matches.day_id = "' . $day_id . '" AND matches.round_id = "' . $round_id . '"';

        if ($result = Connection::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    $matches[] = $value;
                }
            }
        }
        return $matches;
    }

}