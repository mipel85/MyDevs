<?php

require_once('./classes/Parties.class.php');
require_once('./classes/Members.class.php');
require_once('./classes/Rounds.class.php');
require_once('./classes/Teams.class.php');
require_once('./classes/Matches.class.php');
require_once('./functions/party.manager.php');
require_once('./functions/rules.php');

?>
<section>
    <header class="section-header flex-between">
        <h1>Création</h1>
        <div id="add-round-container" class="flex-between-center hero hidden">
            <span>
                <button
                        class="submit button<?= $hidden_round ?>"
                        data-party_id="<?= $party_id ?>"
                        data-i_order="<?= $i_order ?>"
                        data-players_number="<?= $players_number ?>"
                        id="add-round"
                        <?= $disabled_round ?>>
                    Ajouter une partie
                </button>
            </span><span id="round-description"><?= $label_round ?></span>
        </div>
    </header>
    <article class="cell-flex cell-columns-2">
        <div id="party-manager" class="content<?= $hidden_party ?>" data-party_ready="<?= $party_id ?>">
            <header>
                <h3>Initialiser une Partie :</h3>
            </header>
            <label for="party-date"><?= $label_partie ?></label>
            <input type="hidden" id="party-date" name="party-date" value="" />
            <button class="submit button<?= $hidden_party ?>" type="submit" id="add-party" name="day"<?= $disabled_partie ?>>Ajouter</button>
        </div>
    </article>
    <?php if($party_id): ?>
        <article id="rounds-list" class="tabs-container">
            <?php $party_round_list = array_reverse(Rounds::party_rounds_list($party_id)); ?>
            <div class="tabs-menu">
                <?php foreach($party_round_list as $round): ?>
                    <?php $active_tab = last_round_id($party_id) == $round['id'] ? ' active-tab' : ''; ?>
                    <span data-trigger="tab-content-<?= $round['i_order'] ?>" class="tab-trigger<?= $active_tab ?>" onclick="openTab(event, 'tab-content-<?= $round['i_order'] ?>');">Manche <?= $round['i_order'] ?></span>
                <?php endforeach ?>
            </div>
            <?php foreach($party_round_list as $round): ?>
                <?php $active_tab = last_round_id($party_id) == $round['id'] ? ' active-tab' : ''; ?>
                <?php $active_tab = last_round_id($party_id) == $round['id'] ? ' active-tab' : ''; ?>
                <?php
                    $round_id = $round['id'];
                    $hidden_remove_round = !is_scored($party_id, $round['id']) && last_round_id($party_id) == $round['id'] ? '' : ' hidden';
                    $hidden_teams_list = Teams::round_teams_list($party_id, $round_id) ? '' : ' hidden';
                    $hidden_teams_btn = Teams::round_teams_list($party_id, $round_id) ? ' hidden' : '';
                    $hidden_matches_list = Matches::round_matches_list($party_id, $round_id) ? '' : ' hidden';
                    $hidden_matches_btn = Matches::round_matches_list($party_id, $round_id) ? ' hidden' : '';
                ?>
                <div id="tab-content-<?= $round['i_order'] ?>" class="cell-flex cell-columns-2 tab-content<?= $active_tab ?>" data-scored="<?= is_scored($party_id, $round['id']) ?>">
                    <div class="cell-100 flex-between">
                        <h3>Manche <?= $round['i_order'] ?></h3>
                        <button type="submit" 
                                class="remove-button remove-round<?= $hidden_remove_round ?>" 
                                data-party_id="<?= $party_id ?>" 
                                data-round_id="<?= $round['id'] ?>">
                            <i class="fa fa-fw fa-2x fa-square-xmark error"></i>
                        </button>
                    </div>
                    <div id="teams-list-<?= $round_id ?>"
                            data-round_ready="<?= $hidden_teams_btn ?>"
                            data-party_id="<?= $party_id ?>"
                            data-round_id="<?= $round_id ?>">
                        <header class="flex-between">
                            <h4><?= $round['players_number'] ?> joueurs</h4>
                            <span class="description"><strong>Manche <?= $round['i_order'] ?></strong> - <?= rules($round['players_number']) ?></span>
                        </header>
                        <button
                                id="add-teams-<?= $round['i_order'] ?>"
                                data-party_id="<?= $party_id ?>"
                                data-round_id="<?= $round_id ?>"
                                class="button<?= $hidden_teams_btn ?>">
                            Créer les équipes de la manche
                        </button>
                        <table id="teams-list-round-<?= $round_id ?>" class="table<?= $hidden_teams_list ?>">
                            <thead>
                                <tr>
                                    <th>Équipe</th>
                                    <th>Joueur A</th>
                                    <th>Joueur B</th>
                                    <th>Joueur C</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (Teams::round_teams_list($party_id, $round_id) as $index => $team): ?>
                                    <tr>
                                        <td><?= $team['id'] ?></td>
                                        <td><?= $team['player_1_name'] ?></td>
                                        <td><?= $team['player_2_name'] ?></td>
                                        <td><?= $team['player_3_name'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                        $team_ready = count(Teams::round_teams_list($party_id, $round_id));
                    ?>
                    <div id="matches-list-<?= $round_id ?>" 
                            class="<?= $hidden_teams_list ?>"
                            data-party_id="<?= $party_id ?>"
                            data-round_id="<?= $round_id ?>"
                            data-teams_ready="<?= $team_ready ?>"
                            data-matches_ready="<?= $hidden_matches_btn ?>">
                        <header class="flex-between">
                            <h4>Liste des rencontres</h4>
                            <span class="description"><strong>Manche <?= $round['i_order'] ?></strong></span>
                        </header>
                        <button
                                id="add-matches-<?= $round['i_order'] ?>"
                                data-party_id="<?= $party_id ?>"
                                data-round_id="<?= $round_id ?>"
                                class="button<?= $hidden_matches_btn ?>">
                            Créer les rencontres de la manche
                        </button>
                        <div class="expand-container">
                            <span class="expand-button" id="expand-<?= $round_id ?>"></span>
                            <table id="match-list-round-<?= $round_id ?>" class="table<?= $hidden_matches_list ?>">
                                <thead>
                                    <tr>
                                        <th>Équipe A</th>
                                        <th>Équipe B</th>
                                        <th>Terrain</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (Matches::round_matches_list($party_id, $round_id) as $index => $match): ?>
                                        <tr>
                                            <td>
                                                <div class="flex-around-center">
                                                    <span><?= $match['team_1_id'] ?></span>
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
                                                    <span><?= $match['team_2_id'] ?></span>
                                                    <div class="match-player-list">
                                                        <?php foreach (Teams::get_team_members($match['team_2_id']) as $players): ?>
                                                            <span class="match-player"><?= $players[1] ?></span>
                                                            <span class="match-player"><?= $players[3] ?></span>
                                                            <span class="match-player"><?= $players[5] ?></span>
                                                        <?php endforeach ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= $match['playground'] ?></td>
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
        // set today format
        let date = new Date(), d = date.getDate(), m = date.getMonth() + 1, y = date.getFullYear();
        if (d < 10) d = '0' + d;
        if (m < 10) m = '0' + m;
        const formatDate = d + '-' + m + '-' + y;
        // send today to hidden input of partie
        document.getElementById('party-date').value = formatDate;

        // if no party hide round
        if ($('#add-party').hasClass('hidden'))
            $('#add-round-container').removeClass('hidden');

        // hidden add round
        // get data-scored of first of rounds in the dom if exists
        let first = $('[data-scored]').first().data('scored');
            add_button = $('#add-round');
        add_button.removeClass('hidden');
        if (first == '') {
            add_button.addClass('hidden');
            $('#round-description').html("Aucun score de la partie en cours n'est renseigné.<br />L'ajout d'une nouvelle partie est désactivé.")
        }
    </script>
</section>

