<?php

include '../classes/Connection.class.php';
include '../classes/Players.class.php';

// Afficher les équipes formées

$actions = $_POST['action'];
switch($actions)
{
    case 'update_players_score':
        $update = new Players();
        $update->update_player($_POST['match_id'], $_POST['player_1_0_id'], $_POST['score_1'], $_POST['score_2']);
        $update = new Players();
        $update->update_player($_POST['match_id'], $_POST['player_1__id'], $_POST['score_1'], $_POST['score_2']);
        if ($_POST['player_1_4_id']) {
            $update = new Players();
            $update->update_player($_POST['match_id'], $_POST['player_1_4_id'], $_POST['score_1'], $_POST['score_2']);
        }
        $update = new Players();
        $update->update_player($_POST['match_id'], $_POST['player_2_0_id'], $_POST['score_2'], $_POST['score_1']);
        $update = new Players();
        $update->update_player($_POST['match_id'], $_POST['player_2_2_id'], $_POST['score_2'], $_POST['score_1']);
        if ($_POST['player_2_4_id']) {
            $update = new Players();
            $update->update_player($_POST['match_id'], $_POST['player_2_4_id'], $_POST['score_2'], $_POST['score_1']);
        }
        break;
    default:
        break;
}
?>