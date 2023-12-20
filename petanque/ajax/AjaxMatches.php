<?php

require_once ('../classes/Connection.class.php');
require_once ('../classes/Fields.class.php');
require_once ('../classes/Matches.class.php');
require_once ('../classes/Teams.class.php');
require_once ('../classes/Players.class.php');
require_once ('../classes/Rankings.class.php');

// Afficher les équipes formées

$actions = $_POST['action'];
switch($actions)
{
    case 'insert_matches':
        $day_id = $_POST['day_id'];
        $round_id = $_POST['round_id'];
        include '../controllers/Matches.controller.php';
        $build_matches = build_matches($teams);
        shuffle($build_matches);

        $selected_playgrounds = Fields::fields_list($day_id);
        $playgrounds = playgrounds($selected_playgrounds, $build_matches);
        $first = true;
        foreach ($build_matches as $matches) {
            if ($first) {
                foreach ($matches as $teams) {
                    $playground_number = count($selected_playgrounds) > 0 ? array_shift($playgrounds) : 0;
                    $insert = new Matches();
                    $insert->set_day_id($_POST['day_id']);
                    $insert->set_round_id($_POST['round_id']);
                    $insert->set_team_1_id($teams[0]);
                    $insert->set_team_2_id($teams[1]);
                    $insert->set_playground($playground_number);

                    $insert->insert_match();
                }
                $first = false;
            }
        }
        // Ajout de la liste des joueurs dans la table player
        foreach (Matches::round_matches_list($_POST['day_id'], $_POST['round_id']) as $match) {
            foreach (Teams::get_team_members($match['team_1_id']) as $player) {
                $insert = new Players();
                $insert->set_day_id($match['day_id']);
                $insert->set_round_id($match['round_id']);
                $insert->set_match_id($match['id']);
                $insert->set_member_id($player[0]);
                $insert->set_member_name($player[1]);
                $insert->insert_player();
                $insert = new Players();
                $insert->set_day_id($match['day_id']);
                $insert->set_round_id($match['round_id']);
                $insert->set_match_id($match['id']);
                $insert->set_member_id($player[2]);
                $insert->set_member_name($player[3]);
                $insert->insert_player();
                if ($player[4]) {
                    $insert = new Players();
                    $insert->set_day_id($match['day_id']);
                    $insert->set_round_id($match['round_id']);
                    $insert->set_match_id($match['id']);
                    $insert->set_member_id($player[4]);
                    $insert->set_member_name($player[5]);
                    $insert->insert_player();
                }
            }
            foreach (Teams::get_team_members($match['team_2_id']) as $player) {
                $insert = new Players();
                $insert->set_day_id($match['day_id']);
                $insert->set_round_id($match['round_id']);
                $insert->set_match_id($match['id']);
                $insert->set_member_id($player[0]);
                $insert->set_member_name($player[1]);
                $insert->insert_player();
                $insert = new Players();
                $insert->set_day_id($match['day_id']);
                $insert->set_round_id($match['round_id']);
                $insert->set_match_id($match['id']);
                $insert->set_member_id($player[2]);
                $insert->set_member_name($player[3]);
                $insert->insert_player();
                if ($player[4]) {
                    $insert = new Players();
                    $insert->set_day_id($match['day_id']);
                    $insert->set_round_id($match['round_id']);
                    $insert->set_match_id($match['id']);
                    $insert->set_member_id($player[4]);
                    $insert->set_member_name($player[5]);
                    $insert->insert_player();
                }
            }
        }
        // Ajout de la liste des joueurs dans le classement
        $ranked_members_list = Rankings::rankings_members_id_list($day_id);
        foreach (Matches::round_matches_list($_POST['day_id'], $_POST['round_id']) as $match) {
            foreach (Teams::get_team_members($match['team_1_id']) as $player) {
                if (!in_array($player[0], $ranked_members_list)) {
                    $insert = new Rankings();
                    $insert->set_day_id($match['day_id']);
                    $insert->set_member_id($player[0]);
                    $insert->set_member_name($player[1]);
                    $insert->insert_player();
                }
                if (!in_array($player[2], $ranked_members_list)) {
                    $insert = new Rankings();
                    $insert->set_day_id($match['day_id']);
                    $insert->set_member_id($player[2]);
                    $insert->set_member_name($player[3]);
                    $insert->insert_player();
                }
                if ($player[4]) {
                    if (!in_array($player[4], $ranked_members_list)) {
                        $insert = new Rankings();
                        $insert->set_day_id($match['day_id']);
                        $insert->set_member_id($player[4]);
                        $insert->set_member_name($player[5]);
                        $insert->insert_player();
                    }
                }
            }
            foreach (Teams::get_team_members($match['team_2_id']) as $player) {
                if (!in_array($player[0], $ranked_members_list)) {
                    $insert = new Rankings();
                    $insert->set_day_id($match['day_id']);
                    $insert->set_member_id($player[0]);
                    $insert->set_member_name($player[1]);
                    $insert->insert_player();
                }
                if (!in_array($player[2], $ranked_members_list)) {
                    $insert = new Rankings();
                    $insert->set_day_id($match['day_id']);
                    $insert->set_member_id($player[2]);
                    $insert->set_member_name($player[3]);
                    $insert->insert_player();
                }
                if ($player[4]) {
                    if (!in_array($player[4], $ranked_members_list)) {
                        $insert = new Rankings();
                        $insert->set_day_id($match['day_id']);
                        $insert->set_member_id($player[4]);
                        $insert->set_member_name($player[5]);
                        $insert->insert_player();
                    }
                }
            }
        }
        break;

    case 'insert_scores':
        $insert = new Matches();
        $insert->set_id($_POST['id']);

        $insert->update_score_1($_POST['score_1']);
        $insert->update_score_2($_POST['score_2']);
        $insert->update_score_status($_POST['score_status']);
        break;

    case 'edit_scores':
        $insert = new Matches();
        $insert->set_id($_POST['id']);

        $insert->update_score_status($_POST['score_status']);
        break;

    default:
        break;
}
?>