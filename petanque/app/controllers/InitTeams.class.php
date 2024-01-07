<?php

namespace App\controllers;

use \App\items\Members;

class InitTeams
{
    /**
     * Get a randomised Members items list
     *
     * @return array
     */
    static function random_members() : array
    {
        $members = [];
        foreach (Members::selected_members_list() as $member)
        {
            $members[] = $member['id'].':'.$member['name'];
        }

        $shuffled_members = [];
        $keys = array_keys($members);
        shuffle($keys);
        foreach($keys as $key)
        {
            $shuffled_members[$key] = $members[$key];
        }

        return $shuffled_members;
    }

    /**
     * Build the Teams items list
     *
     * @return array
     */
    static function build_teams_list() : array
    {
        $members = self::random_members();
        $teams = [];

        $players_number = count($members);
        $teams_of_2 = floor($players_number / 2);
        $teams_of_2_even = $teams_of_2 % 2 == 0; // Check if the number of teams of 2 players is even
        $teams_of_3 = floor($players_number / 3);
        $teams_of_3_even = $teams_of_3 % 2 == 0; // Check if the number of teams of 3 players is even
        
        while (!empty($members)) {
            if (($teams_of_2_even && $teams_of_3_even) || ($teams_of_2_even && !$teams_of_3_even))
            {
                if (count($members) <= 3) {
                    $team = array_splice($members, 0, 3); // Build a team of 3 players
                } else {
                    $team = array_splice($members, 0, 2); // Build a team of 2 players
                }
            }
            elseif ((!$teams_of_2_even && $teams_of_3_even) || (!$teams_of_2_even && !$teams_of_3_even))
            {
                // if($players_number > 49) {
                //     if (count($members) <= 27) {
                //         $team = array_splice($members, 0, 3); // Build a team of 3 players
                //     } else {
                //         $team = array_splice($members, 0, 2); // Build a team of 2 players
                //     }
                // }
                // else {
                    if (count($members) <= 9) {
                        $team = array_splice($members, 0, 3); // Build a team of 3 players
                    } else {
                        $team = array_splice($members, 0, 2); // Build a team of 2 players
                    }
                // }
            }

            $teams[] = $team;
        }
        
        return $teams;
    }
}
?>
