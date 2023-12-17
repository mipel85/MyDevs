<?php

/*
 * Class of the events
*/

error_reporting(E_ALL);
ini_set('display_errors', true);

class Rankings {
    private $id;
    private $day_id;
    private $member_id;
    private $member_name;
    private $played;
    private $victory;
    private $loss;
    private $pos_points;
    private $neg_points;

    public function __construct($id = null)
    {
        if (!is_null($id)){
            $req = 'SELECT * FROM rankings WHERE id = ' . $id;
            if ($result = Connection::query($req)){
                $result = $result[0];
                $this->set_id($result['id']);
                $this->set_day_id($result['day_id']);
                $this->set_member_id($result['member_id']);
                $this->set_member_name($result['member_name']);
                $this->set_played($result['played']);
                $this->set_victory($result['victory']);
                $this->set_loss($result['loss']);
                $this->set_pos_points($result['pos_points']);
                $this->set_neg_points($result['neg_points']);
            }
        }
    }

// start getters setters
    public function get_id() { return $this->id; }
    public function set_id($id) { $this->id = $id; }

    public function get_day_id() { return $this->day_id; }
    public function set_day_id($day_id) { $this->day_id = $day_id; }

    public function get_member_id() { return $this->member_id; }
    public function set_member_id($member_id) { $this->member_id = $member_id; }

    public function get_member_name() { return $this->member_name; }
    public function set_member_name($member_name) { $this->member_name = $member_name; }

    public function get_played() { return $this->played; }
    public function set_played($played) { $this->played = $played; }

    public function get_victory() { return $this->victory; }
    public function set_victory($victory) { $this->victory = $victory; }

    public function get_loss() { return $this->loss; }
    public function set_loss($loss) { $this->loss = $loss; }

    public function get_pos_points() { return $this->pos_points; }
    public function set_pos_points($pos_points) { $this->pos_points = $pos_points; }

    public function get_neg_points() { return $this->neg_points; }
    public function set_neg_points($neg_points) { $this->neg_points = $neg_points; }
// end getters setters

    function add_player()
    {
        $req = 'INSERT INTO rankings values (
                    NULL,
                    "' . $this->get_day_id() . '",
                    "' . $this->get_member_id() . '",
                    "' . $this->get_member_name() . '",
                    "0",
                    "0",
                    "0",
                    "0",
                    "0"
                )';
        return Connection::query($req);
    }

    function remove_day_rankings($day_id)
    {
        $req = 'DELETE FROM rankings WHERE day_id = "' . $day_id . '"';
        return Connection::query($req);
    }

    function remove_all_rankings()
    {
        $req = 'DELETE FROM rankings';
        return Connection::query($req);
    }

    static function rankings_list($day_id) : array
    {
        $rankings_list = array();
        $req = 'SELECT * FROM rankings '
        . ' WHERE `day_id`= ' . $day_id
        . ' ORDER BY `victory` DESC, `pos_points` DESC, `neg_points` ASC, `member_name` ASC';
        if ($result = Connection::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    $rankings_list[] = $value;
                }
            }
        }
        return $rankings_list;
    }

    static function rankings_members_id_list($day_id) : array
    {
        $rankings_list = array();
        $req = 'SELECT * FROM rankings '
        . ' WHERE `day_id`= ' . $day_id;
        if ($result = Connection::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    $rankings_list[] = $value['member_id'];
                }
            }
        }
        return $rankings_list;
    }
}