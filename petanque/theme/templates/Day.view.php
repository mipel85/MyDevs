<?php

require_once('./classes/Days.class.php');
require_once('./classes/Fields.class.php');
require_once('./classes/Members.class.php');
require_once('./classes/Rounds.class.php');
require_once('./classes/Teams.class.php');
require_once('./classes/Matches.class.php');
require_once('./controllers/Rules.controller.php');
require_once('./controllers/Days.controller.php');

?>
<section>
    <header class="section-header flex-between">
        <h1>Gestion des parties</h1>
        <article id="day-manager" class="content<?= $hidden_day ?>" data-day_ready="<?= $day_id ?>">
            <header id="add-day" class="<?= $hidden_day ?>">
                <h3>Initialisation de la journée ...</h3>
            </header>
            <input type="hidden" id="day-date" name="day-date" value="<?= $today ?>" />
        </article>
        <div id="add-round-container" class="hero hidden flex-between-center">
            <div class="playgrounds-list flex-between-center">
                <span>Sélection des<br>terrains disponibles</span>
                <div class="field-checkbox">
                    <?php if($c_started_day): ?>
                        <?php foreach (Fields::fields_checkbox_list($day_id) as $checkboxes): ?>
                            <?php foreach ($checkboxes as $index => $checked): ?>
                                <?php $is_checked = $checked ? ' checked' : '';?>
                                <label for="field_<?= $index ?>" class="checkbox">
                                    <input 
                                            class="checkbox-field"
                                            type="checkbox"
                                            name="field-<?= $index ?>"
                                            data-fields_id="<?= Fields::field_id($day_id) ?>"
                                            id="field_<?= $index ?>"<?= $is_checked ?>>
                                    <span><?= $index ?></span>
                                </label>
                            <?php endforeach ?>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            </div>
            <div class="line align-center">
                <button
                        class="button full-success<?= $hidden_round ?>"
                        data-day_id="<?= $day_id ?>"
                        data-i_order="<?= $i_order ?>"
                        data-players_number="<?= $players_number ?>"
                        id="add-round"
                        <?= $disabled_round ?>>
                    Créer la <strong>partie <?= $i_order ?></strong>
                </button>
                <span id="round-description" class="description"><?= $label_round ?></span>
            </div>
        </div>
    </header>
    <?php if($c_started_day): ?>
        <article id="rounds-list" class="tabs-container">
            <?php $day_round_list = array_reverse(Rounds::day_rounds_list($day_id)); ?>
            <div class="tabs-menu">
                <?php foreach($day_round_list as $round): ?>
                    <?php $active_tab = last_round_id($day_id) == $round['id'] ? ' active-tab' : ''; ?>
                    <span data-trigger="rounds-<?= $round['i_order'] ?>" class="tab-trigger<?= $active_tab ?>" onclick="openTab(event, 'rounds-<?= $round['i_order'] ?>');">Partie <?= $round['i_order'] ?></span>
                <?php endforeach ?>
            </div>
            <?php foreach($day_round_list as $round): ?>
                <?php $active_tab = last_round_id($day_id) == $round['id'] ? ' active-tab' : ''; ?>
                <?php
                    $round_id = $round['id'];
                    $hidden_remove_round = !is_scored($day_id, $round['id']) && last_round_id($day_id) == $round['id'] ? '' : ' hidden';
                    $hidden_teams_list = Teams::round_teams_list($day_id, $round_id) ? '' : ' hidden';
                    $hidden_teams_btn = Teams::round_teams_list($day_id, $round_id) ? ' hidden' : '';
                    $hidden_matches_list = Matches::round_matches_list($day_id, $round_id) ? '' : ' hidden';
                    $hidden_matches_btn = Matches::round_matches_list($day_id, $round_id) ? ' hidden' : '';
                ?>
                <div id="rounds-<?= $round['i_order'] ?>"
                        class="tab-content<?= $active_tab ?>"
                        data-scored="<?= is_scored($day_id, $round['id']) ?>">
                    <div class="flex-between">
                        <span></span>
                        <button type="submit" 
                                class="icon-button remove-round<?= $hidden_remove_round ?>" 
                                data-day_id="<?= $day_id ?>" 
                                data-round_id="<?= $round['id'] ?>"
                                data-round_i_order="<?= $round['i_order'] ?>">
                            <i class="fa fa-fw fa-2x fa-square-xmark error"></i>
                        </button>
                    </div>
                    <?php
                        $matches_ready = count(Matches::round_matches_list($day_id, $round_id));
                        $hidden_matches_ready = $matches_ready ? ' class="hidden"' : '';
                    ?>
                    <div id="teams-list-<?= $round_id ?>"<?= $hidden_matches_ready ?>
                            data-round_ready="<?= $hidden_teams_btn ?>"
                            data-day_id="<?= $day_id ?>"
                            data-round_id="<?= $round_id ?>">
                        <header class="flex-between-center">
                            <h4><?= $round['players_number'] ?> joueurs</h4>
                            <span class="description"><strong>Partie <?= $round['i_order'] ?></strong> - <?= rules($round['players_number']) ?></span>
                        </header>
                        <div id="teams-round-list-<?= $round_id ?>" class="teams-round-list cell-flex cell-columns-4<?= $hidden_teams_list ?>">
                            <?php foreach (Teams::round_teams_list($day_id, $round_id) as $index => $team): ?>
                                <div class="row-item row-vertical flex-start-center bgc-sub">
                                    <div><?= $team['player_1_name'] ?></div>
                                    <div><?= $team['player_2_name'] ?></div>
                                    <?php if ($team['player_3_name']): ?><div><?= $team['player_3_name'] ?></div><?php endif ?>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <?php
                        $team_ready = count(Teams::round_teams_list($day_id, $round_id));
                    ?>
                    <div id="matches-list-<?= $round_id ?>" 
                            class="<?= $hidden_teams_list ?>"
                            data-day_id="<?= $day_id ?>"
                            data-round_id="<?= $round_id ?>"
                            data-teams_ready="<?= $team_ready ?>"
                            data-matches_ready="<?= $hidden_matches_btn ?>">
                        <header class="flex-between">
                            <h4>Liste des rencontres</h4>
                            <span class="description"><strong>Partie <?= $round['i_order'] ?></strong> - <?= $round['players_number'] ?> joueurs - <?= rules($round['players_number']) ?></span>
                        </header>
                        <div class="expand-container">
                            <span data-minimize="rounds-<?= $round['i_order'] ?>" data-expand="expand-rounds-<?= $round['i_order'] ?>" class="expand-button" id="expand-<?= $round_id ?>"></span>
                            <div id="matches-round-list-<?= $round_id ?>" class="match-list big-line cell-flex cell-columns-4<?= $hidden_matches_list ?>">
                                <?php foreach (Matches::round_matches_list($day_id, $round_id) as $index => $match): ?>
                                    <?php $validated_score = $match['score_status'] ? ' full-success' : ''; ?>
                                    <div 
                                            class="row-item flex-between-center<?= $validated_score ?>"
                                            data-field="<?= $match['field'] ?>">
                                        <div class="width-50 align-center">
                                            <span class="big stamp full-main"><?= $match['field'] ?></span>
                                        </div>
                                        <div class="flex-main">
                                            <?php foreach (Teams::get_team_members($match['team_1_id']) as $players): ?>
                                                <span data-member_id="<?= $players[0] ?>" class="d-block"><?= $players[1] ?></span>
                                                <span data-member_id="<?= $players[2] ?>" class="d-block"><?= $players[3] ?></span>
                                                <span data-member_id="<?= $players[4] ?>" class="d-block"><?= $players[5] ?></span>
                                            <?php endforeach ?>
                                        </div>
                                        <div class="align-right">
                                            <?php foreach (Teams::get_team_members($match['team_2_id']) as $players): ?>
                                                <span data-member_id="<?= $players[0] ?>" class="d-block"><?= $players[1] ?></span>
                                                <span data-member_id="<?= $players[2] ?>" class="d-block"><?= $players[3] ?></span>
                                                <span data-member_id="<?= $players[4] ?>" class="d-block"><?= $players[5] ?></span>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                            <script>
                                reorderfields('#matches-round-list-<?= $round['id'] ?>', '.row-item', 'field');
                            </script>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </article>
    <?php endif ?>
    <script>
        $(document).ready(function() {
            // if no day, hide round
            if ($('#add-day').hasClass('hidden'))
                $('#add-round-container').removeClass('hidden');

            // hidden add-round and fields selection
            // get data-scored of first of rounds in the dom if exists
            let first = $('[data-scored]').first().data('scored');
                add_button = $('#add-round');
            add_button.removeClass('hidden');
            if (first == '') {
                add_button.addClass('hidden');
                $('.playgrounds-list').addClass('hidden')
                $('#round-description').html("Aucun score de la partie en cours n'est renseigné.<br />L'ajout d'une nouvelle partie est désactivé.")
            }
            // rowtocolumn('.match-list', '.row-item', 'field');
            // rowtocolumn('.match-list', '.row-item', 'row-col', 2);
        })
    </script>
</section>