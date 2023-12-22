<?php

require_once('./classes/Members.class.php');
require_once('./classes/Days.class.php');
require_once('./classes/Rounds.class.php');
require_once('./classes/Matches.class.php');
require_once('./classes/Players.class.php');
require_once('./classes/Rankings.class.php');

function display_menu()
{
    // informations sur la page
    $get = $_GET['page'];
    $started_day = Days::started_day();
    $day_id = $started_day ? Days::day_id(date('d-m-Y')) : 0;
    
    $selected_members = count(Members::selected_members_list()) > 1 ? 
        count(Members::selected_members_list()) . ' joueurs sélectionnés' : 
        count(Members::selected_members_list()) . ' joueur sélectionné';
    $current_round = $started_day ? 'Partie ' . count(Rounds::day_rounds_list($day_id)) . ' en cours' : 'Aucune partie en cours';
    $current_ranking = $started_day ? 
        'Après ' . (count(Rounds::day_rounds_list($day_id)) > 1 ? 
            count(Rounds::day_rounds_list($day_id)) . ' parties' :  
            count(Rounds::day_rounds_list($day_id)) . ' partie') : 
        'Aucune partie en cours';

    $no_selected_members = count(Members::selected_members_list()) < 4 || count(Members::selected_members_list()) == 7;
    $no_day = !$started_day;
    $no_round = count(Rounds::day_rounds_list($day_id)) == 0;
    $no_score = count(Players::players_list()) == 0;
    $no_rank = Rankings::rankings_has_ranks($day_id) == 0;
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
    $menu_sublabels = [
        date('d-m-Y'),
        $selected_members,
        $current_round,
        'Saisie des <strong>Scores</strong>',
        $current_ranking
    ];
    $menu_icons = [
        'house',
        'user-check',
        'play',
        'divide fa-rotate-90',
        'list'
    ];
    
    $menu = '<nav id="menu"><ul id="main-menu">';

    // boucle qui parcours les deux tableaux
    foreach ($menu_links as $k => $link)
    {
        $day_items = in_array($link, ['day', 'scores', 'rankings']);
        $day_off_items = in_array($link, ['day', 'scores']);
        $class = '';
        $label = $menu_labels[$k];
        $sublabel = $menu_sublabels[$k];
        $menu .= '<li class="menu-item">';

        // si le nom du fichier correspond à celui pointé par l'indice, alors on l'active
        if ($get == $link)
            $class = ' active';

        // Si la partie n'est pas commencée
        if ($no_selected_members && $day_items) {
            $class = ' full-error';
            $link = 'members';
            $sublabel = 'Aucun joueur sélectionné';
        }
        elseif ($no_day && $day_items) {
            $class = ' full-warning';
            if ($link == 'day') {
                $class = ' full-warning';
                $sublabel = 'Aucune journée créée';
            }
            if (in_array($link, ['scores', 'rankings'])) {
                $class = ' full-error';
                $link = 'day';
                $sublabel = 'Aucune journée créée';
            }
        }
        elseif ($no_round && $day_items) {
            if (in_array($link, ['scores', 'rankings'])) {
                $class = ' full-error';
                $link = 'day';
                $sublabel = 'Aucune partie créée';
            }
        }
        elseif ($no_score && $day_items) {
            if ($link == 'rankings') {
                $class = ' full-error';
                $link = 'scores';
                $sublabel = 'Aucun score';
            }
        }
        elseif ($no_rank && $day_items) {
            if ($link == 'rankings') {
                $class = ' full-warning';
                $link = 'scores';
                $sublabel = 'Aucun classement';
            }
        }
        elseif ($started_day && !Days::day_flag($day_id) && $day_off_items) {
            $class = ' full-error';
            $link = 'rankings';
            $sublabel = 'Journée terminée';
        }

        $menu .= '<a class="menu-item-title' . $class . '" href="index.php?page=' . $link . '"><i class="fa fa-fw fa-' . $menu_icons[$k] . '"></i> ' . $label . '<span class="description">' . $sublabel . '</span></a></li>';
    }
    $menu .= "</ul></nav>";
    return $menu;
}
?>