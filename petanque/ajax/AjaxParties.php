<?php

include '../classes/Connection.class.php';
include '../classes/Parties.class.php';
include '../classes/Rounds.class.php';
include '../classes/Players.class.php';

$actions = $_POST['action'];
switch($actions)
{
    case 'insert_party':
        $creation = new Parties();
        $creation->set_date($_POST['party_date']);
        $creation->add_party();
        break;

    case 'remove_party':
        $idSup = $_POST['id'];
        $sup = new Rounds();
        $sup->remove_rounds_serie($idSup);
        $sup = new Parties($idSup);
        $sup->remove_party();
        break;

    case 'remove_all_parties':
        $delete = new Rounds();
        $delete->remove_all_rounds();
        $delete = new Parties();
        $delete->remove_all_parties();
        break;

    case 'insert_round':
        $insert = new Rounds();
        $insert->set_party_id($_POST['party_id']);
        $insert->set_i_order($_POST['i_order']);
        $insert->set_players_number($_POST['players_number']);
        $insert->add_round();
        break;

    case 'remove_round':
        $deleted_id = $_POST['id'];
        $delete = new Rounds($deleted_id);
        $delete->remove_round();
        break;

    case 'remove_all_manches':
        $delete = new Rounds();
        $delete->remove_all_rounds();
        break;

    default:
        break;
}
?>