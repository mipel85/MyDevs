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
    
    case 'present':
        $present = new Members();
        $present->set_id($_POST['id']);
        $present->select_present();
        break;
    
    case 'absent':
        $absent = new Members();
        $absent->set_id($_POST['id']);
        $absent->reset_present();
        break;
    
    case 'reset_all_presents':
        $reset = new Members();
        $reset->reset_all_presents();
        break;
    
    case 'favory':
        $favory = new Members();
        $favory->set_id($_POST['id']);
        $favory->select_fav();
        break;
    
    case 'casual':
        $casual = new Members();
        $casual->set_id($_POST['id']);
        $casual->reset_fav();
        break;
    
    case 'reset_all_favs':
        $reset = new Members();
        $reset->reset_all_favs();
        break;
    
    default:
        break;
}
?>