<?php
require_once('../classes/Connection.class.php');
require_once('../classes/Teams.class.php');
require_once('../classes/Members.class.php');

// Liste de joueurs présents
$selected_members_list = Members::present_members_list();
$members = [];
foreach ($selected_members_list as $member)
{
    $members[] = $member['id'].':'.$member['name'];
}

// Mélanger la liste de members de manière aléatoire
shuffle($members);

// Fonction pour former les équipes
function build_teams($members) {
    $teams = [];

    $players_number = count($members);
    $teams_of_2 = floor($players_number / 2);
    $teams_of_2_even = $teams_of_2 % 2 == 0;
    $teams_of_3 = floor($players_number / 3);
    $teams_of_3_even = $teams_of_3 % 2 == 0;
    
    // Tant qu'il y a des joueurs dans la liste
    while (!empty($members)) {
        // Si nb d'équipes de 2 possibles est pair et nb d'équipes de 3 possibles est pair
        // ou si nb d'équipes de 2 possibles est pair et nb d'équipes de 3 possibles est impair
        if (($teams_of_2_even && $teams_of_3_even) || ($teams_of_2_even && !$teams_of_3_even))
        {
            if (count($members) <= 3) {
                $team = array_splice($members, 0, 3);
            } else {
                $team = array_splice($members, 0, 2); // Sinon, prend les joueurs 2 par 2
            }
        }
        // Si nb d'équipes de 2 possibles est impair et nb d'équipes de 3 possibles est pair
        // ou si nb d'équipes de 2 possibles est impair et nb d'équipes de 3 possibles est impair
        elseif ((!$teams_of_2_even && $teams_of_3_even) || (!$teams_of_2_even && !$teams_of_3_even))
        {
            if (count($members) <= 9) {
                $team = array_splice($members, 0, 3);
            } else {
                $team = array_splice($members, 0, 2); // Sinon, prend les joueurs 2 par 2
            }
        }

        // Ajoute l'équipe formée à la liste des équipes
        $teams[] = $team;
    }
    
    return $teams;
}

foreach (build_teams($members) as $index => $equipe) {
    var_dump($equipe);
    echo "Équipe " . ($index + 1) . " => [ " . implode(', ', $equipe) . " ]<br>";
}

?>
