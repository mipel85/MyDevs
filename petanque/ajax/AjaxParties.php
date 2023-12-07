
<?php
include '../classes/connexion.class.php';
include '../classes/parties.class.php';

$actions = $_POST['action'];
switch($actions)
{
    case 'insert_partie':
        // Todo
        // Si une partie avec la même date existe, on retourne une erreur
        // Sinon on crée la partie et on envoie `disabled` au bouton d'ajout
        // et on active la section `manche`
        $creation = new Parties();
        $creation->setDate($_POST['date_partie']);
        $creation->ajouter_partie();
        break;

    case 'sup':
        $idSup = $_POST['id'];
        $sup = new Parties($idSup);
        $sup->supprimer_partie();
        break;

    case 'delete_all':
        $delete = new Parties();
        $delete->delete_all_parties();
        break;

    default:
        break;
}
?>