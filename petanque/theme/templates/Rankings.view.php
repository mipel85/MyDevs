<?php

require_once('./classes/Rounds.class.php');
require_once('./classes/Teams.class.php');
require_once('./classes/Matches.class.php');
require_once('./classes/Rankings.class.php');
require_once('./controllers/Days.controller.php');

$class_day_flag = $day_flag ? ' full-error' : ' full-warning';
$label_day_flag = $day_flag ? 'Terminer la journée' : 'Réouvrir la journée';
?>
<section>
    <header class="section-header flex-between-center">
            <h1>Classement</h1>
            <div>
                <button id="day-flag" data-day_id="<?= $day_id ?>" data-day_flag="<?= $day_flag ?>" class="button<?= $class_day_flag ?>"><?= $label_day_flag ?></button>
            </div>
    </header>
    <article id="ranking-day">
        <?php if ($c_started_day): ?>
            <table class="table rankings-table">
                <thead>
                    <tr>
                        <th>Place</th>
                        <th class="player-name">Nom</th>
                        <th>Joués</th>
                        <th>Victoires</th>
                        <th>Défaites</th>
                        <th>Points pour</th>
                        <th>Points contre</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (Rankings::rankings_day_list($day_id) as $index => $player): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td class="player-name" id="<?= $player['member_id'] ?>"><?= $player['member_name'] ?></td>
                            <td><?= $player['played'] ?></td>
                            <td><?= $player['victory'] ?></td>
                            <td><?= $player['loss'] ?></td>
                            <td><?= $player['pos_points'] ?></td>
                            <td><?= $player['neg_points'] ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="message-helper full-notice">Aucune journée créée.</div>
        <?php endif ?>
    </article>
    <footer></footer>
</section>