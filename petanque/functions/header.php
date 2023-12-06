<?php
require_once('./classes/connexion.class.php');
require_once('./classes/install.class.php');
require_once('./functions/menu.php');
require_once('./classes/joueurs.class.php');
$menu = affiche_menu();
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="./theme/images/favicon.ico" />
        <link rel="stylesheet" href="./js/lib/FixedHeader-3.4.0/css/fixedHeader.dataTables.min.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./js/lib/datatables.min.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./theme/css/default.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./theme/css/design.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./theme/css/componants.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./theme/css/menu.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./theme/css/tabs.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" type="text/css" media="screen, print" />
        <title><?php echo $title ?> - Pétanque Loisir Sainte-Foy</title>
        
        <script src="./js/lib/jquery-3.7.1.min.js"></script>
        <script src="./js/lib/datatables.min.js"></script>
        <script src="./js/lib/Buttons-2.4.2/js/buttons.dataTables.min.js"></script>
        <script src="./js/lib/FixedHeader-3.4.0/js/fixedHeader.dataTables.min.js"></script>
        <script src="./js/joueurs.js"></script>
        <script src="./js/select_presents.js"></script>
        <script src="./js/partie.js"></script>
        <script src="./js/tabs.js"></script>
    </head>
    <body>
        <header id="top-header">
            <div id="logo"></div>
            <div id="site-name">Pétanque Loisir Sainte-Foy</div>
            <div><a href="config.php"><i class="fa fa-cog"></i></a></div>
        </header>
        <main>
            <div id="menu-container">
                <a href="#menu-container" id="menu-trigger">Menu</a>
                <a href="#" id="untrigger">X</a>
                <?php  echo $menu; ?>
            </div>