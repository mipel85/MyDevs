<?php

namespace App\controllers;

use \App\items\Days;
use \App\items\Rounds;
use \App\items\Members;
use \App\items\Matches;

class InitDays
{
    /**
     * Prevent from a new Days item if it already exists
     *
     * @return string
     */
    static function hidden_day() : string
    {
        return Days::started_day() ? ' hidden' : '';
    }
        
    /**
     * Get the id of the current Days item
     *
     * @return int
     */
    static function day_id() : int
    {
        return Days::started_day() ? Days::day_id(Days::today()) : 0;
    }
        
    /**
     * Get the state of the current Days item
     *
     * @return bool
     */
    static function day_flag() : bool
    {
        return Days::started_day() ? Days::day_flag(self::day_id()) : 0;
    }
        
    /**
     * Check if there is at least one round in the current Days item
     *
     * @return bool
     */
    static function c_rounds() : bool
    {
        return Days::started_day() ? count(Rounds::day_rounds_list(self::day_id())) > 0 : 0;
    }
    
    /**
     * Get the number of rounds (!= id)
     *
     * @return int
     */
    static function i_order() : int
    {
        return self::day_id() ? count(Rounds::round_i_order(self::day_id())) + 1 : 0;
    }
    
    /**
     * Get the number of selected players
     *
     * @return int
     */
    static function players_number() : int
    {
        return self::day_id() ? count(Members::selected_members_list()) : 0;
    }
    
    /**
     * Disable the 'new Rounds item' button if the number of selected players is incorrect
     *
     * @return string
     */
    static function disabled_round() : string
    {
        return (self::players_number() < 4 || self::players_number() == 7) ? ' disabled' : '';
    }
    
    /**
     * Prevent a new Rounds item if the number of selected players is incorrect
     *
     * @return string
     */
    static function hidden_round() : string
    {
        return self::day_id() && (self::players_number() < 4 || self::players_number() == 7) ? ' hidden' : '';
    }
    
    /**
     * Get the Rounds item description
     *
     * @return string
     */
    static function round_label() : string
    {
        foreach(Langs::get_lang_files() as $file) {
            include $file;
        };
        return self::day_id() ? str_replace(':number', self::players_number(), $lang['days.round.players']) : '';
    }
    

    /**
     *  Get the last Rounds item id of the Days item
     *
     * @param  int $day_id - Days item id
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
     * Check if at least a Matches item has a declared score
     *
     * @param  int $day_id - Days item id
     * @param  int $round_id - Rounds item id
     * @return bool
     */
    static function is_scored($day_id, $round_id) : bool
    {
        $scores = [];
        foreach (Matches::round_matches_list($day_id, $round_id) as $match) {
            $score = false;
            if($match['score_status'])
                $score = true;
            $scores[] = $score;
        }
        if (in_array(true, $scores))
            return true;

        return false;
    }

}

?>