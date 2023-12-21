<?php

require_once('./classes/Days.class.php');
require_once('./classes/Rounds.class.php');
require_once('./classes/Members.class.php');
require_once('./controllers/Days.controller.php');
require_once('./controllers/Menu.controller.php');
$menu = display_menu();

?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="./favicon.ico" />
        <link rel="stylesheet" href="./theme/css/default.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./theme/css/design.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./theme/css/componants.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./theme/css/menu.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./theme/css/plugins.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./theme/css/font-awesome/css/all.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./theme/css/colors.css" type="text/css" media="screen, print" />
        <title><?= $title ?> - Pétanque Loisirs Sainte-Foy</title>
        
        <!-- plugins -->
        <script src="./theme/js//plugins/jquery.min.js"></script>
        <script src="./theme/js/plugins/expand.js"></script>
        <script src="./theme/js/plugins/tabs.js"></script>
        <script src="./theme/js/plugins/modal.js"></script>
        <script src="./theme/js/plugins/rowtocolumn.js"></script>
        <script src="./theme/js/plugins/reorderfields.js"></script>
        <!-- Ajax -->
        <script src="./theme/js/members.js"></script>
        <script src="./theme/js/players.js"></script>
        <script src="./theme/js/days.js"></script>
    </head>
    <body>
        <div class="waiting-overlay hidden">
            <div class="waiting"><i class="fas fa-4x fa-spinner fa-pulse"></i></div>
        </div>
        <header id="top-header">
            <div id="logo"></div>
            <div id="site-name-container" class="flex-main">
                <div id="site-name">Pétanque Loisirs Sainte-Foy</div>
                <div class="site-name-infos flex-main">
                    <span><?= date('d-m-Y') ?></span>
                    <?php if ($c_started_day): ?>
                        <div>
                            <?php if (count(Rounds::day_rounds_list($day_id)) > 0): ?>
                                Partie <?= count(Rounds::day_rounds_list($day_id)) ?> en cours
                            <?php else: ?>
                                Aucune partie en cours
                            <?php endif ?>
                        </div>
                    <?php endif ?>
                </div>
                <div id="menu-container">
                    <a href="#menu-container" id="menu-trigger">Menu</a>
                    <a href="#" id="untrigger">X</a>
                    <?= $menu; ?>
                </div>
            </div>
            <div id="header-links">
                <a href="index.php?page=config"><i class="fa fa-cog"></i></a>
            </div>
        </header>
        <main>