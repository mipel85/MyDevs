<?php

include '../classes/Connection.class.php';
include '../classes/Players.class.php';

// Afficher les équipes formées

$actions = $_POST['action'];
switch($actions)
{
    case 'insert_player':
        // List of existing players in `players` table
        $ranked_players_list = Players::players_id_list($_POST['day_id'], $_POST['round_id'], $_POST['match_id']);
        // A team players
        if (!in_array($_POST['player_a0_id'], $ranked_players_list)) {
            $insert = new Players();
            $insert->set_day_id($_POST['day_id']);
            $insert->set_round_id($_POST['round_id']);
            $insert->set_match_id($_POST['match_id']);
            $insert->set_member_id($_POST['player_a0_id']);
            $insert->set_member_name($_POST['player_a0_name']);
            $insert->insert_player();
        }
        if (!in_array($_POST['player_a0_id'], $ranked_players_list)) {
            $insert = new Players();
            $insert->set_day_id($_POST['day_id']);
            $insert->set_round_id($_POST['round_id']);
            $insert->set_match_id($_POST['match_id']);
            $insert->set_member_id($_POST['player_a2_id']);
            $insert->set_member_name($_POST['player_a2_name']);
            $insert->insert_player();
        }
        if ($_POST['player_a4_id']) {
            if (!in_array($_POST['player_a0_id'], $ranked_players_list)) {
                $insert = new Players();
                $insert->set_day_id($_POST['day_id']);
                $insert->set_round_id($_POST['round_id']);
                $insert->set_match_id($_POST['match_id']);
                $insert->set_member_id($_POST['player_a4_id']);
                $insert->set_member_name($_POST['player_a4_name']);
                $insert->insert_player();
            }
        }
        // B team players
        if (!in_array($_POST['player_a0_id'], $ranked_players_list)) {
            $insert = new Players();
            $insert->set_day_id($_POST['day_id']);
            $insert->set_round_id($_POST['round_id']);
            $insert->set_match_id($_POST['match_id']);
            $insert->set_member_id($_POST['player_b0_id']);
            $insert->set_member_name($_POST['player_b0_name']);
            $insert->insert_player();
        }
        if (!in_array($_POST['player_a0_id'], $ranked_players_list)) {
            $insert = new Players();
            $insert->set_day_id($_POST['day_id']);
            $insert->set_round_id($_POST['round_id']);
            $insert->set_match_id($_POST['match_id']);
            $insert->set_member_id($_POST['player_b2_id']);
            $insert->set_member_name($_POST['player_b2_name']);
            $insert->insert_player();
        }
        if ($_POST['player_b4_id']) {
            if (!in_array($_POST['player_a0_id'], $ranked_players_list)) {
                $insert = new Players();
                $insert->set_day_id($_POST['day_id']);
                $insert->set_round_id($_POST['round_id']);
                $insert->set_match_id($_POST['match_id']);
                $insert->set_member_id($_POST['player_b4_id']);
                $insert->set_member_name($_POST['player_b4_name']);
                $insert->insert_player();
            }
        }
        break;

    case 'update_players_score':
        $update = new Players();
        $update->update_player($_POST['match_id'], $_POST['player_score_status'], $_POST['player_a0_id'], $_POST['score_1'], $_POST['score_2']);
        $update = new Players();
        $update->update_player($_POST['match_id'], $_POST['player_score_status'], $_POST['player_a2_id'], $_POST['score_1'], $_POST['score_2']);
        if ($_POST['player_a4_id']) {
            $update = new Players();
            $update->update_player($_POST['match_id'], $_POST['player_score_status'], $_POST['player_a4_id'], $_POST['score_1'], $_POST['score_2']);
        }
        $update = new Players();
        $update->update_player($_POST['match_id'], $_POST['player_score_status'], $_POST['player_b0_id'], $_POST['score_2'], $_POST['score_1']);
        $update = new Players();
        $update->update_player($_POST['match_id'], $_POST['player_score_status'], $_POST['player_b2_id'], $_POST['score_2'], $_POST['score_1']);
        if ($_POST['player_b4_id']) {
            $update = new Players();
            $update->update_player($_POST['match_id'], $_POST['player_score_status'], $_POST['player_b4_id'], $_POST['score_2'], $_POST['score_1']);
        }
        break;
    default:
        break;
}
?>