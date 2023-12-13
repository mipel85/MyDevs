<?php

include '../classes/Connection.class.php';
include '../classes/Matches.class.php';

// Afficher les équipes formées

$actions = $_POST['action'];
switch($actions)
{
    case 'insert_matches':
        $party_id = $_POST['party_id'];
        $round_id = $_POST['round_id'];
        include '../functions/matches.manager.php';
        $build_matches = build_matches($teams);
        shuffle($build_matches);

        $selected_playgrounds = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'];
        $playgrounds = playgrounds($selected_playgrounds, $build_matches);
        var_dump($playgrounds);
        $first = true;
        foreach ($build_matches as $matches) {
            if ($first) {
                foreach ($matches as $teams) {
                    $insert = new Matches();
                    $insert->set_party_id($_POST['party_id']);
                    $insert->set_round_id($_POST['round_id']);
                    $insert->set_team_1_id($teams[0]);
                    $insert->set_team_1_score(0);
                    $insert->set_team_2_id($teams[1]);
                    $insert->set_team_2_score(0);
                    $insert->set_playground(array_shift($playgrounds));
                    $insert->set_status(0);

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
        $insert->update_status($_POST['status']);
        break;

    case 'edit_scores':
        $insert = new Matches();
        $insert->set_id($_POST['id']);

        $insert->update_status($_POST['status']);
        break;

    default:
        break;
}
?>