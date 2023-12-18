<?php

include '../classes/Connection.class.php';
include '../classes/Members.class.php';

$actions = $_POST['action'];
switch($actions)
{
    case 'insert_member':
        $creation = new Members();
        $creation->set_name($_POST['name']);
        $creation->insert_member();
        break;
    
    case 'remove_member':
        $idSup = $_POST['id'];
        $sup = new Members($idSup);
        $sup->remove_member();
        break;
    
    case 'select_member':
        $present = new Members();
        $present->set_id($_POST['id']);
        $present->select_member();
        break;
    
    case 'unselect_member':
        $absent = new Members();
        $absent->set_id($_POST['id']);
        $absent->unselect_member();
        break;
    
    case 'unselect_all_members':
        $reset = new Members();
        $reset->unselect_all_members();
        break;
    
    case 'select_all_members':
        $reset = new Members();
        $reset->select_all_members();
        break;
    
    case 'set_member_fav':
        $favory = new Members();
        $favory->set_id($_POST['id']);
        $favory->set_member_fav();
        break;
    
    case 'reset_member_fav':
        $casual = new Members();
        $casual->set_id($_POST['id']);
        $casual->reset_member_fav();
        break;
    
    case 'select_all_favs':
        $reset = new Members();
        $reset->unselect_all_members();
        $reset->select_all_favs();
        break;
    
    case 'reset_all_members_fav':
        $reset = new Members();
        $reset->reset_all_members_fav();
        break;

    case 'selected_members':
        $req = 'SELECT name FROM members WHERE present = 1';
        if ($result = Connection::query($req)) {
            foreach ($result as $value) {
                $data[] = $value;
            }
            echo json_encode(array('selected_players' => $data));
        }
        break;

    case 'members_list':
        $req = 'SELECT * FROM members ORDER BY fav DESC, name ASC';
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