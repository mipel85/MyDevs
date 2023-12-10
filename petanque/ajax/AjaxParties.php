<?php

include '../classes/Connection.class.php';
include '../classes/Parties.class.php';
include '../classes/Rounds.class.php';
include '../classes/Teams.class.php';
include '../classes/Fights.class.php';

$actions = $_POST['action'];
switch($actions)
{
    case 'insert_party':
        $add = new Parties();
        $add->set_date($_POST['party_date']);
        $add->add_party();
        break;

    case 'remove_party':
        $remove = new Fights();
        $remove->remove_party_fights($_POST['party_id']);
        $remove = new Teams();
        $remove->remove_party_teams($_POST['party_id']);
        $remove = new Rounds();
        $remove->remove_party_rounds($_POST['party_id']);
        $remove = new Parties($_POST['party_id']);
        $remove->remove_party();
        break;

    case 'remove_all_parties':
        $remove = new Fights();
        $remove->remove_all_fights();
        $remove = new Teams();
        $remove->remove_all_teams();
        $remove = new Rounds();
        $remove->remove_all_rounds();
        $remove = new Parties();
        $remove->remove_all_parties();
        break;

    default:
        break;
}
?>