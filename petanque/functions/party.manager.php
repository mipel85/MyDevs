<?php

// Parties
$today = date('d-m-Y');
$date = [];
foreach(Parties::liste_parties() as $values)
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
// get p_id
$p_id = in_array($today, $date) ? Parties::partie_id($today) : '';
// set i_order
$i_order = count(Manches::manche_i_order($p_id)) + 1;
// get players number
$nbj = count(Joueurs::liste_joueurs_presents());
// en/disable add button
$disabled_manche = $hidden_manche = '';
if ($i_order > 4 || $nbj < 8) {
    $disabled_manche = ' disabled';
    $hidden_manche = ' hidden';
}
// set label
$label_manche = 'Ajouter la manche ' . $i_order . ' avec les ' . $nbj . ' participant.e.s sélectionné.e.s : ';
if ($i_order > 4) $label_manche = 'Le nombre maximum de manches est atteint. ';
if ($nbj < 8) $label_manche = 'Il faut sélectionner au moins 8 participant.e.s pour créer une manche.';

?>