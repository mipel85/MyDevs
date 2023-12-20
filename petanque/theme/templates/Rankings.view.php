<?php

require_once('./classes/Rounds.class.php');
require_once('./classes/Teams.class.php');
require_once('./classes/Matches.class.php');
require_once('./classes/Rankings.class.php');
require_once('./controllers/Days.controller.php');
require_once('./controllers/Rankings.controller.php');
?>
<section>
    <header class="section-header"><h1>Classement</h1></header>
    <div class="tabs-container">
        <div class="tabs-menu flex-between">
            <div class="tabs-menu-left">
                <span data-trigger="ranking-day" class="tab-trigger active-tab" onclick="openTab(event, 'ranking-day');">Classement du jour</span>
                <span data-trigger="ranking-month" class="tab-trigger" onclick="openTab(event, 'ranking-month');">Classement du mois</span>
                <span data-trigger="overall" class="tab-trigger" onclick="openTab(event, 'overall');">Classement complet</span>
            </div>
            <div class="tabs-menu-right">
                <span data-trigger="doc" class="tab-trigger" onclick="openTab(event, 'doc');"></span>
            </div>
        </div>
        <article id="ranking-day" class="tab-content active-tab">
            <table class="table rankings-table">
                <thead>
                    <tr>
                        <th>Pl</th>
                        <th class="player-name">Nom</th>
                        <th>J</th>
                        <th>V</th>
                        <th>D</th>
                        <th>Pv</th>
                        <th>Pd</th>
                        <th>Diff</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (Rankings::rankings_day_list($day_id) as $index => $player): ?>
                        <?php $diff = $player['pos_points'] + $player['neg_points'] ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td class="player-name"><?= $player['member_name'] ?></td>
                            <td><?= $player['played'] ?></td>
                            <td><?= $player['victory'] ?></td>
                            <td><?= $player['loss'] ?></td>
                            <td><?= $player['pos_points'] ?></td>
                            <td><?= $player['neg_points'] ?></td>
                            <td><?= $diff ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </article>
        <article id="ranking-month" class="tab-content cell-flex cell-columns-2">
            <table class="table rankings-table">
                <thead>
                    <tr>
                        <th>Pl</th>
                        <th class="player-name">Nom</th>
                        <th>J</th>
                        <th>V</th>
                        <th>D</th>
                        <th>Pv</th>
                        <th>Pd</th>
                        <th>Diff</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (Rankings::rankings_month_list() as $index => $player): ?>
                        <?php $diff = $player['pos_points'] + $player['neg_points'] ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td class="player-name"><?= $player['member_name'] ?></td>
                            <td><?= $player['played'] ?></td>
                            <td><?= $player['victory'] ?></td>
                            <td><?= $player['loss'] ?></td>
                            <td><?= $player['pos_points'] ?></td>
                            <td><?= $player['neg_points'] ?></td>
                            <td><?= $diff ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </article>
        <article id="overall" class="tab-content">
            <table class="table rankings-table">
                <thead>
                    <tr>
                        <th>Pl</th>
                        <th class="player-name">Nom</th>
                        <th>J</th>
                        <th>V</th>
                        <th>D</th>
                        <th>Pv</th>
                        <th>Pd</th>
                        <th>Diff</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (Rankings::rankings_overall_list() as $index => $player): ?>
                        <?php $diff = $player['pos_points'] + $player['neg_points'] ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td class="player-name"><?= $player['member_name'] ?></td>
                            <td><?= $player['played'] ?></td>
                            <td><?= $player['victory'] ?></td>
                            <td><?= $player['loss'] ?></td>
                            <td><?= $player['pos_points'] ?></td>
                            <td><?= $player['neg_points'] ?></td>
                            <td><?= $diff ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </article>
        <article id="doc" class="tab-content">
            
        </article>
    </div>
    <footer></footer>
</section>