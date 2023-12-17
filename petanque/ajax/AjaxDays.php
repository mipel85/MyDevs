<?php

include '../classes/Connection.class.php';
include '../classes/Days.class.php';
include '../classes/Fields.class.php';
include '../classes/Rounds.class.php';
include '../classes/Teams.class.php';
include '../classes/Matches.class.php';
include '../classes/Ranking.class.php';

$actions = $_POST['action'];
switch($actions)
{
    case 'insert_day':
        $add = new Days();
        $add->set_date($_POST['day_date']);
        $add->insert_day();
        $add = new Fields();
        $add->set_day_id(Days::day_id($_POST['day_date']));
        $add->insert_fields();
        break;
    
    case 'check_field':
        $update = new Fields();
        $update->set_id($_POST['fields_id']);
        $update->check_field($_POST['field_id']);
        break;
    
    case 'uncheck_field':
        $update = new Fields();
        $update->set_id($_POST['fields_id']);
        $update->uncheck_field($_POST['field_id']);
        break;

    case 'remove_day':
        $remove = new Fields();
        $remove->remove_day_fields($_POST['day_id']);
        $remove = new Ranking();
        $remove->remove_day_ranking($_POST['day_id']);
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
        $remove = new Fields();
        $remove->remove_all_fields();
        $remove = new Ranking();
        $remove->remove_all_rankings();
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