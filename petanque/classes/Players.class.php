<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

class Players {
    private $id;
    private $name;
    private $present;
    private $fav;

    public function __construct($id = null)
    {
        if (!is_null($id)){
            $req = 'SELECT * FROM players WHERE id = ' . $id;
            if ($result = Connection::query($req)){
                $result = $result[0];
                $this->set_id($result['id']);
                $this->set_name($result['name']);
            }
        }
    }

// getters setters
    public function get_id()
    {
        return $this->id;
    }

    public function set_id($id)
    {
        $this->id = $id;
    }

    public function get_name()
    {
        return $this->name;
    }

    public function set_name($name)
    {
        $this->name = $name;
    }

    public function get_present()
    {
        return $this->present;
    }

    public function set_present($present)
    {
        $this->present = $present;
    }

    public function get_fav()
    {
        return $this->fav;
    }

    public function set_fav($fav)
    {
        $this->fav = $fav;
    }
// fin  --- getters setters

    function insert_player()
    {
        $req = 'INSERT INTO players values (
                    NULL,
                    "' . $this->get_name() . '",
                    "0",
                    "0")
                ';
        return Connection::query($req);
    }

    function remove_player()
    {
        $req = 'DELETE FROM players WHERE id = "' . $this->get_id() . '"';
        return Connection::query($req);
    }

    function select_present()
    {
        $req = 'UPDATE players SET `present` = 1 WHERE `players`.`id` = ' . $this->get_id() . '';
        return Connection::query($req);
    }

    function reset_present()
    {
        $req = 'UPDATE players SET `present` = 0 WHERE `players`.`id` = ' . $this->get_id() . '';
        return Connection::query($req);
    }

    function reset_all_presents()
    {
        $req = 'UPDATE players SET `present` = 0';
        return Connection::query($req);
    }

    function select_fav()
    {
        $req = 'UPDATE players SET `fav` = 1 WHERE `players`.`id` = ' . $this->get_id() . '';
        return Connection::query($req);
    }

    function reset_fav()
    {
        $req = 'UPDATE players SET `fav` = 0 WHERE `players`.`id` = ' . $this->get_id() . '';
        return Connection::query($req);
    }

    function reset_all_favs()
    {
        $req = 'UPDATE players SET `fav` = 0';
        return Connection::query($req);
    }

    static function players_list()
    {
        $players_list = array();
        $req = 'SELECT id, name, present, fav FROM players ORDER BY `fav` DESC, `name` ASC';
        // var_dump(Connection::query($req));
        if ($result = Connection::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    $players_list[] = $value;
                }
            }
        }
        return $players_list;
    }

    static function present_players_list()
    {
        $present_players_list = array();
        $req = 'SELECT id, name FROM players'
            . ' WHERE `present` = 1'
            . ' ORDER BY `name` ASC';

        if ($result = Connection::query($req)) {
            if (!empty($result)){
                foreach ($result as $values)
                {
                    $present_players_list[] = $values;
                }
            }
        }
        return $present_players_list;
    }

    static function display_players_list($list)
    {
        foreach ($list as $values)
        {
            echo '<tr><td>' . $values['name'] . '</td><td><button id="' . $values['id'] . '" class="btn-sup"></button></td></tr>';
        }
    }
}