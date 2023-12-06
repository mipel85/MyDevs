<?php

function affiche_menu()
{
    // tableaux contenant les liens d'accès et le texte à afficher
    $tab_menu_lien = array("index.php", "joueurs.php", "selection.php", "partie.php", "equipes.php", "", "", "dev.php");
    $tab_menu_texte = array("Accueil", "Joueurs", "Sélection", "Partie", "Equipes", "Scores", "Résultats", "dev");

    // informations sur la page
    $info = pathinfo($_SERVER['PHP_SELF']);

    $menu = "\n<nav id=\"menu\">\n    <ul id=\"onglets\">\n";

    // boucle qui parcours les deux tableaux
    foreach ($tab_menu_lien as $cle => $lien)
    {
        $menu .= "    <li";

        // si le nom du fichier correspond à celui pointé par l'indice, alors on l'active
        if ($info['basename'] == $lien){
            $menu .= " class=\"active\"";
        }

        $menu .= "><a href=\"" . $lien . "\">" . $tab_menu_texte[$cle] . "</a></li>\n";
    }
    $menu .= "</ul>\n</nav>";
    return $menu;
}
?>