<?php
require_once('../classes/Teams.class.php');
require_once('../classes/Players.class.php');
require_once('../classes/Connection.class.php');

// Liste de joueurs présents
$selected_players_list = Players::present_players_list();
$players = [];
foreach ($selected_players_list as $joueur)
{
    $players[] = $joueur['name'];
}

// Mélanger la liste de players de manière aléatoire
shuffle($players);

// Fonction pour former les équipes
function formerEquipes($players) {
    $teams = [];

    $players_number = count($players);
    $teams_of_2 = floor($players_number / 2);
    $teams_of_2_odd = $teams_of_2 % 2 == 0;
    $teams_of_3 = floor($players_number / 3);
    $teams_of_3_odd = $teams_of_3 % 2 == 0;
    
    // Tant qu'il y a des joueurs dans la liste
    while (!empty($players)) {
        // Si nb d'équipes de 2 possibles est pair et nb d'équipes de 3 possibles est pair
        // ou si nb d'équipes de 2 possibles est pair et nb d'équipes de 3 possibles est impair
        if (($teams_of_2_odd && $teams_of_3_odd) || ($teams_of_2_odd && !$teams_of_3_odd))
        {
            if (count($players) <= 3) {
                $team = array_splice($players, 0, 3);
            } else {
                $team = array_splice($players, 0, 2); // Sinon, prend les joueurs 2 par 2
            }
        }
        // Si nb d'équipes de 2 possibles est impair et nb d'équipes de 3 possibles est pair
        // ou si nb d'équipes de 2 possibles est impair et nb d'équipes de 3 possibles est impair
        elseif ((!$teams_of_2_odd && $teams_of_3_odd) || (!$teams_of_2_odd && !$teams_of_3_odd))
        {
            if (count($players) <= 9) {
                $team = array_splice($players, 0, 3);
            } else {
                $team = array_splice($players, 0, 2); // Sinon, prend les joueurs 2 par 2
            }
        }

        // Ajoute l'équipe formée à la liste des équipes
        $teams[] = $team;
    }
    
    return $teams;
}

// Afficher les équipes formées
foreach (formerEquipes($players) as $index => $equipe) {
    echo "Équipe " . ($index + 1) . " => [ " . implode(', ', $equipe) . " ]<br>";
}

?>
