<?php

function affiche_menu()
{
    // tableaux contenant les liens d'accès et le texte à afficher
    $menu_links = array("home", "selection", "party", 'ranking');
    $menu_labels = array("Accueil", "Choix des joueurs", "Demarrage", 'Classement');

    // informations sur la page
    $get = $_GET['page'];

    $menu = "\n<nav id=\"menu\">\n    <ul id=\"onglets\">\n";

    // boucle qui parcours les deux tableaux
    foreach ($menu_links as $k => $link)
    {
        $menu .= "    <li";

        // si le nom du fichier correspond à celui pointé par l'indice, alors on l'active
        if ($get == $link){
            $menu .= " class=\"active\"";
        }

        $menu .= "><a href=\"index.php?page=" . $link . "\">" . $menu_labels[$k] . "</a></li>\n";
    }
    $menu .= "</ul>\n</nav>";
    return $menu;
}
?>