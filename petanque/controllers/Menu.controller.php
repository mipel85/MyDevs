<?php

require_once('./classes/Members.class.php');
require_once('./classes/Days.class.php');
require_once('./classes/Rankings.class.php');

function display_menu()
{
    require_once ('./controllers/Days.controller.php');
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
    $day_id = Days::started_day() ? Days::day_id(date('d-m-Y')) : 0;
    $no_selected_members = count(Members::selected_members_list()) < 4 || count(Members::selected_members_list()) == 7;
    $no_day = !Days::started_day();
    $no_round = count(Rounds::day_rounds_list($day_id)) == 0;
    $no_score = count(Rankings::rankings_day_list($day_id)) == 0;
    
    $menu = '<nav id="menu"><ul id="main-menu">';

    // boucle qui parcours les deux tableaux
    foreach ($menu_links as $k => $link)
    {
        $day_items = in_array($link, ['day', 'scores', 'rankings']);
        $day_off_items = in_array($link, ['day', 'scores']);
        $class = '';
        $label = $menu_labels[$k];
        $menu .= '<li class="menu-item">';

        // si le nom du fichier correspond à celui pointé par l'indice, alors on l'active
        if ($get == $link)
            $class = ' active';

        // Si la partie n'est pas commencée
        if ($no_selected_members && $day_items) {
            $class = ' full-error';
            $link = 'members';
            $label = 'Aucun joueur sélectionné';
        }
        elseif ($no_day && $day_items) {
            $class = ' full-warning';
            if (in_array($link, ['scores', 'rankings'])) {
                $link = 'day';
                $label = 'Aucune journée créée';
            }
        }
        elseif ($no_round && $day_items) {
            if (in_array($link, ['scores', 'rankings'])) {
                $class = ' full-warning';
                $link = 'day';
                $label = 'Aucune partie créée';
            }
        }
        elseif ($no_score && $day_items) {
            if ($link == 'rankings') {
                $class = ' full-warning';
                $link = 'scores';
                $label = 'Aucun classement';
            }
        }
        elseif (Days::started_day() && !Days::day_flag($day_id) && $day_off_items) {
            $class = ' full-error';
            $link = 'rankings';
            $label = 'Journée terminée';
        }

        $menu .= '<a class="menu-item-title' . $class . '" href="index.php?page=' . $link . '"><i class="fa fa-fw fa-' . $menu_icons[$k] . '"></i> ' . $label . '</a></li>';
    }
    $menu .= "</ul></nav>";
    return $menu;
}
?>