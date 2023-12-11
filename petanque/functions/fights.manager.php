<?php
require_once('../classes/Connection.class.php');
require_once('../classes/Teams.class.php');

// Liste des équipes
$selected_teams_list = Teams::round_teams_list($party_id, $round_id);
$teams = [];
foreach ($selected_teams_list as $team)
{
    $teams[] = $team['id'];
}

shuffle($teams);

function playground($playgrounds_number)
{
    $playgrounds_count = [];
    for ($i=1; $i <= $playgrounds_number; $i++ )
    {
        $playgrounds_count[] = $i;
    }

    return $playgrounds_count;
}

// Fonction pour créer le championnat
function build_fights($teams) {
    $calendar = [];
    $teams_number = count($teams);

    // Boucle sur chaque journée
    for ($day = 1; $day < $teams_number; $day++) {
        $calendar[$day] = [];

        // Boucle pour créer les matchs de la journée
        for ($i = 0; $i < $teams_number / 2; $i++) {
            $team1 = $teams[$i];
            $team2 = $teams[$teams_number - 1 - $i];

            $calendar[$day][] = [$team1, $team2];
        }

        // Rotation des équipes pour la prochaine journée
        $teamDebut = array_shift($teams);
        array_unshift($teams, array_pop($teams));
        array_unshift($teams, $teamDebut);
    }

    return $calendar;
}
?>
