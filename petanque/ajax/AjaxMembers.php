<?php

include '../classes/Connection.class.php';
include '../classes/Members.class.php';

$actions = $_POST['action'];
switch($actions)
{
    case 'members_list':
        $liste = Members::members_list();
        if (!$liste){
            echo '</br>Erreur dans la requête<br />';
        }else{
            foreach ($liste as $joueur)
            {
                echo '<tbody>
                    <tr>
                        <td>' . $joueur['id'] . '</td>
                        <td>' . $joueur['nom'] . '</td>
                        <td><input type="checkbox" class="btn-fav-joueur" id="' . $joueur['id'] . '" /></td>
                        <td><input type="button" class="btn-sup-joueur" id="' . $joueur['id'] . '" /</td>
                    </tr>
                </tbody>';
            }
        }
        return $liste;
        break;
    
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
    
    case 'anonyme':
        $anonyme = new Members();
        $anonyme->set_id($_POST['id']);
        $anonyme->reset_fav();
        break;
    
    case 'reset_all_favs':
        $reset = new Members();
        $reset->reset_all_favs();
        break;
    
    default:
        break;
}
?>