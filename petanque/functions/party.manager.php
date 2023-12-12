<?php

$party_started = Parties::party_started();
$today = date('d-m-Y');

$disabled_partie = $hidden_party = ''; 
$label_partie = 'Partie du jour';
if ($party_started) {
    $disabled_partie = ' disabled';
    $hidden_party = ' hidden';
    $label_partie = 'La partie du ' .$today.' a été initialisée.';
}

// Rounds
// get party_id
$party_id = $party_started ? Parties::party_id($today) : '';

// check if rounds
$c_rounds = $party_started ? count(Rounds::party_rounds_list($party_id)) > 0 : 0;

// set i_order
if ($party_id)
{
    $i_order = count(Rounds::round_i_order($party_id)) + 1;
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
    // if ($i_order > 4) $label_round = '<span class="message-helper bgc-full success">Le nombre maximum de parties est atteint.</span>';
    if ($players_number < 4) $label_round = '<span class="message-helper bgc-full warning">Il faut sélectionner au moins 4 joueurs pour créer une partie.</span>';
    if ($players_number == 7) $label_round = '<span class="message-helper bgc-full warning">Il n\'est pas possible de jouer avec 7 joueurs.</span>';
}

function last_round_id($party_id)
{
    // Warning, order desc so the last id is in first
    $rounds = Rounds::rounds_list($party_id);
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

function is_scored($party_id, $round_id)
{
    $scores = [];
    foreach (Matches::round_matches_list($party_id, $round_id) as $match) {
        // la rencontre a un score
        // var_dump(Matches::round_matches_list($party_id, $round_id));
        $score = false;
        // si 0:0 la rencontre n'a pas de score
        if($match['status'])
            $score = true;
        $scores[] = $score;
    }
    // si une des rencontre a un score
    if (in_array(true, $scores))
        return true;

    return false;
}
?>