<?php

namespace App\Items;

use \App\Db\Config;
use \App\Db\Connection;

class Days {
    private $id;
    private $date;
    private $active;

    public function __construct($id = null)
    {
        if (!is_null($id)){
            $req = 'SELECT * FROM ' . Config::get_config()->get('db_prefix') . 'days WHERE id = ' . $id;
            if ($result = Connection::query($req)){
                $result = $result[0];
                $this->set_id($result['id']);
                $this->set_date(self::today());
                $this->set_active($result['active']);
            }
        }
    }

    static function today($datetime = new \DateTime(), $format = ('d-m-Y'))
    {
        return $datetime->format($format);
    }

// start getters setters
    public function get_id() { return $this->id; }
    public function set_id($id) { $this->id = $id; }

    public function get_date() { return $this->date; }
    public function set_date($date) { $this->date = $date; }

    public function get_active() { return $this->active; }
    public function set_active($active) { $this->active = $active; }
// end getters setters

// start write sql data
    function insert_day()
    {
        $req = 'INSERT INTO ' . Config::get_config()->get('db_prefix') . 'days values (
                    NULL,
                    "' . $this->get_date() . '",
                    "1"
                )';
        return Connection::query($req);
    }

    function enable_day()
    {
        $req = 'UPDATE ' . Config::get_config()->get('db_prefix') . 'days SET active = 1 WHERE id = ' . $this->get_id() . '';
        return Connection::query($req);
    }

    function disable_day()
    {
        $req = 'UPDATE ' . Config::get_config()->get('db_prefix') . 'days SET active = 0 WHERE id = ' . $this->get_id() . '';
        return Connection::query($req);
    }
    
    function remove_day()
    {
        $req = 'DELETE FROM ' . Config::get_config()->get('db_prefix') . 'days WHERE id = "' . $this->get_id() . '"';
        return Connection::query($req);
    }
    
    function remove_all_days()
    {
        $req = 'DELETE FROM ' . Config::get_config()->get('db_prefix') . 'days';
        return Connection::query($req);
    }
// end write sql data

// start read sql
    /**
     * List of items
     *
     * @return array
     */
    static function days_list() : array
    {
        $days_list = array();
        $req = 'SELECT * FROM ' . Config::get_config()->get('db_prefix') . 'days ORDER BY `date` DESC';
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
    
    /**
     * get the id of a day item by a date `date(d-m-Y)`
     *
     * @param  string $date (must be dd-mm-YYYY)
     * @return int $id of the day item
     */
    static function day_id($date) : int
    {
        $id = [];
        foreach (self::days_list() as $values)
        {
            if($values['date'] == $date)
                $id[] = $values['id'];
        }
        return $id[0];
    }
    
    /**
     * Get the state of a day item
     *
     * @param  string $date (must be dd-mm-YYYY)
     * @return int $id of the day item
     */
    static function day_flag($day_id) : int
    {
        foreach (self::days_list() as $values)
        {
            if ($values['id'] == $day_id)
                return $values['active'];
        }
    }
    
    /**
     * Check if the day item of today is started
     *
     * @return bool
     */
    static function started_day() : bool
    {
        // set the current date
        $today = self::today();
        $dates = [];
        foreach(self::days_list() as $values) {
            $dates[] = $values['date'];
        }
        if (in_array($today, $dates)) return true;

        return false;
    }
// end read sql
}