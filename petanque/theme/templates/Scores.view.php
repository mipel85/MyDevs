<?php

require_once('./classes/Members.class.php');
require_once('./classes/Days.class.php');
require_once('./classes/Rounds.class.php');
require_once('./classes/Teams.class.php');
require_once('./classes/Matches.class.php');
require_once('./controllers/Days.controller.php');

$possible_scores = 12;

?>
<section>
    <header class="section-header flex-between-center">
        <h1>Scores</h1>
        <div>
            <button id="update-rankings" class="button full-notice">Mettre à jour le classement</button>
        </div>
    </header>
    <?php if($day_id): ?>
        <article id="rounds-list">
            <?php $day_round_list = array_reverse(Rounds::day_rounds_list($day_id)); ?>
            <?php if($c_rounds): ?>
                <div class="tabs-menu">
                    <?php foreach($day_round_list as $round): ?>
                        <?php $active_tab = last_round_id($day_id) == $round['id'] ? ' active-tab' : ''; ?>
                        <span data-trigger="rounds-<?= $round['i_order'] ?>" class="tab-trigger<?= $active_tab ?>" onclick="openTab(event, 'rounds-<?= $round['i_order'] ?>');">Partie <?= $round['i_order'] ?></span>
                    <?php endforeach ?>
                </div>
                <?php foreach($day_round_list as $round): ?>
                    <?php $active_tab = last_round_id($day_id) == $round['id'] ? ' active-tab' : ''; ?>
                    <div id="rounds-<?= $round['i_order'] ?>"
                            class="matches-list tab-content<?= $active_tab ?>"
                            data-day_id="<?= $day_id ?>"
                            data-round_id="<?= $round['id'] ?>">
                        <div class="expand-container">
                            <div class="score-buttons-list">
                                <?php for($i = 0; $i <= $possible_scores; $i++): ?>
                                    <button data-score_button="<?= $i ?>" class="button score-button" type="submit"><?= $i ?></button>
                                <?php endfor ?>
                            </div>
                            <div class="flex-between">
                                <span class="description">
                                    Sélectionner le score des perdants puis sélectionner un nombre dans la liste ci-dessus.
                                    <br />Le score des gagnants (13) est renseigné automatiquement.
                                </span>
                                <span class="description">
                                    Sur fond vert, les scores validés.
                                    <br />Sur fond blanc, les scores non validés
                                </span>
                            </div>
                            <span data-minimize="rounds-<?= $round['i_order'] ?>" data-expand="expand-rounds-<?= $round['i_order'] ?>" class="expand-button" id="expand-<?= $round['id'] ?>"></span>
                            <div id="matches-round-list-<?= $round['id'] ?>" class="matches-round-list cell-flex cell-columns-8">
                                <?php foreach (Matches::round_matches_list($day_id, $round['id']) as $index => $match): ?>
                                    <?php $disabled_score = $match['score_status'] ? ' disabled' : ''; ?>
                                    <div
                                            class="match-scores row-item row-vertical"
                                            id="matches-score-<?= $match['id'] ?>"
                                            data-field="<?= $match['field'] ?>"
                                            data-day_id="<?= $day_id ?>"
                                            data-round_id="<?= $round['id'] ?>"
                                            data-match_id="<?= $match['id'] ?>">
                                        <div class="score-row-field">
                                            <span class="big stamp full-main"><?= $match['field'] ?></span>
                                        </div>
                                        <div class="score-row-team-left">
                                            <span data-team_1_id="<?= $match['team_1_id'] ?>"></span>
                                            <div class="score-member-list">
                                                <?php foreach (Teams::get_team_members($match['team_1_id']) as $players): ?>
                                                    <span data-team_a0 class="d-block" data-member_id="<?= $players[0] ?>"><?= $players[1] ?></span>
                                                    <span data-team_a2 class="d-block" data-member_id="<?= $players[2] ?>"><?= $players[3] ?></span>
                                                    <span data-team_a4 class="d-block" data-member_id="<?= $players[4] ?>"><?= $players[5] ?></span>
                                                <?php endforeach ?>
                                            </div>
                                        </div>
                                        <div class="score-row-left score-row">
                                            <input readonly class="input team-score" type="text" min="0" max="13" name="score-1" value="<?= $match['team_1_score'] ?>"<?= $disabled_score ?>>
                                        </div>
                                        <div class="score-row-right score-row">
                                            <input readonly class="input team-score" type="text" min="0" max="13" name="score-2" value="<?= $match['team_2_score'] ?>"<?= $disabled_score ?>>
                                        </div>
                                        <div class="score-row-team-right">
                                            <div class="score-member-list">
                                                <?php foreach (Teams::get_team_members($match['team_2_id']) as $players): ?>
                                                    <span data-team_b0 class="d-block" data-member_id="<?= $players[0] ?>"><?= $players[1] ?></span>
                                                    <span data-team_b2 class="d-block" data-member_id="<?= $players[2] ?>"><?= $players[3] ?></span>
                                                    <span data-team_b4 class="d-block" data-member_id="<?= $players[4] ?>"><?= $players[5] ?></span>
                                                <?php endforeach ?>
                                            </div>
                                            <span data-team_2_id="<?= $match['team_2_id'] ?>"></span>
                                        </div>
                                        <div class="score-row-button<?php if(!$match['score_status']): ?> button-with-manual<?php endif ?>">
                                            <?php if(!$match['score_status']): ?><span></span><?php endif ?>
                                            <?php if($match['score_status']): ?>
                                                <span><button id="edit-scores-<?= $match['id'] ?>" data-score_status="0" type="submit" class="button edit-score">Modifier</button></span>
                                            <?php else: ?>
                                                <span><button id="submit-scores-<?= $match['id'] ?>" data-score_status="1" type="submit" class="button">Valider</button></span>
                                            <?php endif ?>
                                            <?php if(!$match['score_status']): ?><button id="manual-scores-<?= $match['id'] ?>" data-tooltip="Renseigner le score manuellement" type="submit" class="icon-button"><i class="fa fa-keyboard"></i></button><?php endif ?>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                                <script>reorderfields('#matches-round-list-<?= $round['id'] ?>', '.row-item', 'field');</script>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else: ?>
                <div class="message-helper full-notice">Aucune partie créée.</div>
            <?php endif ?>
        </article>
    <?php else: ?>
        <div class="message-helper full-notice">Aucune partie créée.</div>
    <?php endif ?>
    <script>
        // Déclaration manuelle des scores
        $('[id*="manual-scores-"').on('click', function(){
            $(this).closest('.row-item').find('.input').removeAttr('readonly').addClass('full-sub');
        });
        // Déclaration des scores
        $('input.team-score').each(function() {
            $(this).on('click', function() { // sélection de l'input à renseigner
                // On supprime le focus de tous les autres input
                $(this).closest('.matches-round-list').find('input').removeClass('focused-score full-sub');
                $(this).closest('.matches-round-list').find('.row-item').removeClass('full-notice');
                $(this).closest('.matches-round-list').find('.button').removeClass('full-sub');
                // on ajoute le focus sur l'input
                $(this).addClass('focused-score full-sub').removeClass('bgc-notice notice');
                $(this).closest('.row-item').addClass('full-notice');
                $(this).closest('.row-item').find('.button').addClass('full-sub');
                $(this).parent().siblings('.score-row').find('.input').addClass('bgc-notice notice')
            });
        });
        $('.score-button').each(function(){
            $(this).on('click', function() {
                let score = $(this).data('score_button'),
                    looser = $(this).closest('.matches-list').find('input.focused-score'),
                    winner = looser.closest('.row-item').find("input:not('.focused-score')");
                winner.val(13);
                looser.val(score).removeClass('focused-score');
            })
        });
    </script>
</section>

<script>
    // If scroll, pass score buttons to fixed position
    var distance = $('.score-buttons-list').offset().top; 

    $(window).scroll(function () {
        if ($(window).scrollTop() >= distance) {
            $('.score-buttons-list').addClass("fixed-element");

        } else {
            $('.score-buttons-list').removeClass("fixed-element");
        }
    });


</script>

