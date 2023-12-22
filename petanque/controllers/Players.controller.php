
<?php

require_once ('../classes/Connection.class.php');
require_once ('../classes/Members.class.php');
require_once ('../classes/Rounds.class.php');
require_once ('../classes/Days.class.php');
require_once ('../classes/Matches.class.php');
require_once ('../classes/Teams.class.php');
require_once ('../classes/Players.class.php');
require_once ('../classes/Rankings.class.php');
require_once ('../controllers/Days.controller.php');

$update = [];
foreach(Rankings::rankings_day_list($day_id) as $i => $rank) {
    $round_id = [];
    $score_status = [];
    $matches = [];
    $played = [];
    $victory = [];
    $loss = [];
    $pos_points = [];
    $neg_points = [];
    foreach(Players::players_list() as $player) {
        if($player['member_id'] == $rank['member_id']) {
            $score_status[] = $player['score_status'];
            if ($player['score_status'])
                $played[] = $player['round_id'];
            $matches[] = $player['points_for'] . ' - ' . $player['points_against'];
            $diff_match = abs($player['points_for'] - $player['points_against']);
            if ($player['points_for'] > $player['points_against']) {
                $victory[] = 1;
                $pos_points[] = $player['points_for'] + $diff_match;
                $loss[] = 0;
                $neg_points[] = 0;
            }
            else {
                $victory[] = 0;
                $pos_points[] = 0;
                $loss[] = $player['score_status'] ? 1 : 0;
                $neg_points[] = $player['points_for'] - $diff_match;
            }
        }
    }
    $update[] = [
        'matches' => json_encode($matches),
        'score_status' => json_encode($score_status),
        'day_id' => $day_id,
        'member_id' => $rank['member_id'],
        'member_name' => $rank['member_name'],
        'played' => count($played),
        'victory' => array_sum($victory),
        'loss' => array_sum($loss),
        'pos_points' => array_sum($pos_points),
        'neg_points' => array_sum($neg_points)
    ];
}
// echo '<pre>';
// print_r($update);
// echo '</pre>';
// foreach($update as $rank) {
//     echo $rank['member_id'];
//     echo $rank['played'];
//     echo $rank['victory'];
//     echo $rank['loss'];
//     echo $rank['pos_points'];
//     echo $rank['neg_points'];
// }

?>