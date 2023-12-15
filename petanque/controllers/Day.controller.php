<?php

$today = date('d-m-Y');
$started_day = Days::started_day();

// Day
// show/hide day init message
$hidden_day = $started_day ? ' hidden' : '';

// Rounds
// get day_id
$day_id = $started_day ? Days::day_id($today) : '';
// check if rounds
$c_rounds = $started_day ? count(Rounds::day_rounds_list($day_id)) > 0 : 0;

// set i_order
if ($day_id)
{
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
    $label_round = 'Ajouter la <strong>partie ' . $i_order . '</strong> avec les ' . $players_number . ' joueurs sélectionnés.';
    if ($players_number < 4) $label_round = '<span class="message-helper bgc-full warning">Il faut sélectionner au moins 4 joueurs pour créer une partie.</span>';
    if ($players_number == 7) $label_round = '<span class="message-helper bgc-full warning">Il n\'est pas possible de jouer avec 7 joueurs.</span>';
}

function last_round_id($day_id)
{
    // Warning, order desc so the last id is in first
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

function is_scored($day_id, $round_id)
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