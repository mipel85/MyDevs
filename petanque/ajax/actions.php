
<?php
include '../classes/connexion.class.php';
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
                echo '<tbody><tr><td>' . $joueur['id'] . '</td><td>' . $joueur['nom'] . '</td><td><input type = "button" class="btn-sup-joueur" id="' . $joueur['id'] . '"</td></tr></body>';
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

    default:
        break;
}
?>