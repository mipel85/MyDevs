
<?php
include '../classes/connexion.class.php';
include '../classes/parties.class.php';
include '../classes/manches.class.php';
include '../classes/Joueurs.class.php';

$actions = $_POST['action'];
switch($actions)
{
    case 'insert_party':
        $creation = new Parties();
        $creation->setDate($_POST['date_partie']);
        $creation->ajouter_partie();
        break;

    case 'delete_party':
        $idSup = $_POST['id'];
        $sup = new Parties($idSup);
        $sup->supprimer_partie();
        break;

    case 'delete_all_parties':
        $delete = new Parties();
        $delete->delete_all_parties();
        break;

    case 'insert_round':
        var_dump('plop');
        $insert = new Manches();
        $insert->setJ_id($_POST['j_id']);
        $insert->setI_order($_POST['i_order']);
        $insert->setNbJoueurs($_POST['nbj']);
        break;

    default:
        break;
}
?>