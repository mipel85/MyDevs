<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

class Teams {
    private $id;
    private $day_id;
    private $round_id;
    private $player_1_id;
    private $player_1_name;
    private $player_2_id;
    private $player_2_name;
    private $player_3_id;
    private $player_3_name;

    public function __construct($id = null)
    {
        if (!is_null($id)){
            $req = 'SELECT * FROM teams WHERE id = ' . $id;
            if ($result = Connection::query($req)){
                $result = $result[0];
                $this->set_id($result['id']);
                $this->set_day_id($result['day_id']);
                $this->set_round_id($result['round_id']);
                $this->set_player_1_id($result['player_1_id']);
                $this->set_player_1_name($result['player_1_name']);
                $this->set_player_2_id($result['player_2_id']);
                $this->set_player_2_name($result['player_2_name']);
                $this->set_player_3_id($result['player_3_id']);
                $this->set_player_3_name($result['player_3_name']);
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

    public function get_player_1_id() { return $this->player_1_id; }
    public function set_player_1_id($player_1_id) { $this->player_1_id = $player_1_id; }

    public function get_player_1_name() { return $this->player_1_name; }
    public function set_player_1_name($player_1_name) { $this->player_1_name = $player_1_name; }

    public function get_player_2_id() { return $this->player_2_id; }
    public function set_player_2_id($player_2_id) { $this->player_2_id = $player_2_id; }

    public function get_player_2_name() { return $this->player_2_name; }
    public function set_player_2_name($player_2_name) { $this->player_2_name = $player_2_name; }

    public function get_player_3_id() { return $this->player_3_id; }
    public function set_player_3_id($player_3_id) { $this->player_3_id = $player_3_id; }

    public function get_player_3_name() { return $this->player_3_name; }
    public function set_player_3_name($player_3_name) { $this->player_3_name = $player_3_name; }
// end getters setters 
    
    function insert_team()
    {
        $req = 'INSERT INTO teams values (
                    NULL,
                    "' . $this->get_day_id() . '",
                    "' . $this->get_round_id() . '",
                    "' . $this->get_player_1_id() . '",
                    "' . $this->get_player_1_name() . '",
                    "' . $this->get_player_2_id() . '",
                    "' . $this->get_player_2_name() . '",
                    "' . $this->get_player_3_id() . '",
                    "' . $this->get_player_3_name() . '"
                )';
        return Connection::query($req);
    }

    function remove_day_teams($day_id)
    {
        $req = 'DELETE FROM teams WHERE day_id = "' . $day_id . '"';
        return Connection::query($req);
    }

    function remove_round_teams($day_id, $round_id)
    {
        $req = 'DELETE FROM teams WHERE day_id = "' . $day_id . '" AND round_id = "' . $round_id . '"';
        return Connection::query($req);
    }

    function remove_all_teams()
    {
        $req = 'DELETE FROM teams';
        return Connection::query($req);
    }

    static function round_teams_list($day_id, $round_id)
    {
        $teams = array();
        $req = 'SELECT teams.* FROM teams '
            . ' LEFT JOIN days ON days.id = teams.day_id'
            . ' LEFT JOIN rounds ON rounds.id = teams.round_id'
            . ' WHERE teams.day_id = "' . $day_id . '" AND teams.round_id = "' . $round_id . '"';

        if ($result = Connection::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    $teams[] = $value;
                }
            }
        }
        return $teams;
    }

    static function get_team_members($team_id)
    {
        $members = [];
        $req = 'SELECT teams.* FROM teams '
            . ' WHERE teams.id = "' . $team_id . '"';

        if ($result = Connection::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    $members[] = [
                        $value['player_1_id'],
                        $value['player_1_name'],
                        $value['player_2_id'],
                        $value['player_2_name'],
                        $value['player_3_id'],
                        $value['player_3_name']
                ];
                }
            }
        }
        return $members;
    }
}