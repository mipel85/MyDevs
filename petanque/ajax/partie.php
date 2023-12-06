
<?php
include '../classes/connexion.class.php';
include '../classes/joueurs.class.php';

$parties = $_POST['partie'];
switch($parties)
{
    // case 'liste-joueurs':
    //     $liste = Joueurs::liste_joueurs_connus();
    //     if (!$liste){
    //         echo '</br>Erreur dans la requête<br />';
    //     }else{
    //         foreach ($liste as $joueur)
    //         {
    //             echo '<tbody><tr><td>' . $joueur['id'] . '</td><td>' . $joueur['nom'] . '</td><td><input type = "button" class="btn-sup-joueur" id="' . $joueur['id'] . '"</td></tr></body>';
    //         }
    //     }
    //     return $liste;
    //     break;

    case 'insert':
        // Todo
        // Si une partie avec la même date existe, on retourne une erreur
        // Sinon on crée la partie et on envoie `disabled` au bouton d'ajout
        // et on active la section `manche`
        $creation = new Parties();
        $creation->setDate($_POST['date_partie']);
        $creation->insert();
        break;

    case 'sup':
        $idSup = $_POST['id'];
        $sup = new Parties($idSup);
        $sup->suppression();
        break;

    case 'reset_all':
        $reset = new Parties();
        $reset->reset_all();
        break;

    default:
        break;
}
?>