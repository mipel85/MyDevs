<?php

function affiche_menu()
{
    $template = '';
    // tableaux contenant les liens d'accès et le texte à afficher
    $tab_menu_lien = array("home", "players", "selection", "game", "matches", "", "", "dev");
    $tab_menu_texte = array("Accueil", "Joueurs", "Sélection", "Partie", "Rencontres", "Scores", "Résultats", "dev");

    // informations sur la page
    $get = $_GET['page'];

    $menu = "\n<nav id=\"menu\">\n    <ul id=\"onglets\">\n";

    // boucle qui parcours les deux tableaux
    foreach ($tab_menu_lien as $cle => $lien)
    {
        $menu .= "    <li";

        // si le nom du fichier correspond à celui pointé par l'indice, alors on l'active
        if ($get == $lien){
            $menu .= " class=\"active\"";
        }

        $menu .= "><a href=\"index.php?page=" . $lien . "\">" . $tab_menu_texte[$cle] . "</a></li>\n";
    }
    $menu .= "</ul>\n</nav>";
    return $menu;
}
?>