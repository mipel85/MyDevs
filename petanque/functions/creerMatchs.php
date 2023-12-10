<?php
require_once('../classes/Connection.class.php');
require_once('../classes/Teams.class.php');

$party_id = '53';
$round_id = '37';

// Liste des équipes
$selected_teams_list = Teams::round_teams_list($party_id, $round_id);
$teams = [];
foreach ($selected_teams_list as $team)
{
    $teams[] = $team['id'];
}

shuffle($teams);

// Fonction pour créer le championnat
// Fonction pour créer le championnat
function build_fights($teams) {
    $calendar = [];
    $teams_number = count($teams);

    // Assure que le nombre d'équipes est pair
    if ($teams_number % 2 != 0) {
        array_push($teams, '<strong>Exempte</strong>');
        $teams_number++;
    }

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

// Créer le champ
$champ = build_fights($teams);
shuffle($champ);
// var_dump($champ);

$first = true;
// Afficher le calendar
foreach ($champ as $day => $matches) {
    if ($first) {
        foreach ($matches as $id => $teams) {
            $id = $id+1;
            echo "Rencontre ".$id." : " . $teams[0] . " vs " . $teams[1] . "<br />";
        }
        echo "<br>";
        $first = false;
    }
}
?>
