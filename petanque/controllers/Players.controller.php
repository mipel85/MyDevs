
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

$score_to_rank = [];
foreach(Rankings::rankings_day_list($day_id) as $i => $rank) {
    $matches = [];
    $played = [];
    $victory = [];
    $loss = [];
    $pos_point = [];
    $neg_points = [];
    foreach(Players::players_list() as $player) {
        if($player['member_id'] == $rank['member_id']) {
            $played[] = $player['round_id'];
            $matches[] = $player['points_for'] . ' - ' . $player['points_against'];
            $diff_match = abs($player['points_for'] - $player['points_against']);
            if ($player['points_for'] == 13) {
                $victory[] = 1;
                $pos_point[] = $player['points_for'] + $diff_match;
                $loss[] = 0;
                $neg_points[] = 0;
            }
            else {
                $victory[] = 0;
                $pos_point[] = 0;
                $loss[] = 1;
                $neg_points[] = $player['points_for'] - $diff_match;
            }
        }
    }
    $score_to_rank[$i . ' | ' . $rank['member_name'] . ' (' . $rank['member_id'] . ')'] = [
        'matches' => json_encode($matches),
        'played' => count($played),
        'victory' => array_sum($victory),
        'loss' => array_sum($loss),
        'pos_point' => array_sum($pos_point),
        'neg_points' => array_sum($neg_points)
    ];
}
echo '<pre>';
print_r($score_to_rank);
echo '</pre>';

?>