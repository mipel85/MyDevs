<?php
    $title = 'Accueil';
    require_once('./classes/install.class.php');
    // automatic installation of database and tables
    install::create_database();
    install::create_players_table();
    install::insert_data_players();
    
    // header('Location: index.php?page=home');
    
    $page = $_GET['page'] ?? '404';

    // $url = $_SERVER['REQUEST_URI'];
    // $parse_url = parse_url($url);
    // if ($parse_url['query'] = '')
    //     $page = 'home';

    $title = '';
    switch($page)
    {
        case ('404') : $title = 'Erreur 404'; break;
        case ('config') : $title = 'Administration'; break;
        case ('selection') : $title = 'Sélection'; break;
        case ('partie') : $title = 'Partie'; break;
        case ('rencontre') : $title = 'Rencontres'; break;
        case ('dev') : $title = 'Dev'; break;
        default : $title = 'Accueil'; break;
    }

    require_once('./theme/templates/header.controller.php');
    
    switch($page)
    {
        case ('404') :
            require_once('./theme/templates/404.controller.php');
            break;
        case ('config') :
            require_once('./theme/templates/config.controller.php');
            break;
        case ('selection') :
            require_once('./theme/templates/selection.controller.php');
            break;
        case ('partie') :
            require_once('./theme/templates/partie.controller.php');
            break;
        case ('rencontres') :
            require_once('./theme/templates/partie.controller.php');
            break;
        case ('dev') :
            require_once('./theme/templates/dev.controller.php');
            break;
        default :
            require_once('./theme/templates/home.controller.php');
            break;
    }

    require_once('./theme/templates/footer.controller.php');
?>

