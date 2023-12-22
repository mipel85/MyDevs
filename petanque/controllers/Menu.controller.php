<?php

require_once('./classes/Members.class.php');
require_once('./classes/Days.class.php');

function display_menu()
{
    // tableaux contenant les liens d'accès et le texte à afficher
    $menu_links = [
        'home',
        'members',
        'day',
        'scores',
        'rankings'
    ];
    $menu_labels = [
        'Accueil',
        '<strong>Joueurs</strong> présents',
        'Gestion des <strong>Parties</strong>',
        'Saisie des <strong>Scores</strong>',
        'Classement'
    ];
    $menu_icons = [
        'house',
        'user-check',
        'play',
        'divide fa-rotate-90',
        'list'
    ];

    // informations sur la page
    $get = $_GET['page'];
    $no_selected_members = count(Members::selected_members_list()) < 4 || count(Members::selected_members_list()) == 7;
    
    $menu = '<nav id="menu"><ul id="main-menu">';

    // boucle qui parcours les deux tableaux
    foreach ($menu_links as $k => $link)
    {
        $day_items = in_array($link, ['day', 'scores', 'rankings']);
        $day_off_items = in_array($link, ['day', 'scores']);
        $class = '';
        $menu .= '<li class="menu-item">';

        // si le nom du fichier correspond à celui pointé par l'indice, alors on l'active
        if ($get == $link)
            $class = ' active';

        // Si la partie n'est pas commencée
        if ($no_selected_members && $day_items) {
            $class = ' full-error';
            $link = 'members';
        }
        elseif (!Days::started_day() && $day_items) {
            $class = ' full-warning';
            if (in_array($link, ['scores', 'rankings']))
                $link = 'day';
        }
        elseif (Days::started_day() && !Days::day_flag(Days::day_id(date('d-m-Y'))) && $day_off_items) {
            $class = ' full-error';
            $link = 'rankings';
        }

        $menu .= '<a class="menu-item-title' . $class . '" href="index.php?page=' . $link . '"><i class="fa fa-fw fa-' . $menu_icons[$k] . '"></i> ' . $menu_labels[$k] . '</a></li>';
    }
    $menu .= "</ul></nav>";
    return $menu;
}
?>