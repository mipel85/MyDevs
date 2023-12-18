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
                        class="cell-flex cell-columns-2 tab-content<?= $active_tab ?>"
                        data-scored="<?= is_scored($day_id, $round['id']) ?>">
                    <div class="cell-100 flex-between">
                        <span></span>
                        <button type="submit" 
                                class="icon-button remove-round<?= $hidden_remove_round ?>" 
                                data-day_id="<?= $day_id ?>" 
                                data-round_id="<?= $round['id'] ?>"
                                data-round_i_order="<?= $round['i_order'] ?>">
                            <i class="fa fa-fw fa-2x fa-square-xmark error"></i>
                        </button>
                    </div>
                    <div id="teams-list-<?= $round_id ?>"
                            data-round_ready="<?= $hidden_teams_btn ?>"
                            data-day_id="<?= $day_id ?>"
                            data-round_id="<?= $round_id ?>">
                        <header class="flex-between">
                            <h4><?= $round['players_number'] ?> joueurs</h4>
                            <span class="description"><strong>Partie <?= $round['i_order'] ?></strong> - <?= rules($round['players_number']) ?></span>
                        </header>
                        <table id="teams-list-round-<?= $round_id ?>" class="table<?= $hidden_teams_list ?>">
                            <thead>
                                <tr>
                                    <!-- <th>Équipe</th> -->
                                    <th>Joueur A</th>
                                    <th>Joueur B</th>
                                    <th>Joueur C</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (Teams::round_teams_list($day_id, $round_id) as $index => $team): ?>
                                    <tr>
                                        <!-- <td><?= $team['id'] ?></td> -->
                                        <td><?= $team['player_1_name'] ?></td>
                                        <td><?= $team['player_2_name'] ?></td>
                                        <td><?= $team['player_3_name'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
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
                            <span class="description"><strong>Partie <?= $round['i_order'] ?></strong></span>
                        </header>
                        <div class="expand-container">
                            <span data-minimize="rounds-<?= $round['i_order'] ?>" data-expand="expand-rounds-<?= $round['i_order'] ?>" class="expand-button" id="expand-<?= $round_id ?>"></span>
                            <table id="match-list-round-<?= $round_id ?>" class="table<?= $hidden_matches_list ?>">
                                <thead>
                                    <tr>
                                        <th>Terrain</th>
                                        <th>Équipe A</th>
                                        <th>Équipe B</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (Matches::round_matches_list($day_id, $round_id) as $index => $match): ?>
                                        <?php $validated_score = $match['score_status'] ? ' class="validated-score"' : ''; ?>
                                        <tr<?= $validated_score ?>>
                                            <td><span class="big"><?= $match['field'] ?></span></td>
                                            <td>
                                                <div class="flex-around-center">
                                                    <!-- <span><?= $match['team_1_id'] ?></span> -->
                                                    <div class="match-player-list">
                                                        <?php foreach (Teams::get_team_members($match['team_1_id']) as $players): ?>
                                                            <span class="match-player"><?= $players[1] ?></span>
                                                            <span class="match-player"><?= $players[3] ?></span>
                                                            <span class="match-player"><?= $players[5] ?></span>
                                                        <?php endforeach ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="flex-around-center">
                                                    <!-- <span><?= $match['team_2_id'] ?></span> -->
                                                    <div class="match-player-list">
                                                        <?php foreach (Teams::get_team_members($match['team_2_id']) as $players): ?>
                                                            <span class="match-player"><?= $players[1] ?></span>
                                                            <span class="match-player"><?= $players[3] ?></span>
                                                            <span class="match-player"><?= $players[5] ?></span>
                                                        <?php endforeach ?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
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
        })
    </script>
</section>

