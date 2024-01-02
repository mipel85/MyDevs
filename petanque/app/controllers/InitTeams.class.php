<?php

namespace App\controllers;

use \App\items\Members;

class InitTeams
{
    static function random_members()
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

        // Mélanger la liste de members de manière aléatoire
        return $shuffled_members;
    }

    // Fonction pour former les équipes
    static function build_teams_list() {
        $members = self::random_members();
        $teams = [];

        $players_number = count($members);
        $teams_of_2 = floor($players_number / 2);
        $teams_of_2_even = $teams_of_2 % 2 == 0;
        $teams_of_3 = floor($players_number / 3);
        $teams_of_3_even = $teams_of_3 % 2 == 0;
        
        // Tant qu'il y a des joueurs dans la liste
        while (!empty($members)) {
            // Si nb d'équipes de 2 possibles est pair et nb d'équipes de 3 possibles est pair
            // ou si nb d'équipes de 2 possibles est pair et nb d'équipes de 3 possibles est impair
            if (($teams_of_2_even && $teams_of_3_even) || ($teams_of_2_even && !$teams_of_3_even))
            {
                if (count($members) <= 3) {
                    $team = array_splice($members, 0, 3);
                } else {
                    $team = array_splice($members, 0, 2); // Sinon, prend les joueurs 2 par 2
                }
            }
            // Si nb d'équipes de 2 possibles est impair et nb d'équipes de 3 possibles est pair
            // ou si nb d'équipes de 2 possibles est impair et nb d'équipes de 3 possibles est impair
            elseif ((!$teams_of_2_even && $teams_of_3_even) || (!$teams_of_2_even && !$teams_of_3_even))
            {
                // if($players_number > 49) {
                //     if (count($members) <= 27) {
                //         $team = array_splice($members, 0, 3);
                //     } else {
                //         $team = array_splice($members, 0, 2); // Sinon, prend les joueurs 2 par 2
                //     }
                // }
                // else {
                    if (count($members) <= 9) {
                        $team = array_splice($members, 0, 3);
                    } else {
                        $team = array_splice($members, 0, 2); // Sinon, prend les joueurs 2 par 2
                    }
                // }
            }

            // Ajoute l'équipe formée à la liste des équipes
            $teams[] = $team;
        }
        
        return $teams;
    }
}


?>
