<?php

require_once('./classes/Members.class.php');
require_once('./classes/Days.class.php');
require_once('./classes/Rounds.class.php');
require_once('./classes/Matches.class.php');
require_once('./classes/Players.class.php');
require_once('./classes/Rankings.class.php');
require_once('./lang/Langs.controller.php');

function display_menu()
{
    // Load language
    foreach (get_lang_files() as $path) { include($path); }

    // Current page from url
    $get = $_GET['page'];
    // Check if day is started
    $started_day = Days::started_day();
    // if day is started
    // set the current date
    $today = Days::today();
    $day_id = $started_day ? Days::day_id($today) : 0;
    $day_has_round = $started_day && count(Rounds::day_rounds_list($day_id)) > 0;
    $day_has_match = $started_day && $day_has_round && count(Matches::day_matches_list($day_id)) > 0;
    // List of selected members
    $selected_members_label = count(Members::selected_members_list()) > 1 ?
        str_replace(':number', count(Members::selected_members_list()), $lang['menu.sub.members']) :
        str_replace(':number', count(Members::selected_members_list()), $lang['menu.sub.member']);
    // Current running round
    $current_round_name = $day_has_round ? Rounds::current_round_name($day_id) : 0;
    $current_round_id = $day_has_round ? Rounds::current_round_id($day_id) : 0;
    $current_round_label = $current_round_name ?
        str_replace(':number', $current_round_name, $lang['menu.sub.current.round']) :
        $lang['menu.sub.no.rounds'];
    // Get matches number and played matches number for the current round
    $current_round_played_matches = $day_has_match ? count(Matches::round_played_matches_list($day_id, $current_round_id)) : 0;
    $played_label = str_replace(':number', $current_round_name, $lang['menu.sub.round']) . ($current_round_played_matches > 1 ?
        str_replace(':number', $current_round_played_matches, $lang['menu.sub.scores']) :
        str_replace(':number', $current_round_played_matches, $lang['menu.sub.score']));
    $current_matches_number = $day_has_match ? count(Matches::round_matches_list($day_id, $current_round_id)) : 0;
    // Get matches number and played matches number for the day
    $played_matches_number = $day_has_match ? count(Matches::played_matches_list($day_id)) : 0;
    $matches_number = $day_has_match ? count(Matches::day_matches_list($day_id)) : 0;
    $current_ranking_label = $played_matches_number ? 
        (count(Matches::played_matches_list($day_id)) > 1 ? 
            str_replace(':number', count(Matches::played_matches_list($day_id)), $lang['menu.sub.rankings']) :
            str_replace(':number', count(Matches::played_matches_list($day_id)), $lang['menu.sub.ranking'])) :
        $lang['menu.sub.no.rankings'];
    // warning labels
    $no_selected_members = count(Members::selected_members_list()) < 4 || count(Members::selected_members_list()) == 7;
    $no_day = !$started_day;
    $no_round = count(Rounds::day_rounds_list($day_id)) == 0;
    $no_score = count(Players::day_players_list($day_id)) == 0;
    $no_rank = Rankings::rankings_has_ranks($day_id) == 0;
    
    // Arrays of links, labels and icons for the nav menu
    $menu_links = [
        'home',
        'members',
        'day',
        'scores',
        'rankings'
    ];
    $menu_labels = [
        $lang['menu.home'],
        $lang['menu.members'],
        $lang['menu.rounds'],
        $lang['menu.scores'],
        $lang['menu.rankings']
    ];
    $menu_sublabels = [
        $today,
        $selected_members_label,
        $current_round_label,
        $played_label . ' / ' . $current_matches_number,
        $current_ranking_label . ' / ' . $matches_number
    ];
    $menu_icons = [
        'house',
        'user-check',
        'play',
        'divide fa-rotate-90',
        'list'
    ];

    $menu = '<nav id="menu"><ul id="main-menu">';

    foreach ($menu_links as $k => $link)
    {
        $day_items = in_array($link, ['day', 'scores', 'rankings']);
        $day_off_items = in_array($link, ['day', 'scores']);
        $class = '';
        $label = $menu_labels[$k];
        $sublabel = $menu_sublabels[$k];
        $menu .= '<li class="menu-item">';

        // Active the link corresponding to url
        if ($get == $link)
            $class = ' active';

        // Options on links
        if ($no_selected_members && $day_items) {
            $class = ' full-error';
            $link = 'members';
            $sublabel = $lang['menu.sub.no.members'];
        }
        elseif ($no_day && $day_items) {
            $class = ' full-warning';
            if ($link == 'day') {
                $class = ' full-warning';
                $sublabel = $lang['menu.sub.no.days'];
            }
            if (in_array($link, ['scores', 'rankings'])) {
                $class = ' full-error';
                $link = 'day';
                $sublabel = $lang['menu.sub.no.days'];
            }
        }
        elseif ($no_round && $day_items) {
            if ($link == 'day') {
                $class = ' full-warning';
                $sublabel = $lang['menu.sub.no.rounds'];
            }
            if (in_array($link, ['scores', 'rankings'])) {
                $class = ' full-error';
                $link = 'day';
                $sublabel = $lang['menu.sub.no.rounds'];
            }
        }
        elseif ($no_score && $day_items) {
            if ($link == 'rankings') {
                $class = ' full-error';
                $link = 'scores';
                $sublabel = $lang['menu.sub.no.scores'];
            }
        }
        elseif ($no_rank && $day_items) {
            if ($link == 'rankings') {
                $class = ' full-warning';
                $link = 'scores';
                $sublabel = $lang['menu.sub.no.rankings'];
            }
        }
        elseif ($started_day && !Days::day_flag($day_id) && $day_off_items) {
            $class = ' full-error';
            $link = 'rankings';
            $sublabel = $lang['menu.sub.end.day'];
        }

        $menu .= '<a class="menu-item-title' . $class . '" href="index.php?page=' . $link . '"><i class="fa fa-fw fa-' . $menu_icons[$k] . '"></i> ' . $label . '<span class="description">' . $sublabel . '</span></a></li>';
    }
    $menu .= "</ul></nav>";
    return $menu;
}
?>