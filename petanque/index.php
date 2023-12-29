<?php

if (file_exists('./classes/ConnectionConfig.class.php')) {
    $page = $_GET['page'] ?? '404';

    $url = $_SERVER['REQUEST_URI'];
    $url = explode('/', $url);
    $url = end($url);
    if ($url == '' || $url == 'index.php')
        $page = 'home';

    $title = '';
    switch($page)
    {
        case ('home')     : $title = 'Accueil'; break;
        case ('config')   : $title = 'Configuration'; break;
        case ('members')  : $title = 'Sélection des joueurs'; break;
        case ('day')      : $title = 'Partie'; break;
        case ('scores')   : $title = 'Scores'; break;
        case ('rankings') : $title = 'Classement'; break;
        default           : $title = 'Erreur 404';
    }

    require_once('./theme/templates/Header.view.php');

    switch($page)
    {
        case ('config')   : require_once('./theme/templates/config/Config.view.php'); break;
        case ('home')     : require_once('./theme/templates/Home.view.php'); break;
        case ('members')  : require_once('./theme/templates/Members.view.php'); break;
        case ('day')      : require_once('./theme/templates/Day.view.php'); break;
        case ('scores')   : require_once('./theme/templates/Scores.view.php'); break;
        case ('rankings') : require_once('./theme/templates/Rankings.view.php'); break;
        default           : require_once('./theme/templates/404.view.php');
    }

    require_once('./theme/templates/Footer.view.php');
}
else {
    // redirect to install
    header('Location: ./install/');
}


?>