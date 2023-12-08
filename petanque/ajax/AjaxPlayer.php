<?php

include '../classes/connection.class.php';
include '../classes/joueurs.class.php';

$actions = $_POST['action'];
switch($actions)
{
    case 'liste-joueurs':
        $liste = Joueurs::liste_joueurs_connus();
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
    
    case 'insert':
        $creation = new Joueurs();
        $creation->setNom_joueur($_POST['nom_joueur']);
        $creation->insert();
        break;
    
    case 'sup':
        $idSup = $_POST['id'];
        $sup = new Joueurs($idSup);
        $sup->suppression();
        break;
    
    case 'present':
        $present = new Joueurs();
        $present->setId($_POST['id']);
        $present->select_present();
        break;
    
    case 'absent':
        $absent = new Joueurs();
        $absent->setId($_POST['id']);
        $absent->reset_present();
        break;
    
    case 'reset_all_presents':
        $reset = new Joueurs();
        $reset->reset_all_presents();
        break;
    
    case 'favory':
        $favory = new Joueurs();
        $favory->setId($_POST['id']);
        $favory->select_fav();
        break;
    
    case 'anonyme':
        $anonyme = new Joueurs();
        $anonyme->setId($_POST['id']);
        $anonyme->reset_fav();
        break;
    
    case 'reset_all_favs':
        $reset = new Joueurs();
        $reset->reset_all_favs();
        break;
    
    default:
        break;
}
?>