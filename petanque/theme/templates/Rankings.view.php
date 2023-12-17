<?php

include './classes/Rounds.class.php';
include './classes/Teams.class.php';
include './classes/Matches.class.php';
include './classes/Rankings.class.php';
include './controllers/Days.controller.php';
include './controllers/Rankings.controller.php';
?>
<section>
    <header class="section-header"><h1>Classement</h1></header>
    <article class="content">
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
                <?php foreach (Rankings::rankings_list($day_id) as $index => $player): ?>
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
    <footer></footer>
</section>