<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

class Params {
    private $id;
    private $day_id;
    private $max_rounds_number;
    private $team_type;
    private $fields_number;

    public function __construct($id = null)
    {
        if (!is_null($id)){
            $req = 'SELECT * FROM params WHERE id = ' . $id;
            if ($result = Connection::query($req)){
                $result = $result[0];
                $this->set_id($result['id']);
                $this->set_day_id($result['day_id']);
                $this->set_max_rounds_number($result['max_rounds_number']);
                $this->set_team_type($result['team_type']);
                $this->set_fields_number($result['field_number']);
            }
        }
    }

// start getters setters
    public function get_id() { return $this->id; }
    public function set_id($id) { $this->id = $id; }

    public function get_day_id() { return $this->day_id; }
    public function set_day_id($day_id) { $this->day_id = $day_id; }

    public function get_max_rounds_number() { return $this->max_rounds_number; }
    public function set_max_rounds_number($max_rounds_number) { $this->max_rounds_number = $max_rounds_number; }

    public function get_team_type() { return $this->team_type; }
    public function set_team_type($team_type) { $this->team_type = $team_type; }

    public function get_fields_number() { return $this->fields_number; }
    public function set_fields_number($fields_number) { $this->fields_number = $fields_number; }
// end getters setters

    function insert_param()
    {
        $req = 'INSERT INTO params values (
                    NULL,
                    "' . $this->get_day_id() . '",
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

    function remove_day_params($day_id)
    {
        $req = 'DELETE FROM params WHERE day_id = "' . $day_id . '"';
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
        $req = 'SELECT params.*, days.date AS date FROM params '
            . ' LEFT JOIN days ON days.id = params.day_id'
            . ' ORDER BY params.day_id DESC';

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

    function select_fields_number($value)
    {
        $req = 'UPDATE params SET `fields_number` = "' . $value . '" WHERE `params`.`id` = ' . $this->get_id() . '';
        return Connection::query($req);
    }

    static function max_rounds_number($day_id)
    {
        $req = 'SELECT params WHERE `params`.`day_id` = ' . $day_id . '';
        return Connection::query($req);
    }

    static function team_type($day_id)
    {
        $req = 'SELECT params WHERE `params`.`day_id` = ' . $day_id . '';
        return Connection::query($req);
    }

    static function fields_number($day_id)
    {
        $req = 'SELECT params WHERE `params`.`day_id` = ' . $day_id . '';
        return Connection::query($req);
    }

    static function day_params_list($day_id)
    {
        $params = array();
        $req = 'SELECT params.*, days.date AS date FROM params '
            . ' LEFT JOIN days ON days.id = params.day_id'
            . ' WHERE params.day_id = ' . $day_id
            . ' ORDER BY params.day_id';

        if ($result = Connection::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    if($value['day_id'] = $day_id)
                        $params[] = $value;
                }
            }
        }
        return $params;
    }
}