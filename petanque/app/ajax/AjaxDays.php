<?php

use \App\Items\Days;
use \App\Items\Fields;
use \App\Items\Rounds;
use \App\Items\Teams;
use \App\Items\Matches;
use \App\Items\Players;

include '../db/Connection.class.php';
include '../items/Days.class.php';
include '../items/Fields.class.php';
include '../items/Rounds.class.php';
include '../items/Teams.class.php';
include '../items/Matches.class.php';
include '../items/Players.class.php';

$actions = $_POST['action'];
switch($actions)
{
    case 'insert_day':
        $remove = new Fields();
        $remove->remove_all_fields();
        $remove = new Players();
        $remove->remove_all_players();
        $remove = new Matches();
        $remove->remove_all_matches();
        $remove = new Teams();
        $remove->remove_all_teams();
        $remove = new Rounds();
        $remove->remove_all_rounds();
        // $remove = new Days();
        // $remove->remove_all_days();
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
    
    case 'enable_day':
        $update = new Days();
        $update->set_id($_POST['day_id']);
        $update->enable_day();
        break;
    
    case 'disable_day':
        $update = new Days();
        $update->set_id($_POST['day_id']);
        $update->disable_day();
        break;

    case 'remove_day':
        $remove = new Fields();
        $remove->remove_day_fields($_POST['day_id']);
        $remove = new Players();
        $remove->remove_day_players($_POST['day_id']);
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
        $remove = new Players();
        $remove->remove_all_players();
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