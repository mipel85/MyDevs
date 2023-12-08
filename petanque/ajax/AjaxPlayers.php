<?php

include '../classes/Connection.class.php';
include '../classes/Players.class.php';

$actions = $_POST['action'];
switch($actions)
{
    case 'players_list':
        $liste = Players::players_list();
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
    
    case 'insert_player':
        $creation = new Players();
        $creation->set_name($_POST['name']);
        $creation->insert_player();
        break;
    
    case 'remove_player':
        $idSup = $_POST['id'];
        $sup = new Players($idSup);
        $sup->remove_player();
        break;
    
    case 'present':
        $present = new Players();
        $present->set_id($_POST['id']);
        $present->select_present();
        break;
    
    case 'absent':
        $absent = new Players();
        $absent->set_id($_POST['id']);
        $absent->reset_present();
        break;
    
    case 'reset_all_presents':
        $reset = new Players();
        $reset->reset_all_presents();
        break;
    
    case 'favory':
        $favory = new Players();
        $favory->set_id($_POST['id']);
        $favory->select_fav();
        break;
    
    case 'anonyme':
        $anonyme = new Players();
        $anonyme->set_id($_POST['id']);
        $anonyme->reset_fav();
        break;
    
    case 'reset_all_favs':
        $reset = new Players();
        $reset->reset_all_favs();
        break;
    
    default:
        break;
}
?>