<?php

/*
 * Class of the events
*/

error_reporting(E_ALL);
ini_set('display_errors', true);

class Days {
    private $id;
    private $date;

    public function __construct($id = null)
    {
        if (!is_null($id)){
            $req = 'SELECT * FROM days WHERE id = ' . $id;
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

    function add_day()
    {
        $req = 'INSERT INTO days values (
                    NULL,
                    "' . $this->get_date() . '"
                )';
        return Connection::query($req);
    }

    function remove_day()
    {
        $req = 'DELETE FROM days WHERE id = "' . $this->get_id() . '"';
        return Connection::query($req);
    }

    function remove_all_days()
    {
        $req = 'DELETE FROM days';
        return Connection::query($req);
    }

    static function days_list()
    {
        $days_list = array();
        $req = 'SELECT * FROM days ORDER BY `date` DESC';
        if ($result = Connection::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    $days_list[] = $value;
                }
            }
        }
        return $days_list;
    }

    static function day_id($date)
    {
        $id = [];
        foreach (self::days_list() as $values)
        {
            if($values['date'] == $date)
                $id[] = $values['id'];
        }
        return $id[0];
    }

    static function started_day()
    {
        $today = date('d-m-Y');
        $dates = [];
        foreach(self::days_list() as $values) {
            $dates[] = $values['date'];
        }
        if (in_array($today, $dates)) return true;

        return false;
    }
}