<?php

namespace App\items;

use \App\db\Config;
use \App\db\Connection;

class Rounds {
    private $id;
    private $day_id;
    private $i_order;
    private $players_number;

    public function __construct($id = null)
    {
        if (!is_null($id)){
            $req = 'SELECT * FROM ' . Config::get_config()->get('db_prefix') . 'rounds WHERE id = ' . $id;
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

    function insert_round()
    {
        $req = 'INSERT INTO ' . Config::get_config()->get('db_prefix') . 'rounds values (
                    NULL,
                    "' . $this->get_day_id() . '",
                    "' . $this->get_i_order() . '",
                    "' . $this->get_players_number() . '"
                )';
        return Connection::query($req);
    }

    function remove_round()
    {
        $req = 'DELETE FROM ' . Config::get_config()->get('db_prefix') . 'rounds WHERE id = "' . $this->get_id() . '"';
        return Connection::query($req);
    }

    function remove_day_rounds($day_id)
    {
        $req = 'DELETE FROM ' . Config::get_config()->get('db_prefix') . 'rounds WHERE day_id = "' . $day_id . '"';
        return Connection::query($req);
    }

    function remove_all_rounds()
    {
        $req = 'DELETE FROM ' . Config::get_config()->get('db_prefix') . 'rounds';
        return Connection::query($req);
    }
    
    /**
     * Complete rounds list
     *
     * @return array
     */
    static function rounds_list() : array
    {
        $rounds = [];
        $req = 'SELECT * FROM ' . Config::get_config()->get('db_prefix') . 'rounds '
            . ' ORDER BY day_id DESC, i_order DESC';

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
    
    /**
     * Day rounds list
     *
     * @param  int $day_id
     * @return array
     */
    static function day_rounds_list($day_id) : array
    {
        $rounds = array();
        $req = 'SELECT * FROM ' . Config::get_config()->get('db_prefix') . 'rounds '
            . ' WHERE day_id = ' . $day_id
            . ' ORDER BY i_order';

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

    static function current_round_name($day_id)
    {
        $rounds = array();
        $req = 'SELECT * FROM ' . Config::get_config()->get('db_prefix') . 'rounds '
            . ' WHERE day_id = ' . $day_id
            . ' ORDER BY i_order DESC';

        if ($result = Connection::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    if($value['day_id'] = $day_id)
                        $rounds[] = $value['i_order'];
                }
            }
        }
        return $rounds[0];
    }

    static function current_round_id($day_id)
    {
        $rounds = array();
        $req = 'SELECT * FROM ' . Config::get_config()->get('db_prefix') . 'rounds '
            . ' WHERE day_id = ' . $day_id;

        if ($result = Connection::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    if($value['day_id'] = $day_id)
                        $rounds[] = $value['id'];
                }
            }
        }
        return $rounds[0];
    }
}