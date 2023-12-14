<?php

include '../classes/Connection.class.php';
include '../classes/Days.class.php';
include '../classes/Rounds.class.php';
include '../classes/Teams.class.php';
include '../classes/Matches.class.php';

$actions = $_POST['action'];
switch($actions)
{
    case 'insert_day':
        $add = new Days();
        $add->set_date($_POST['day_date']);
        $add->add_day();
        break;

    case 'remove_day':
        $remove = new Matches();
        $remove->remove_day_matches($_POST['day_id']);
        $remove = new Teams();
        $remove->remove_day_teams($_POST['day_id']);
        $remove = new Rounds();
        $remove->remove_day_rounds($_POST['day_id']);
        $remove = new Days($_POST['day_id']);
        $remove->remove_day();
        break;

    case 'remove_all_days':
        $remove = new Matches();
        $remove->remove_all_matches();
        $remove = new Teams();
        $remove->remove_all_teams();
        $remove = new Rounds();
        $remove->remove_all_rounds();
        $remove = new Days();
        $remove->remove_all_days();
        break;

    default:
        break;
}
?>