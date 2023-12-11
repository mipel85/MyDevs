<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

class Params {
    private $id;
    private $party_id;
    private $max_rounds_number;
    private $team_type;
    private $playgmax_rounds_number;

    public function __construct($id = null)
    {
        if (!is_null($id)){
            $req = 'SELECT * FROM params WHERE id = ' . $id;
            if ($result = Connection::query($req)){
                $result = $result[0];
                $this->set_id($result['id']);
                $this->set_party_id($result['party_id']);
                $this->set_max_rounds_number($result['max_rounds_number']);
                $this->set_team_type($result['team_type']);
                $this->set_playgmax_rounds_number($result['playground_number']);
            }
        }
    }

// start getters setters
    public function get_id() { return $this->id; }
    public function set_id($id) { $this->id = $id; }

    public function get_party_id() { return $this->party_id; }
    public function set_party_id($party_id) { $this->party_id = $party_id; }

    public function get_max_rounds_number() { return $this->max_rounds_number; }
    public function set_max_rounds_number($max_rounds_number) { $this->max_rounds_number = $max_rounds_number; }

    public function get_team_type() { return $this->team_type; }
    public function set_team_type($team_type) { $this->team_type = $team_type; }

    public function get_playgmax_rounds_number() { return $this->playgmax_rounds_number; }
    public function set_playgmax_rounds_number($playgmax_rounds_number) { $this->playgmax_rounds_number = $playgmax_rounds_number; }
// end getters setters

    function insert_param()
    {
        $req = 'INSERT INTO params values (
                    NULL,
                    "' . $this->get_party_id() . '",
                    "4",
                    "2",
                    "14"
                )';
        return Connection::query($req);
    }

    function remove_param()
    {
        $req = 'DELETE FROM params WHERE id = "' . $this->get_id() . '"';
        return Connection::query($req);
    }

    function remove_party_params($party_id)
    {
        $req = 'DELETE FROM params WHERE party_id = "' . $party_id . '"';
        return Connection::query($req);
    }

    function remove_all_params()
    {
        $req = 'DELETE FROM params';
        return Connection::query($req);
    }

    static function params_list()
    {
        $params = array();
        $req = 'SELECT params.*, parties.date AS date FROM params '
            . ' LEFT JOIN parties ON parties.id = params.party_id'
            . ' ORDER BY params.party_id DESC';

        if ($result = Connection::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    $params[] = $value;
                }
            }
        }
        return $params;
    }

    function select_max_rounds_number($value)
    {
        $req = 'UPDATE params SET `max_rounds_number` = "' . $value . '" WHERE `params`.`id` = ' . $this->get_id() . '';
        return Connection::query($req);
    }

    function select_team_type($value)
    {
        $req = 'UPDATE params SET `team_type` = "' . $value . '" WHERE `params`.`id` = ' . $this->get_id() . '';
        return Connection::query($req);
    }

    function select_playgrounds_number($value)
    {
        $req = 'UPDATE params SET `playgrounds_number` = "' . $value . '" WHERE `params`.`id` = ' . $this->get_id() . '';
        return Connection::query($req);
    }

    static function max_rounds_number($party_id)
    {
        $req = 'SELECT params WHERE `params`.`party_id` = ' . $party_id . '';
        return Connection::query($req);
    }

    static function team_type($party_id)
    {
        $req = 'SELECT params WHERE `params`.`party_id` = ' . $party_id . '';
        return Connection::query($req);
    }

    static function playgrounds_number($party_id)
    {
        $req = 'SELECT params WHERE `params`.`party_id` = ' . $party_id . '';
        return Connection::query($req);
    }

    static function party_params_list($party_id)
    {
        $params = array();
        $req = 'SELECT params.*, parties.date AS date FROM params '
            . ' LEFT JOIN parties ON parties.id = params.party_id'
            . ' WHERE params.party_id = ' . $party_id
            . ' ORDER BY params.party_id';

        if ($result = Connection::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    if($value['party_id'] = $party_id)
                        $params[] = $value;
                }
            }
        }
        return $params;
    }
}