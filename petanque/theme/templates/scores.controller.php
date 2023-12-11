<?php

require_once('./classes/Connection.class.php');
require_once('./classes/Players.class.php');
require_once('./classes/Parties.class.php');
require_once('./classes/Rounds.class.php');
require_once('./classes/Teams.class.php');
require_once('./classes/Fights.class.php');
require_once('./functions/party.manager.php');

?>
<section>
    <header class="section-header flex-between-center">
        <h1>Scores</h1>
        <span><button id="submit-scores" type="submit" class="button">Valider les scores</button></span>
        <?php if($party_id): ?><span class="description"><?= end($date) ?></span><?php endif ?>
    </header>
    <?php if($party_id): ?>
        <article id="rounds-list">
            <?php if($c_rounds): ?>
                <?php $party_round_list = array_reverse(Rounds::party_rounds_list($party_id)); ?>
                <div class="cell-flex cell-columns-2">
                    <?php foreach($party_round_list as $round): ?>
                        <?php $round_id = $round['id']; ?>
                        <div id="fights-list-<?= $round_id ?>"
                                data-party_id="<?= $party_id ?>"
                                data-round_id="<?= $round_id ?>">
                            <header class="flex-between">
                                <h3>Manche <?= $round['i_order'] ?></h3>
                            </header>
                            <table id="fight-list-round-<?= $round_id ?>" class="table">
                                <thead>
                                    <tr>
                                        <th>Équipe A</th>
                                        <th class="set-scores">Score A</th>
                                        <th class="set-scores">Score B</th>
                                        <th>Équipe B</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (Fights::round_fights_list($party_id, $round_id) as $index => $fight): ?>
                                        <tr id="fights-score-<?= $fight['id'] ?>"
                                                data-fight_id="<?= $fight['id'] ?>">
                                            <td>
                                                <div class="flex-between-center">
                                                    <span><?= $fight['team_1_id'] ?></span>
                                                    <div class="score-player-list align-right"><?php player_from_list($fight['team_1_id']); ?></div>
                                                </div>
                                            </td>
                                            <td>
                                                <input class="team-score" type="number" min="0" max="13" name="score-1" value="<?= $fight['team_1_score'] ?>">
                                            </td>
                                            <td>
                                                <input class="team-score" type="number" min="0" max="13" name="score-2" value="<?= $fight['team_2_score'] ?>">
                                            </td>
                                            <td>
                                                <div class="flex-between-center">
                                                    <div class="score-player-list align-left"><?php player_from_list($fight['team_2_id']); ?></div>
                                                    <span><?= $fight['team_2_id'] ?></span>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php else: ?>
                <div class="message-helper bgc-full notice">Aucune manche créée.</div>
            <?php endif ?>
        </article>
    <?php else: ?>
        <div class="message-helper bgc-full notice">Aucune partie créée.</div>
    <?php endif ?>
    <script>
        
    </script>
</section>

