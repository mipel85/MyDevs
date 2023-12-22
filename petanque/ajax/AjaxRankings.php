<?php

require_once ('../classes/Connection.class.php');
require_once ('../classes/Members.class.php');
require_once ('../classes/Days.class.php');
require_once ('../classes/Rounds.class.php');
require_once ('../classes/Teams.class.php');
require_once ('../classes/Matches.class.php');
require_once ('../classes/Rankings.class.php');
require_once ('../controllers/Players.controller.php');

$actions = $_POST['action'];
switch($actions)
{
    case 'insert_rank':
        // List of existing players in `rankings` table
        $ranked_players_list = Rankings::rankings_players_id_list($_POST['day_id']);
        // A team players
        if (!in_array($_POST['player_a0_id'], $ranked_players_list)) {
            $insert = new Rankings();
            $insert->set_day_id($_POST['day_id']);
            $insert->set_member_id($_POST['player_a0_id']);
            $insert->set_member_name($_POST['player_a0_name']);
            $insert->insert_rank();
        }
        if (!in_array($_POST['player_a2_id'], $ranked_players_list)) {
            $insert = new Rankings();
            $insert->set_day_id($_POST['day_id']);
            $insert->set_member_id($_POST['player_a2_id']);
            $insert->set_member_name($_POST['player_a2_name']);
            $insert->insert_rank();
        }
        if ($_POST['player_a4_id']) {
            if (!in_array($_POST['player_a4_id'], $ranked_players_list)) {
                $insert = new Rankings();
                $insert->set_day_id($_POST['day_id']);
                $insert->set_member_id($_POST['player_a4_id']);
                $insert->set_member_name($_POST['player_a4_name']);
                $insert->insert_rank();
            }
        }
        // B team players
        if (!in_array($_POST['player_b0_id'], $ranked_players_list)) {
            $insert = new Rankings();
            $insert->set_day_id($_POST['day_id']);
            $insert->set_member_id($_POST['player_b0_id']);
            $insert->set_member_name($_POST['player_b0_name']);
            $insert->insert_rank();
        }
        if (!in_array($_POST['player_b2_id'], $ranked_players_list)) {
            $insert = new Rankings();
            $insert->set_day_id($_POST['day_id']);
            $insert->set_member_id($_POST['player_b2_id']);
            $insert->set_member_name($_POST['player_b2_name']);
            $insert->insert_rank();
        }
        if ($_POST['player_b4_id']) {
            if (!in_array($_POST['player_b4_id'], $ranked_players_list)) {
                $insert = new Rankings();
                $insert->set_day_id($_POST['day_id']);
                $insert->set_member_id($_POST['player_b4_id']);
                $insert->set_member_name($_POST['player_b4_name']);
                $insert->insert_rank();
            }
        }
        break;

    case 'update_rank':
        foreach ($rankings_update as $rank) {
            $add = new Rankings();
            $add->update_rank(
                $rank['day_id'],
                $rank['member_id'],
                $rank['played'],
                $rank['victory'],
                $rank['loss'],
                $rank['pos_points'],
                $rank['neg_points'],
            );
        }
        break;

    default:
        break;
}
?>