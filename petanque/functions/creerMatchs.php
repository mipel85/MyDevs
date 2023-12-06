<?php

// Liste d'équipes (exemple)
$equipes = ['Equipe 1', 'Equipe 2', 'Equipe 3', 'Equipe 4', 'Equipe 5', 'Equipe 6', 'Equipe 7', 'Equipe 8', 'Equipe 9', 'Equipe 10'];

// Fonction pour créer le championnat
function creerChampionnat($equipes) {
    $calendrier = [];
    $nombreEquipes = count($equipes);

    // Assure que le nombre d'équipes est pair
    if ($nombreEquipes % 2 != 0) {
        array_push($equipes, '<strong>Exempte</strong>');
        $nombreEquipes++;
    }

    // Boucle sur chaque journée
    for ($journee = 1; $journee < $nombreEquipes; $journee++) {
        $calendrier[$journee] = [];

        // Boucle pour créer les matchs de la journée
        for ($i = 0; $i < $nombreEquipes / 2; $i++) {
            $equipe1 = $equipes[$i];
            $equipe2 = $equipes[$nombreEquipes - 1 - $i];

            $calendrier[$journee][] = [$equipe1, $equipe2];
        }

        // Rotation des équipes pour la prochaine journée
        $equipeDebut = array_shift($equipes);
        array_unshift($equipes, array_pop($equipes));
        array_unshift($equipes, $equipeDebut);
    }

    return $calendrier;
}

// Créer le championnat
$championnat = creerChampionnat($equipes);
shuffle($championnat);

// Afficher le calendrier
foreach ($championnat as $journee => $matches) {
    echo "Rencontres " . $journee + 1 . ": <br />";
    foreach ($matches as $id => $equipes) {
        $id = $id+1;
        echo "Rencontre ".$id." : " . $equipes[0] . " vs " . $equipes[1] . "<br />";
    }
    echo "<br>";
    exit();
}
?>
