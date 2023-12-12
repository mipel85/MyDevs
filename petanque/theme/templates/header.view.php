<?php

require_once('./functions/menu.manager.php');
$menu = display_menu();

?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="./favicon.ico" />
        <link rel="stylesheet" href="./theme/js/lib/FixedHeader-3.4.0/css/fixedHeader.dataTables.min.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./theme/js/lib/datatables.min.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./theme/css/default.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./theme/css/design.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./theme/css/componants.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./theme/css/menu.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./theme/css/tabs.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" type="text/css" media="screen, print" />
        <title><?= $title ?> - Pétanque Loisirs Sainte-Foy</title>
        
        <script src="./theme/js/lib/jquery-3.7.1.min.js"></script>
        <script src="./theme/js/lib/datatables.min.js"></script>
        <script src="./theme/js/lib/Buttons-2.4.2/js/buttons.dataTables.min.js"></script>
        <script src="./theme/js/lib/FixedHeader-3.4.0/js/fixedHeader.dataTables.min.js"></script>
        <script src="./theme/js/members.js"></script>
        <script src="./theme/js/players.js"></script>
        <script src="./theme/js/parties.js"></script>
        <script src="./theme/js/expand.js"></script>
        <script src="./theme/js/tabs.js"></script>
    </head>
    <body>
        <header id="top-header">
            <div id="logo"></div>
            <div id="site-name">Pétanque Loisirs Sainte-Foy</div>
            <div>
                <a href="index.php?page=config"><i class="fa fa-cog"></i></a>
            </div>
        </header>
        <main>
            <div id="menu-container">
                <a href="#menu-container" id="menu-trigger">Menu</a>
                <a href="#" id="untrigger">X</a>
                <?= $menu; ?>
            </div>