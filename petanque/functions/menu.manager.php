<?php


function display_menu()
{
    // tableaux contenant les liens d'accès et le texte à afficher
    $menu_links = array('home', 'members', 'party', 'scores', 'ranking');
    $menu_labels = array('Accueil', 'Sélection<br />des membres', 'Gestion de<br />la partie', 'Gestion des<br />scores', 'Classement');
    $menu_icons = array('house', 'user-check', 'play', 'divide fa-rotate-90', 'list');

    // informations sur la page
    $get = $_GET['page'];

    $menu = '<nav id="menu"><ul id="onglets">';

    // boucle qui parcours les deux tableaux
    foreach ($menu_links as $k => $link)
    {
        $menu .= '    <li class="menu-item';

        // si le nom du fichier correspond à celui pointé par l'indice, alors on l'active
        if ($get == $link){
            $menu .= ' active';
        }

        $menu .= '"><a href="index.php?page=' . $link . '"><i class="fa fa-fw fa-' . $menu_icons[$k] . '"></i><br />' . $menu_labels[$k] . '</a></li>';
    }
    $menu .= "</ul></nav>";
    return $menu;
}
?>