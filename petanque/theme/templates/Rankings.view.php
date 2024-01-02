<?php

use \App\controllers\InitDays;
use \App\items\Days;
use \App\items\Rankings;

$day_id = InitDays::day_id();
$day_flag = InitDays::day_flag();
$class_day_flag = $day_flag ? ' full-error' : ' full-warning';
$label_day_flag = $day_flag ? $lang['rankings.days.close'] : $lang['rankings.days.reopen'];
?>
<section>
    <header class="section-header flex-between-center">
            <h1><?= $lang['rankings.title'] ?></h1>
            <div>
                <button id="day-flag" data-day_id="<?= $day_id ?>" data-day_flag="<?= $day_flag ?>" class="button<?= $class_day_flag ?>"><?= $label_day_flag ?></button>
            </div>
    </header>
    <article id="ranking-day">
        <?php if (Days::started_day()): ?>
            <table class="table rankings-table">
                <thead>
                    <tr>
                        <th><?= $lang['rankings.place'] ?></th>
                        <th class="player-name"><?= $lang['rankings.name'] ?></th>
                        <th><?= $lang['rankings.played'] ?></th>
                        <th><?= $lang['rankings.victory'] ?></th>
                        <th><?= $lang['rankings.loss'] ?></th>
                        <th><?= $lang['rankings.points.for'] ?></th>
                        <th><?= $lang['rankings.points.against'] ?></th>
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
            <div class="message-helper full-notice"><?= $lang['rankings.no.days'] ?></div>
        <?php endif ?>
    </article>
    <footer></footer>
</section>