<?php

use \App\controllers\Langs;
use \App\controllers\Menu;

foreach(Langs::get_lang_files() as $file) {
    include $file;
};

$startYear = '2023';
$currentDate = new DateTime();
$currentYear = $currentDate->format('Y');
if ($startYear == $currentYear) $year = $startYear;
else $year = $startYear . ' - ' . $currentYear;

?>
<!doctype html>
<html lang="<?= Langs::get_locale() ?>">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="./favicon.ico" />
        <link rel="stylesheet" href="./theme/css/default.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./theme/css/design.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./theme/css/content.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./theme/css/componants.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./theme/css/menu.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./theme/css/plugins.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./theme/css/font-awesome/css/all.css" type="text/css" media="screen, print" />
        <link rel="stylesheet" href="./theme/css/colors.css" type="text/css" media="screen, print" />
        <title><?= $title ?> - <?= $lang['site.name'] ?></title>
        
        <!-- plugins -->
        <script src="./theme/js/plugins/jquery.min.js"></script>
        <script src="./theme/js/plugins/expand.js"></script>
        <script src="./theme/js/plugins/tabs.js"></script>
        <script src="./theme/js/plugins/modal.js"></script>
        <script src="./theme/js/plugins/rowtocolumn.js"></script>
        <script src="./theme/js/plugins/reorderitems.js"></script>
        <!-- Ajax -->
        <script src="./theme/js/members.js"></script>
        <script src="./theme/js/players.js"></script>
        <script src="./theme/js/days.js"></script>
    </head>
    <body>
        <header id="top-header">
            <div id="logo" aria-label="<?= $lang['site.logo'] ?>"></div>
            <div id="site-name-container" class="flex-main">
                <div id="site-name" class="flex-main"><?= $lang['site.name'] ?></div>
                <div id="menu-container">
                    <a href="#menu-container" id="menu-trigger">Menu</a>
                    <a href="#" id="untrigger">X</a>
                    <?= Menu::display_menu(); ?>
                </div>
            </div>
            <div id="header-links">
                <a class="header-link" href="index.php?page=config"><i class="fa fa-cog"></i></a>
            </div>
        </header>
        <main>
            <?= $content ?>
        </main>
        <footer id="footer"><?= str_replace(':year', $year, $lang['footer']) ?></footer>
    </body>
</html>