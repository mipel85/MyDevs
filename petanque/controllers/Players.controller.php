
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

// echo 'Liste des id de membre déjà dans le classement du jour: <br>';
// var_dump(Rankings::rankings_members_id_list($day_id));
// var_dump(Players::players_list());

// $player_list = json_encode(Players::players_list());
// $player_list = ltrim($player_list, '[');
// $player_list = rtrim($player_list, ']');
// // $player_list = json_decode($player_list);
// $player_list = explode('{', $player_list);
// echo '<pre>';
// print_r($player_list);
// echo '</pre>';
$ranked_players = [];
$score_to_rank = [];
foreach(Rankings::rankings_day_list($day_id) as $rank) {
    $player_id = $rank['member_id'];
    $player_name = $rank['member_name'];
    $matches = [];
    $played = [];
    $victory = [];
    $loss = [];
    $pos_point = [];
    $neg_points = [];
    $diff = [];
    foreach(Players::players_list() as $player) {
        if($player['member_id'] == $rank['member_id']) {
            $played[] = $player['round_id'];
            $matches[] = $player['points_for'] . ' - ' . $player['points_against'];
            $diff_match = (int)($player['points_for'] - $player['points_against']);
            $diff[] = $diff_match;
            if ($player['points_for'] == 13) {
                $victory[] = 1;
                $pos_point[] = $player['points_for'] + ($player['points_for'] - $player['points_against']);
                $loss[] = 0;
                $neg_points[] = 0;
            }
            else {
                $victory[] = 0;
                $pos_point[] = 0;
                $loss[] = 1;
                if ($diff_match < 0) {
                    var_dump($diff_match < 0);
                    $neg_points[] = $player['points_against'] + ($player['points_for'] - $player['points_against']);
                }
                else {
                    $neg_points[] = $player['points_against'] - ($player['points_for'] - $player['points_against']);
                }
            }
        }
    }
    $score_to_rank[] = [
        'matches' => json_encode($matches),
        'member_id' => $player_id,
        'member_name' => $player_name,
        'played' => count($played),
        'victory' => array_sum($victory),
        'loss' => array_sum($loss),
        'diff' =>  array_sum($diff),
        'pos_point' => array_sum($pos_point),
        'neg_points' => array_sum($neg_points)
    ];
}
echo '<pre>';
print_r($score_to_rank);
echo '</pre>';

?>