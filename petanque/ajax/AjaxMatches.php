<?php

include '../classes/Connection.class.php';
include '../classes/Fields.class.php';
include '../classes/Matches.class.php';

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
                    $insert->set_team_1_score(0);
                    $insert->set_team_2_id($teams[1]);
                    $insert->set_team_2_score(0);
                    $insert->set_playground($playground_number);
                    $insert->set_score_status(0);

                    $insert->add_match();
                }
                $first = false;
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