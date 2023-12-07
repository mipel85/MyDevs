<?php

    require_once('./classes/install.class.php');
    // automatic installation of database and tables
    install::create_database();
    install::create_players_table();
    install::insert_data_players();

    $page = $_GET['page'] ?? '404';

    $title = '';
    switch($page)
    {
        case ('config') : $title = 'Administration'; break;
        case ('selection') : $title = 'Sélection'; break;
        case ('party') : $title = 'Partie'; break;
        case ('ranking') : $title = 'Classement'; break;
        default : $title = 'Accueil'; break;
    }

    require_once('./theme/templates/header.controller.php');

    switch($page)
    {
        case ('config') :
            require_once('./theme/templates/config.controller.php');
            break;
        case ('selection') :
            require_once('./theme/templates/selection.controller.php');
            break;
        case ('party') :
            require_once('./theme/templates/party.controller.php');
            break;
        case ('ranking') :
            require_once('./theme/templates/ranking.controller.php');
            break;
        default :
            require_once('./theme/templates/home.controller.php');
            break;
    }

    require_once('./theme/templates/footer.controller.php');
?>

