<?php

// Liste de joueurs présents
$liste = Joueurs::liste_joueurs_presents();
$joueurs = [];
foreach ($liste as $joueur)
{
    $joueurs[] = $joueur['nom'];
}

// Mélanger la liste de joueurs de manière aléatoire
shuffle($joueurs);

// Fonction pour former les équipes
function formerEquipes($joueurs) {
    $equipes = [];

    $nbJoueurs = count($joueurs);
    $equipeDe2 = floor($nbJoueurs / 2);
    $equipeDe2Pair = $equipeDe2 % 2 == 0;
    $equipeDe3 = floor($nbJoueurs / 3);
    $equipeDe3Pair = $equipeDe3 % 2 == 0;
    
    // Tant qu'il y a des joueurs dans la liste
    while (!empty($joueurs)) {
        // Si nb d'équipes de 2 possibles est pair et nb d'équipes de 3 possibles est pair
        // ou si nb d'équipes de 2 possibles est pair et nb d'équipes de 3 possibles est impair
        if (($equipeDe2Pair && $equipeDe3Pair) || ($equipeDe2Pair && !$equipeDe3Pair))
        {
            if (count($joueurs) <= 3) {
                $equipe = array_splice($joueurs, 0, 3);
            } else {
                $equipe = array_splice($joueurs, 0, 2); // Sinon, prend les joueurs 2 par 2
            }
        }
        // Si nb d'équipes de 2 possibles est impair et nb d'équipes de 3 possibles est pair
        // ou si nb d'équipes de 2 possibles est impair et nb d'équipes de 3 possibles est impair
        elseif ((!$equipeDe2Pair && $equipeDe3Pair) || (!$equipeDe2Pair && !$equipeDe3Pair))
        {
            if (count($joueurs) <= 9) {
                $equipe = array_splice($joueurs, 0, 3);
            } else {
                $equipe = array_splice($joueurs, 0, 2); // Sinon, prend les joueurs 2 par 2
            }
        }

        // Ajoute l'équipe formée à la liste des équipes
        $equipes[] = $equipe;
    }
    
    return $equipes;
}

if (count($joueurs) < 4)
    echo 'Pas assez de joueurs pour lancer une partie';
else {
    // Former les équipes
    $equipes = formerEquipes($joueurs);

    // Afficher les équipes formées
    foreach ($equipes as $index => $equipe) {
        echo "Équipe " . ($index + 1) . " => [ " . implode(', ', $equipe) . " ]<br>";
    }
}
?>
