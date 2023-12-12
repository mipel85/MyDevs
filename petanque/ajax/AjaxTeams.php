<?php

include '../classes/Connection.class.php';
include '../classes/Teams.class.php';

// Afficher les équipes formées

$actions = $_POST['action'];
switch($actions)
{
    case 'insert_teams':
        $party_id = $_POST['party_id'];
        $round_id = $_POST['round_id'];
        include '../functions/teams.manager.php';
        foreach (build_teams($members) as $team) {
            $insert = new Teams();
            $insert->set_party_id($_POST['party_id']);
            $insert->set_round_id($_POST['round_id']);
            $member_1 = explode(':', $team[0]);
            $insert->set_player_1_id(array_shift($member_1));
            $insert->set_player_1_name(array_pop($member_1));
            if (array_key_exists(1, $team)) $member_2 = explode(':', $team[1]);
            $insert->set_player_2_id(array_key_exists(1, $team) ? array_shift($member_2) : 0);
            $insert->set_player_2_name(array_key_exists(1, $team) ? array_pop($member_2) : '');
            if (array_key_exists(2, $team)) $member_3 = explode(':', $team[2]);
            $insert->set_player_3_id(array_key_exists(2, $team) ? array_shift($member_3) : 0);
            $insert->set_player_3_name(array_key_exists(2, $team) ? array_pop($member_3) : '');

            $insert->add_team();
        }
        break;

    default:
        break;
}
?>