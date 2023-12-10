<?php

/*
 * Class of the events
*/

error_reporting(E_ALL);
ini_set('display_errors', true);

class Parties {
    private $id;
    private $date;

    public function __construct($id = null)
    {
        if (!is_null($id)){
            $req = 'SELECT * FROM parties WHERE id = ' . $id;
            if ($result = Connection::query($req)){
                $result = $result[0];
                $this->set_id($result['id']);
                $this->set_date(date('d-m-Y'));
            }
        }
    }

// start getters setters
    public function get_id() { return $this->id; }
    public function set_id($id) { $this->id = $id; }

    public function get_date() { return $this->date; }
    public function set_date($date) { $this->date = $date; }
// end getters setters

    function add_party()
    {
        $req = 'INSERT INTO parties values (
                    NULL,
                    "' . $this->get_date() . '"
                )';
        return Connection::query($req);
    }

    function remove_party()
    {
        $req = 'DELETE FROM parties WHERE id = "' . $this->get_id() . '"';
        return Connection::query($req);
    }

    function remove_all_parties()
    {
        $req = 'DELETE FROM parties';
        return Connection::query($req);
    }

    static function parties_list()
    {
        $liste_parties = array();
        $req = 'SELECT * FROM parties ORDER BY `date` DESC';
        if ($result = Connection::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    $liste_parties[] = $value;
                }
            }
        }
        return $liste_parties;
    }

    static function party_id($date)
    {
        $id = [];
        foreach (self::parties_list() as $values)
        {
            if($values['date'] == $date)
                $id[] = $values['id'];
        }
        return $id[0];
    }
}