<?php

use \App\db\Config;
use \App\db\Connection;
use \App\items\Members;

include '../db/Config.class.php';
include '../db/Connection.class.php';
include '../items/Members.class.php';

$actions = $_POST['action'];
switch($actions)
{
    // Config
    case 'insert_member':
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES);
        $creation = new Members();
        $creation->set_name($name);
        $creation->insert_member();
        break;
    
    case 'remove_member':
        $idSup = $_POST['id'];
        $sup = new Members($idSup);
        $sup->remove_member();
        break;
    
    case 'change_name':
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES);
        $update = new Members();
        $update->set_id($_POST['id']);
        $update->change_name($name);
        break;
    
    // Front
    case 'select_member':
        $update = new Members();
        $update->set_id($_POST['id']);
        $update->select_member();
        break;
    
    case 'unselect_member':
        $update = new Members();
        $update->set_id($_POST['id']);
        $update->unselect_member();
        break;
    
    case 'unselect_all_members':
        $update = new Members();
        $update->unselect_all_members();
        break;
    
    case 'select_all_members':
        $update = new Members();
        $update->select_all_members();
        break;
    
    case 'set_member_fav':
        $update = new Members();
        $update->set_id($_POST['id']);
        $update->set_member_fav();
        break;
    
    case 'reset_member_fav':
        $update = new Members();
        $update->set_id($_POST['id']);
        $update->reset_member_fav();
        break;
    
    case 'select_all_favs':
        $update = new Members();
        $update->unselect_all_members();
        $update->select_all_favs();
        break;
    
    case 'reset_all_members_fav':
        $update = new Members();
        $update->reset_all_members_fav();
        break;

    case 'selected_members':
        $req = 'SELECT name FROM ' . Config::get_config()->get('db_prefix') . 'members WHERE present = 1';
        if ($result = Connection::query($req)) {
            foreach ($result as $value) {
                $data[] = $value;
            }
            echo json_encode(array('selected_players' => $data));
        }
        break;

    case 'members_list':
        $req = 'SELECT * FROM ' . Config::get_config()->get('db_prefix') . 'members ORDER BY fav DESC, name ASC';
        if ($result = Connection::query($req)) {
            foreach ($result as $value) {
                $data[] = $value;
            }
            echo json_encode(array('members' => $data));
        }
        break;
    
    default:
        break;
}
?>