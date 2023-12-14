<?php

require_once('./classes/Connection.class.php');

// require_once('./classes/Install.class.php');

// // automatic installation of database and tables
// install::create_database();
// install::create_members_table();
// install::insert_data_members();

$page = $_GET['page'] ?? '404';

$url = $_SERVER['REQUEST_URI'];
$url = explode('/', $url);
$url = end($url);
if ($url == '')
    $page = 'home';

$title = '';
switch($page)
{
    case ('config') : $title = 'Administration'; break;
    case ('players') : $title = 'Sélection des joueurs'; break;
    case ('day') : $title = 'Partie'; break;
    case ('scores') : $title = 'Scores'; break;
    case ('ranking') : $title = 'Classement'; break;
    default : $title = 'Accueil'; break;
}

require_once('./theme/templates/Header.view.php');

switch($page)
{
    case ('config') :
        require_once('./theme/templates/config/Config.view.php');
        break;
    case ('home') :
        require_once('./theme/templates/Home.view.php');
        break;
    case ('players') :
        require_once('./theme/templates/Players.view.php');
        break;
    case ('day') :
        require_once('./theme/templates/Day.view.php');
        break;
    case ('scores') :
        require_once('./theme/templates/Scores.view.php');
        break;
    case ('ranking') :
        require_once('./theme/templates/Ranking.view.php');
        break;
    default :
        require_once('./theme/templates/404.view.php');
        break;
}

require_once('./theme/templates/Footer.view.php');
?>