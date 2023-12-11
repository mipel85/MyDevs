<?php

// Parties
$today = date('d-m-Y');
$date = [];
foreach(Parties::parties_list() as $values)
{
    $date[] = $values['date'];
}
$disabled_partie = $hidden_party = ''; 
$label_partie = 'Partie du jour';
if (in_array($today, $date)) {
    $disabled_partie = ' disabled';
    $hidden_party = ' hidden';
    $label_partie = 'La partie du '.$today.' a été initialisée.';
}

// Rounds
// get party_id
$party_id = in_array($today, $date) ? Parties::party_id($today) : '';

// check if rounds
$c_rounds = $party_id ? count(Rounds::rounds_list($party_id)) > 0 : 0;

// set i_order
if ($party_id)
{
    $i_order = count(Rounds::round_i_order($party_id)) + 1;
    // get players number
    $players_number = count(Players::present_players_list());
    // en/disable add button
    $disabled_round = $hidden_round = '';
    if ($i_order > 4 || $players_number < 8) {
        $disabled_round = ' disabled';
        $hidden_round = ' hidden';
    }
    // set label
    $label_round = 'Ajouter la manche ' . $i_order . ' avec les ' . $players_number . ' joueurs sélectionnés.';
    if ($i_order > 4) $label_round = '<span class="message-helper bgc-full success">Le nombre maximum de manches est atteint.</span>';
    if ($players_number < 8) $label_round = '<span class="message-helper bgc-full warning">Il faut sélectionner au moins 8 joueurs pour créer une manche.</span>';
}

function player_from_list($team_id) 
{
    foreach (Teams::get_team_players($team_id) as $player) {
        echo '<span class="fight-player"></span>' . implode('</span><span class="fight-player">', $player) . '</span>';
    }
}

function last_round_id($party_id)
{
    $rounds = Rounds::rounds_list($party_id);
    $ids = [];
    foreach ( $rounds as $values) {
        $ids[] = $values['id'];
    }
    return end($ids);
}
?>