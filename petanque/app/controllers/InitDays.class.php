<?php

namespace App\Controllers;

use \App\Items\Days;
use \App\Items\Rounds;
use \App\Items\Members;
use \App\Items\Matches;

class InitDays
{
    static function hidden_day()
    {
        return Days::started_day() ? ' hidden' : '';
    }
        // show/hide Days item init message
    
    static function day_id()
    {
        return Days::started_day() ? Days::day_id(Days::today()) : '';
    }
    
    static function day_flag()
    {
        return Days::started_day() ? Days::day_flag(self::day_id()) : '';
    }
    
    static function c_rounds()
    {
        return Days::started_day() ? count(Rounds::day_rounds_list(self::day_id())) > 0 : 0;
    }

    static function i_order()
    {
        return self::day_id() ? count(Rounds::round_i_order(self::day_id())) + 1 : '';
    }

    static function players_number()
    {
        return self::day_id() ? count(Members::selected_members_list()) : '';
    }

    static function disabled_round()
    {
        return (self::players_number() < 4 || self::players_number() == 7) ? ' disabled' : '';
    }

    static function hidden_round()
    {
        return self::day_id() && (self::players_number() < 4 || self::players_number() == 7) ? ' hidden' : '';
    }

    static function round_label()
    {
        foreach(Langs::get_lang_files() as $file) {
            include $file;
        };
        return self::day_id() ? str_replace(':number', self::players_number(), $lang['days.round.players']) : '';
    }
    

    /**
     *  Check what is the last round item id of the Days item
     *
     * @param  int $day_id Days item id
     * @return int
     */
    static function latest_round_id($day_id) : int
    {
        $rounds = Rounds::rounds_list($day_id);
        $id = [];
        $last_element = true;
        foreach ($rounds as $round) {
            if($last_element) {
                $id[] = $round['id'];
                $last_element = false;
            }
        }
        return end($id);
    }

    /**
     * Check if a match has a declared score
     *
     * @param  int $day_id
     * @param  int $round_id
     * @return bool
     */
    static function is_scored($day_id, $round_id) : bool
    {
        $scores = [];
        foreach (Matches::round_matches_list($day_id, $round_id) as $match) {
            // la rencontre a un score
            $score = false;
            // si 0:0 la rencontre n'a pas de score
            if($match['score_status'])
                $score = true;
            $scores[] = $score;
        }
        // si une des rencontre a un score
        if (in_array(true, $scores))
            return true;

        return false;
    }

}

?>