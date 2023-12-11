<?php

include '../classes/Connection.class.php';
include '../classes/Fights.class.php';

// Afficher les équipes formées

$actions = $_POST['action'];
switch($actions)
{
    case 'insert_fights':
        $party_id = $_POST['party_id'];
        $round_id = $_POST['round_id'];
        include '../functions/fights.manager.php';
        $build_fights = build_fights($teams);
        shuffle($build_fights);

        $playgrounds_number = '10';
        $playground = playground($playgrounds_number);
        shuffle($playground);
        $first = true;
        foreach ($build_fights as $fights) {
            if ($first) {
                foreach ($fights as $teams) {
                    $insert = new Fights();
                    $insert->set_party_id($_POST['party_id']);
                    $insert->set_round_id($_POST['round_id']);
                    $insert->set_team_1_id($teams[0]);
                    $insert->set_team_1_score(0);
                    $insert->set_team_2_id($teams[1]);
                    $insert->set_team_2_score(0);
                    $insert->set_playground(array_shift($playground));

                    $insert->add_fight();
                }
                $first = false;
            }

        }
        break;
        
    case 'insert_scores':
        $insert = new Fights();
        $insert->set_id($_POST['id']);

        $insert->update_score_1($_POST['score_1']);
        $insert->update_score_2($_POST['score_2']);
        break;

    default:
        break;
}
?>