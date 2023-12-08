<?php

include '../classes/connection.class.php';
include '../classes/parties.class.php';
include '../classes/manches.class.php';
include '../classes/joueurs.class.php';

$actions = $_POST['action'];
switch($actions)
{
    case 'insert_party':
        $creation = new Parties();
        $creation->setDate($_POST['date_partie']);
        $creation->ajouter_partie();
        break;

    case 'delete_party':
        $idSup = $_POST['id'];
        $sup = new Manches();
        $sup->delete_manches_serie($idSup);
        $sup = new Parties($idSup);
        $sup->supprimer_partie();
        break;

    case 'delete_all_parties':
        $delete = new Manches();
        $delete->delete_all_manches();
        $delete = new Parties();
        $delete->delete_all_parties();
        break;

    case 'insert_round':
        $insert = new Manches();
        $insert->setP_id($_POST['p_id']);
        $insert->setI_order($_POST['i_order']);
        $insert->setNbJoueurs($_POST['nbj']);
        $insert->ajouter_manche();
        break;

    case 'delete_round':
        $deleted_id = $_POST['id'];
        $delete = new Manches($deleted_id);
        $delete->supprimer_manche();
        break;

    case 'delete_all_manches':
        $delete = new Manches();
        $delete->delete_all_manches();
        break;

    default:
        break;
}
?>