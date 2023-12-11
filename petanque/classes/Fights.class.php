<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

class Fights {
    private $id;
    private $party_id;
    private $round_id;
    private $team_1_id;
    private $team_1_score;
    private $team_2_id;
    private $team_2_score;
    private $playground;

    public function __construct($id = null)
    {
        if (!is_null($id)){
            $req = 'SELECT * FROM fights WHERE id = ' . $id;
            if ($result = Connection::query($req)){
                $result = $result[0];
                $this->set_id($result['id']);
                $this->set_party_id($result['party_id']);
                $this->set_round_id($result['round_id']);
                $this->set_team_1_id($result['team_1_id']);
                $this->set_team_1_score($result['team_1_score']);
                $this->set_team_2_id($result['team_2_id']);
                $this->set_team_2_score($result['team_2_score']);
                $this->set_playground($result['playground']);
            }
        }
    }

// start getters setters
    public function get_id() { return $this->id; }
    public function set_id($id) { $this->id = $id; }

    public function get_party_id() { return $this->party_id; }
    public function set_party_id($party_id) { $this->party_id = $party_id; }

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
// end getters setters
    
    function add_fight()
    {
        $req = 'INSERT INTO fights values (
                    NULL,
                    "' . $this->get_party_id() . '",
                    "' . $this->get_round_id() . '",
                    "' . $this->get_team_1_id() . '",
                    "' . $this->get_team_1_score() . '",
                    "' . $this->get_team_2_id() . '",
                    "' . $this->get_team_2_score() . '",
                    "' . $this->get_playground() . '"
                )';
        return Connection::query($req);
    }

    function remove_party_fights($party_id)
    {
        $req = 'DELETE FROM fights WHERE party_id = "' . $party_id . '"';
        return Connection::query($req);
    }

    function remove_round_fights($party_id, $round_id)
    {
        $req = 'DELETE FROM fights WHERE party_id = "' . $party_id . '" AND round_id = "' . $round_id . '"';
        return Connection::query($req);
    }

    function remove_all_fights()
    {
        $req = 'DELETE FROM fights';
        return Connection::query($req);
    }

    function update_score_1($value)
    {
        $req = 'UPDATE fights SET `team_1_score` = "' . $value . '" WHERE `fights`.`id` = ' . $this->get_id() . '';
        return Connection::query($req);
    }

    function update_score_2($value)
    {
        $req = 'UPDATE fights SET `team_2_score` = "' . $value . '" WHERE `fights`.`id` = ' . $this->get_id() . '';
        return Connection::query($req);
    }

    static function round_fights_list($party_id, $round_id)
    {
        $fights = array();
        $req = 'SELECT fights.* FROM fights '
            . ' LEFT JOIN parties ON parties.id = fights.party_id'
            . ' LEFT JOIN rounds ON rounds.id = fights.round_id'
            . ' WHERE fights.party_id = "' . $party_id . '" AND fights.round_id = "' . $round_id . '"';

        if ($result = Connection::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    $fights[] = $value;
                }
            }
        }
        return $fights;
    }

}