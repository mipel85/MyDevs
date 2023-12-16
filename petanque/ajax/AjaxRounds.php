<?php

include '../classes/Connection.class.php';
include '../classes/Rounds.class.php';
include '../classes/Teams.class.php';
include '../classes/Matches.class.php';

$actions = $_POST['action'];
switch($actions)
{
    case 'insert_round':
        $insert = new Rounds();
        $insert->set_day_id($_POST['day_id']);
        $insert->set_i_order($_POST['i_order']);
        $insert->set_players_number($_POST['players_number']);
        $insert->insert_round();
        break;

    case 'remove_round':
        $remove = new Matches();
        $remove->remove_round_matches($_POST['day_id'], $_POST['round_id']);
        $remove = new Teams();
        $remove->remove_round_teams($_POST['day_id'], $_POST['round_id']);
        $remove = new Rounds($_POST['round_id']);
        $remove->remove_round();
        break;

    // case 'remove_all_rounds':
    //     $remove = new Matches();
    //     $remove->remove_all_matches();
    //     $remove = new Teams();
    //     $remove->remove_all_teams();
    //     $remove = new Rounds();
    //     $remove->remove_all_rounds();
    //     break;

    default:
        break;
}
?>