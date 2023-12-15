<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

class Rounds {
    private $id;
    private $day_id;
    private $i_order;
    private $players_number;

    public function __construct($id = null)
    {
        if (!is_null($id)){
            $req = 'SELECT * FROM rounds WHERE id = ' . $id;
            if ($result = Connection::query($req)){
                $result = $result[0];
                $this->set_id($result['id']);
                $this->set_day_id($result['day_id']);
                $this->set_i_order($result['i_order']);
                $this->set_players_number($result['players_number']);
            }
        }
    }

// start getters setters
    public function get_id() { return $this->id; }
    public function set_id($id) { $this->id = $id; }

    public function get_day_id() { return $this->day_id; }
    public function set_day_id($day_id) { $this->day_id = $day_id; }

    public function get_i_order() { return $this->i_order; }
    public function set_i_order($i_order) { $this->i_order = $i_order; }

    public function get_players_number() { return $this->players_number; }
    public function set_players_number($players_number) { $this->players_number = $players_number; }
// end getters setters

    function add_round()
    {
        $req = 'INSERT INTO rounds values (
                    NULL,
                    "' . $this->get_day_id() . '",
                    "' . $this->get_i_order() . '",
                    "' . $this->get_players_number() . '"
                )';
        return Connection::query($req);
    }

    function remove_round()
    {
        $req = 'DELETE FROM rounds WHERE id = "' . $this->get_id() . '"';
        return Connection::query($req);
    }

    function remove_day_rounds($day_id)
    {
        $req = 'DELETE FROM rounds WHERE day_id = "' . $day_id . '"';
        return Connection::query($req);
    }

    function remove_all_rounds()
    {
        $req = 'DELETE FROM rounds';
        return Connection::query($req);
    }

    static function rounds_list()
    {
        $rounds = array();
        $req = 'SELECT rounds.*, days.date AS date FROM rounds '
            . ' LEFT JOIN days ON days.id = rounds.day_id'
            . ' ORDER BY rounds.day_id DESC, rounds.i_order DESC';

        if ($result = Connection::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    $rounds[] = $value;
                }
            }
        }
        return $rounds;
    }

    static function day_rounds_list($day_id)
    {
        $rounds = array();
        $req = 'SELECT rounds.*, days.date AS date FROM rounds '
            . ' LEFT JOIN days ON days.id = rounds.day_id'
            . ' WHERE rounds.day_id = ' . $day_id
            . ' ORDER BY rounds.i_order';

        if ($result = Connection::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    if($value['day_id'] = $day_id)
                        $rounds[] = $value;
                }
            }
        }
        return $rounds;
    }

    static function round_i_order($day_id)
    {
        $i_order = [];
        foreach (self::day_rounds_list($day_id) as $values)
        {
            if($values['day_id'] = $day_id)
                $i_order[] = $values['i_order'];
        }
        return $i_order;
    }

    static function round_ids($day_id)
    {
        $ids = [];
        foreach (self::day_rounds_list($day_id) as $values)
        {
            if($values['day_id'] = $day_id)
                $ids[] = $values['id'];
        }
        return $ids;
    }
}