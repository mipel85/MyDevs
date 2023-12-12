<?php

require_once('./classes/Members.class.php');
require_once('./classes/Parties.class.php');

function display_menu()
{
    // tableaux contenant les liens d'accès et le texte à afficher
    $menu_links = array('home', 'members', 'party', 'scores', 'ranking');
    $menu_labels = array('Accueil', 'Sélection<br />des membres', 'Gestion de<br />la partie', 'Gestion des<br />scores', 'Classement');
    $menu_icons = array('house', 'user-check', 'play', 'divide fa-rotate-90', 'list');

    // informations sur la page
    $get = $_GET['page'];
    $no_selected_members = count(Members::selected_members_list()) < 4 || count(Members::selected_members_list()) == 7;
    
    $menu = '<nav id="menu"><ul id="onglets">';

    // boucle qui parcours les deux tableaux
    foreach ($menu_links as $k => $link)
    {
        $party_items = in_array($link, ['party', 'scores', 'ranking']);
        $menu .= '    <li class="menu-item';

        // si le nom du fichier correspond à celui pointé par l'indice, alors on l'active
        if ($get == $link)
            $menu .= ' active';

        // Si la partie n'est pas commencée
        if ($no_selected_members && $party_items) {
            $menu .= ' bgc-full error';
            $link = 'members';
        }
        elseif (!Parties::party_started() && $party_items) {
            $menu .= ' bgc-full warning';
            if (in_array($link, ['scores', 'ranking']))
                $link = 'party';
        }

        $menu .= '"><a href="index.php?page=' . $link . '"><i class="fa fa-fw fa-' . $menu_icons[$k] . '"></i><br />' . $menu_labels[$k] . '</a></li>';
    }
    $menu .= "</ul></nav>";
    return $menu;
}
?>