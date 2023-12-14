<?php

require_once('./classes/Members.class.php');
require_once('./classes/Days.class.php');
require_once('./classes/Rounds.class.php');
require_once('./classes/Teams.class.php');
require_once('./classes/Matches.class.php');
require_once('./controllers/Day.controller.php');

$possible_scores = 12;

?>
<section>
    <header class="section-header flex-between-center">
        <h1>Scores</h1>
        <?php if(Days::started_day()): ?><span class="description"><?= $today ?></span><?php endif ?>
    </header>
    <?php if($day_id): ?>
        <article id="rounds-list">
            <?php $day_round_list = array_reverse(Rounds::day_rounds_list($day_id)); ?>
            <?php if($c_rounds): ?>
                <div class="tabs-menu">
                    <?php foreach($day_round_list as $round): ?>
                        <?php $active_tab = last_round_id($day_id) == $round['id'] ? ' active-tab' : ''; ?>
                        <span data-trigger="matches-list-<?= $round['id'] ?>" class="tab-trigger<?= $active_tab ?>" onclick="openTab(event, 'matches-list-<?= $round['id'] ?>');">Manche <?= $round['i_order'] ?></span>
                    <?php endforeach ?>
                </div>
                <?php foreach($day_round_list as $round): ?>
                    <?php $active_tab = last_round_id($day_id) == $round['id'] ? ' active-tab' : ''; ?>
                    <div class="matches-list tab-content<?= $active_tab ?>" id="matches-list-<?= $round['id'] ?>"
                            data-day_id="<?= $day_id ?>"
                            data-round_id="<?= $round['id'] ?>">
                        <header class="flex-between">
                            <h3>Manche <?= $round['i_order'] ?></h3>
                        </header>
                        <div class="expand-container">
                            <div class="score-buttons-list">
                                <?php for($i = 0; $i <= $possible_scores; $i++): ?>
                                    <button data-score_button="<?= $i ?>" class="score-button" type="submit"><?= $i ?></button>
                                <?php endfor ?>
                            </div>
                            <div class="flex-between">
                                <span class="description">
                                    Sélectionner le score des perdants puis sélectionner un nombre dans la liste ci-dessus.
                                    <br />Le score des gagnants (13) est renseigné automatiquement.
                                </span>
                                <span class="description">
                                    Sur fond bleu, les scores validés.
                                    <br />Sur fond blanc, les scores non validés
                                </span>
                            </div>
                            <span class="expand-button" id="expand-<?= $round['id'] ?>"></span>
                            <table id="match-list-round-<?= $round['id'] ?>" class="table">
                                <thead>
                                    <tr>
                                        <th>Terrain</th>
                                        <th>Équipe A</th>
                                        <th class="set-scores">Score A</th>
                                        <th class="set-scores">Score B</th>
                                        <th>Équipe B</th>
                                        <th>Validation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (Matches::round_matches_list($day_id, $round['id']) as $index => $match): ?>
                                        <?php $disabled_score = $match['score_status'] ? ' disabled' : ''; ?>
                                        <tr
                                                class="match-scores"
                                                id="matches-score-<?= $match['id'] ?>"
                                                data-round_id="<?= $round['id'] ?>"
                                                data-match_id="<?= $match['id'] ?>">
                                            <td><?= $match['playground'] ?></td>
                                            <td>
                                                <div class="flex-between-center">
                                                    <span data-team_1_id="<?= $match['team_1_id'] ?>"></span>
                                                    <div class="score-member-list align-right">
                                                        <?php foreach (Teams::get_team_members($match['team_1_id']) as $players): ?>
                                                            <span class="match-player" data-player_id_score="<?= $players[0] ?>"><?= $players[1] ?></span>
                                                            <span class="match-player" data-player_id_score="<?= $players[2] ?>"><?= $players[3] ?></span>
                                                            <span class="match-player" data-player_id_score="<?= $players[4] ?>"><?= $players[5] ?></span>
                                                        <?php endforeach ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input readonly class="team-score" type="text" min="0" max="13" name="score-1" value="<?= $match['team_1_score'] ?>"<?= $disabled_score ?>>
                                            </td>
                                            <td>
                                                <input readonly class="team-score" type="text" min="0" max="13" name="score-2" value="<?= $match['team_2_score'] ?>"<?= $disabled_score ?>>
                                            </td>
                                            <td>
                                                <div class="flex-between-center">
                                                    <div class="score-member-list align-left">
                                                        <?php foreach (Teams::get_team_members($match['team_2_id']) as $players): ?>
                                                            <span class="match-player" data-player_id_score="<?= $players[0] ?>"><?= $players[1] ?></span>
                                                            <span class="match-player" data-player_id_score="<?= $players[2] ?>"><?= $players[3] ?></span>
                                                            <span class="match-player" data-player_id_score="<?= $players[4] ?>"><?= $players[5] ?></span>
                                                        <?php endforeach ?>
                                                    </div>
                                                    <span data-team_2_id="<?= $match['team_2_id'] ?>"></span>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if($match['score_status']): ?>
                                                    <span><button id="edit-scores-<?= $match['id'] ?>" data-score_status="0" type="submit" class="button">Modifier le score</button></span>
                                                <?php else: ?>
                                                    <span><button id="submit-scores-<?= $match['id'] ?>" data-score_status="1" type="submit" class="button">Valider le score</button></span>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else: ?>
                <div class="message-helper bgc-full notice">Aucune manche créée.</div>
            <?php endif ?>
        </article>
    <?php else: ?>
        <div class="message-helper bgc-full notice">Aucune partie créée.</div>
    <?php endif ?>
    <script>
        // Déclaration des scores
        $('input.team-score').each(function() {
            $(this).on('click', function() {
                $(this).closest('table').find('input').removeClass('focused-score');
                $(this).addClass('focused-score');
            });
        });
        $('.score-button').each(function(){
            $(this).on('click', function() {
                let score = $(this).data('score_button'),
                    looser = $(this).closest('.matches-list').find('input.focused-score'),
                    winner = looser.closest('tr').find("input:not('.focused-score')");
                winner.val(13);
                looser.val(score).removeClass('focused-score');
            })
        });
    </script>
</section>

