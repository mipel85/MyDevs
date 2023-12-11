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
    <header class="section-header">
        <h1>Création</h1>
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
        <div id="add-round-container" class="content hero hidden">
            <header class="flex-between">
                <h3>Créer une manche :</h3>
                <button
                        class="submit button<?= $hidden_round ?>"
                        data-party_id="<?= $party_id ?>"
                        data-i_order="<?= $i_order ?>"
                        data-players_number="<?= $players_number ?>"
                        id="add-round"
                        <?= $disabled_round ?>>
                    Ajouter
                </button>
            </header>
            <span id="round-description"><?= $label_round ?></span>
        </div>
    </article>
    <?php if($party_id): ?>
        <article id="rounds-list">
            <?php $party_round_list = array_reverse(Rounds::party_rounds_list($party_id)); ?>
            <?php foreach($party_round_list as $round): ?>
                <?php
                    $round_id = $round['id'];
                    $hidden_remove_round = !already_scored($party_id, $round['id']) && last_round_id($party_id) == $round['id'] ? '' : ' hidden';
                    $hidden_teams_list = Teams::round_teams_list($party_id, $round_id) ? '' : ' hidden';
                    $hidden_teams_btn = Teams::round_teams_list($party_id, $round_id) ? ' hidden' : '';
                    $hidden_fights_list = Fights::round_fights_list($party_id, $round_id) ? '' : ' hidden';
                    $hidden_fights_btn = Fights::round_fights_list($party_id, $round_id) ? ' hidden' : '';
                ?>
                <div class="cell-flex cell-columns-2" data-scored="<?= already_scored($party_id, $round['id']) ?>">
                    <header class="cell-100 flex-between">
                        <h3>Manche <?= $round['i_order'] ?></h3>
                        <button type="submit" 
                                class="remove-button remove-round<?= $hidden_remove_round ?>" 
                                data-party_id="<?= $party_id ?>" 
                                data-round_id="<?= $round['id'] ?>">
                            <i class="fa fa-fw fa-2x fa-square-xmark error"></i>
                        </button>
                    </header>
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
                                    <th>Joueur 1</th>
                                    <th>Joueur 2</th>
                                    <th>Joueur 3</th>
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
                    <div id="fights-list-<?= $round_id ?>" 
                            class="<?= $hidden_teams_list ?>"
                            data-party_id="<?= $party_id ?>"
                            data-round_id="<?= $round_id ?>"
                            data-teams_ready="<?= $team_ready ?>"
                            data-fights_ready="<?= $hidden_fights_btn ?>">
                        <header class="flex-between">
                            <h4>Liste des rencontres</h4>
                            <span class="description"><strong>Manche <?= $round['i_order'] ?></strong></span>
                        </header>
                        <button
                                id="add-fights-<?= $round['i_order'] ?>"
                                data-party_id="<?= $party_id ?>"
                                data-round_id="<?= $round_id ?>"
                                class="button<?= $hidden_fights_btn ?>">
                            Créer les rencontres de la manche
                        </button>
                        <table id="fight-list-round-<?= $round_id ?>" class="table<?= $hidden_fights_list ?>">
                            <thead>
                                <tr>
                                    <th>Équipe A</th>
                                    <th>Équipe B</th>
                                    <th>Terrain</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (Fights::round_fights_list($party_id, $round_id) as $index => $fight): ?>
                                    <tr>
                                        <td>
                                            <div class="flex-around-center">
                                                <span><?= $fight['team_1_id'] ?></span>
                                                <div class="fight-player-list"><?php player_from_list($fight['team_1_id']); ?></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex-around-center">
                                                <span><?= $fight['team_2_id'] ?></span>
                                                <div class="fight-player-list"><?php player_from_list($fight['team_2_id']); ?></div>
                                            </div>
                                        </td>
                                        <td><?= $fight['playground'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
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
            $('#round-description').html("Aucun score de la manche en cours n'est renseigné.<br />L'ajout est désactivé.")
        }

    </script>
</section>

