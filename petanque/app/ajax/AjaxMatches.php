<?php

use App\controllers\InitMatches;
use \App\Items\Fields;
use \App\Items\Matches;

require_once ('../db/Connection.class.php');
require_once ('../controllers/InitMatches.class.php');
require_once ('../items/Fields.class.php');
require_once ('../items/Teams.class.php');
require_once ('../items/Matches.class.php');

// Afficher les équipes formées

$actions = $_POST['action'];
switch($actions)
{
    case 'insert_matches':
        $day_id = $_POST['day_id'];
        $round_id = $_POST['round_id'];
        $teams = InitMatches::random_teams($day_id, $round_id);
        $build_matches = InitMatches::build_matches_list($teams);
        shuffle($build_matches);

        $selected_playgrounds = Fields::fields_list($day_id);
        $playgrounds = InitMatches::playgrounds($selected_playgrounds, $build_matches);
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
        break;

    case 'insert_scores':
        $insert = new Matches();
        $insert->set_id($_POST['match_id']);

        $insert->update_score_1($_POST['score_1']);
        $insert->update_score_2($_POST['score_2']);
        $insert->update_score_status($_POST['score_status']);
        break;

    case 'edit_scores':
        $insert = new Matches();
        $insert->set_id($_POST['match_id']);

        $insert->update_score_status($_POST['score_status']);
        break;

    default:
        break;
}
?>