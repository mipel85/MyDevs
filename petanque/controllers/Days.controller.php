<?php

// set the current date
$today = Days::today();
// set started Days item item condition
$c_started_day = Days::started_day();

// show/hide Days item init message
$hidden_day = $c_started_day ? ' hidden' : '';

// Rounds
// get Days item id
$day_id = $c_started_day ? Days::day_id($today) : '';
$day_flag = $c_started_day ? Days::day_flag($day_id) : '';

// check if rounds
$c_rounds = $c_started_day ? count(Rounds::day_rounds_list($day_id)) > 0 : 0;

// set i_order of rounds
if ($day_id) {
    $i_order = count(Rounds::round_i_order($day_id)) + 1;
    // get members number
    $players_number = count(Members::selected_members_list());
    // en/disable add button
    $disabled_round = $hidden_round = '';
    if ($players_number < 4 || $players_number == 7) {
        $disabled_round = ' disabled';
        $hidden_round = ' hidden';
    }
    // set label
    $label_round = ' avec les ' . $players_number . ' joueurs présents.';
    if ($players_number < 4) $label_round = '<span class="message-helper full-warning">Il faut sélectionner au moins 4 joueurs pour créer une partie.</span>';
    if ($players_number == 7) $label_round = '<span class="message-helper full-warning">Il n\'est pas possible de jouer avec 7 joueurs.</span>';
}

/**
 *  Check what is the last round item id of the Days item
 *
 * @param  int $day_id Days item id
 * @return int
 */
function last_round_id($day_id) : int
{
    $rounds = Rounds::rounds_list($day_id);
    $id = [];
    $last_element = true;
    foreach ($rounds as $round) {
        if($last_element) {
            $id[] = $round['id'];
            $last_element = false;
        }
    }
    return end($id);
}

/**
 * Check if a match has a declared score
 *
 * @param  int $day_id
 * @param  int $round_id
 * @return bool
 */
function is_scored($day_id, $round_id) : bool
{
    $scores = [];
    foreach (Matches::round_matches_list($day_id, $round_id) as $match) {
        // la rencontre a un score
        $score = false;
        // si 0:0 la rencontre n'a pas de score
        if($match['score_status'])
            $score = true;
        $scores[] = $score;
    }
    // si une des rencontre a un score
    if (in_array(true, $scores))
        return true;

    return false;
}
?>