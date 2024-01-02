<?php

namespace App\Items;

use \App\Db\Config;
use \App\Db\Connection;
use \App\Items\Players;

class Rankings {
    private $id;
    private $day_id;
    private $day_date;
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
            $req = 'SELECT * FROM ' . Config::get_config()->get('db_prefix') . 'rankings WHERE id = ' . $id;
            if ($result = Connection::query($req)){
                $result = $result[0];
                $this->set_id($result['id']);
                $this->set_day_id($result['day_id']);
                $this->set_day_date($result['day_date']);
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

    public function get_day_date() { return $this->day_date; }
    public function set_day_date($day_date) { $this->day_date = $day_date; }

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

// start write sql data
    function insert_rank()
    {
        $req = 'INSERT INTO ' . Config::get_config()->get('db_prefix') . 'rankings values (
                    NULL,
                    "' . $this->get_day_id() . '",
                    "' . Days::today() . '",
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
        $req = 'DELETE FROM ' . Config::get_config()->get('db_prefix') . 'rankings WHERE day_id = ' . $day_id;
        return Connection::query($req);
    }

    function remove_all_rankings()
    {
        $req = 'DELETE FROM rankings';
        return Connection::query($req);
    }

    function update_rank($day_id, $member_id, $played, $victory, $loss, $pos_points, $neg_points)
    {
        $req = 'UPDATE ' . Config::get_config()->get('db_prefix') . 'rankings SET played = ' . $played . ', victory = ' . $victory . ', loss = ' . $loss . ', pos_points = ' . $pos_points . ', neg_points = ' . $neg_points . ' WHERE day_id = ' . $day_id . ' AND member_id = ' . $member_id;
        return Connection::query($req);
    }
// end write sql data

// start read sql data
    static function rankings_day_list($day_id) : array
    {
        $rankings_list = array();
        $req = 'SELECT * FROM ' . Config::get_config()->get('db_prefix') . 'rankings '
        . ' WHERE day_id = ' . $day_id
        . ' ORDER BY victory DESC, pos_points DESC, neg_points DESC, member_name ASC';
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
    
    /**
     * rankings_members_id_list
     *
     * @param  int $day_id
     * @return array
     */
    static function rankings_players_id_list($day_id) : array
    {
        $rankings_list = array();
        $req = 'SELECT day_id, member_id FROM ' . Config::get_config()->get('db_prefix') . 'rankings '
        . ' WHERE day_id = ' . $day_id;
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
    
    /**
     * check if players has updated scores
     *
     * @param  int $day_id
     * @return int
     */
    static function rankings_has_ranks($day_id) : int
    {
        $rankings_list = array();
        $req = 'SELECT day_id, played FROM ' . Config::get_config()->get('db_prefix') . 'rankings '
        . ' WHERE day_id = ' . $day_id;
        if ($result = Connection::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    $rankings_list[] = $value['played'];
                }
            }
        }
        return array_sum($rankings_list);
    }

    static function updated_ranks($day_id)
    {
        $updated_ranks = [];
        foreach(Rankings::rankings_day_list($day_id) as $i => $rank) {
            $played = [];
            $victory = [];
            $loss = [];
            $pos_points = [];
            $neg_points = [];
            foreach(Players::day_players_list($day_id) as $player) {
                if($player['member_id'] == $rank['member_id']) {
                    if ($player['score_status']) {
                        $played[] = $player['round_id'];
                        $diff_match = abs($player['points_for'] - $player['points_against']);
                        if ($player['points_for'] > $player['points_against']) {
                            $victory[] = 1;
                            $pos_points[] = $player['points_for'] + $diff_match;
                            $loss[] = 0;
                            $neg_points[] = 0;
                        }
                        elseif ($player['points_for'] < $player['points_against']) {
                            $victory[] = 0;
                            $pos_points[] = 0;
                            $loss[] = 1;
                            $neg_points[] = $player['points_for'] - $diff_match;
                        }
                    }
                }
            }
            $updated_ranks[] = [
                'day_id' => $day_id,
                'member_id' => $rank['member_id'],
                'played' => count($played),
                'victory' => array_sum($victory),
                'loss' => array_sum($loss),
                'pos_points' => array_sum($pos_points),
                'neg_points' => array_sum($neg_points)
            ];
        }
        return $updated_ranks;
    }
// end write sql data
}