<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

class Members {
    private $id;
    private $name;
    private $present;
    private $fav;

    public function __construct($id = null)
    {
        if (!is_null($id)){
            $req = 'SELECT * FROM members WHERE id = ' . $id;
            if ($result = Connection::query($req)){
                $result = $result[0];
                $this->set_id($result['id']);
                $this->set_name($result['name']);
            }
        }
    }

// start getters setters
    public function get_id() { return $this->id; }
    public function set_id($id) { $this->id = $id; }

    public function get_name() { return $this->name; }
    public function set_name($name) { $this->name = $name; }

    public function get_present() { return $this->present; }
    public function set_present($present) { $this->present = $present; }

    public function get_fav() { return $this->fav; }
    public function set_fav($fav) { $this->fav = $fav; }
// end getters setters

    function insert_member()
    {
        $req = 'INSERT INTO members values (
                    NULL,
                    "' . $this->get_name() . '",
                    "0",
                    "0")
                ';
        return Connection::query($req);
    }

    function change_name($name)
    {
        $req = 'UPDATE members SET `name` = "' . $name . '" WHERE `members`.`id` = ' . $this->get_id() . '';
        return Connection::query($req);
    }

    function remove_member()
    {
        $req = 'DELETE FROM members WHERE id = "' . $this->get_id() . '"';
        return Connection::query($req);
    }

    function select_member()
    {
        $req = 'UPDATE members SET `present` = 1 WHERE `members`.`id` = ' . $this->get_id() . '';
        return Connection::query($req);
    }

    function unselect_member()
    {
        $req = 'UPDATE members SET `present` = 0 WHERE `members`.`id` = ' . $this->get_id() . '';
        return Connection::query($req);
    }

    function select_all_members()
    {
        $req = 'UPDATE members SET `present` = 1';
        return Connection::query($req);
    }

    function unselect_all_members()
    {
        $req = 'UPDATE members SET `present` = 0';
        return Connection::query($req);
    }

    function select_all_favs()
    {
        $req = 'UPDATE members SET `present` = 1 WHERE `fav` = 1';
        return Connection::query($req);
    }

    function set_member_fav()
    {
        $req = 'UPDATE members SET `fav` = 1 WHERE `members`.`id` = ' . $this->get_id() . '';
        return Connection::query($req);
    }

    function reset_member_fav()
    {
        $req = 'UPDATE members SET `fav` = 0 WHERE `members`.`id` = ' . $this->get_id() . '';
        return Connection::query($req);
    }

    function reset_all_members_fav()
    {
        $req = 'UPDATE members SET `fav` = 0';
        return Connection::query($req);
    }

    static function members_list()
    {
        $members_list = array();
        $req = 'SELECT * FROM members ORDER BY `name` ASC';
        if ($result = Connection::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    $members_list[] = $value;
                }
            }
        }
        return $members_list;
    }

    static function selected_members_list()
    {
        $selected_members_list = array();
        $req = 'SELECT * FROM members'
            . ' WHERE `present` = 1'
            . ' ORDER BY `name` ASC';

        if ($result = Connection::query($req)) {
            if (!empty($result)){
                foreach ($result as $values)
                {
                    $selected_members_list[] = $values;
                }
            }
        }
        return $selected_members_list;
    }
}