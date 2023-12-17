<?php

include '../classes/Connection.class.php';
include '../classes/Members.class.php';
include '../classes/Days.class.php';
include '../classes/Rounds.class.php';
include '../classes/Teams.class.php';
include '../classes/Matches.class.php';
include '../classes/Rankings.class.php';
include '../controllers/Days.controller.php';
include '../controllers/Rankings.controller.php';

$actions = $_POST['action'];
switch($actions)
{
    case 'insert_players_list':
        $players_id = Rankings::rankings_members_id_list($_POST['day_id']);
        foreach (Members::selected_members_list() as $member) {
            if(!in_array($member['id'], $players_id)) {
                $add = new Rankings();
                $add->set_day_id($_POST['day_id']);
                $add->set_member_id($member['id']);
                $add->set_member_name($member['name']);
                $add->set_played(0);
                $add->set_victory(0);
                $add->set_loss(0);
                $add->set_pos_points(0);
                $add->set_neg_points(0);
                $add->add_player();
            }
        }
        break;

    default:
        break;
}
?>