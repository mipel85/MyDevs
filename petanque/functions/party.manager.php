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
    $label_manche = 'Ajouter la manche ' . $i_order . ' avec les ' . $players_number . ' participant.e.s sélectionné.e.s : ';
    if ($i_order > 4) $label_manche = 'Le nombre maximum de manches est atteint. ';
    if ($players_number < 8) $label_manche = 'Il faut sélectionner au moins 8 participant.e.s pour créer une manche.';
}
?>