<?php

require_once('./classes/Connection.class.php');
require_once('./classes/Players.class.php');
require_once('./classes/Parties.class.php');
require_once('./classes/Rounds.class.php');
require_once('./classes/Teams.class.php');
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
                <!-- <a href="index.php?page=config#party"><i class="fa fa-cog"></i></a> -->
            </header>
            <label for="party-date"><?= $label_partie ?></label>
            <input type="hidden" id="party-date" name="party-date" value="" />
            <button class="submit button<?= $hidden_party ?>" type="submit" id="add-party" name="day"<?= $disabled_partie ?>>Ajouter</button>
        </div>
        <div id="add-round-container" class="content hidden">
            <header>
                <h3>Créer une manche :</h3>
                <!-- <a href="index.php?page=config#manches"><i class="fa fa-cog"></i></a> -->
            </header>
            <label for="choix_partie"><?= $label_manche ?></label>
            <button
                    class="submit button<?= $hidden_round ?>"
                    data-party_id="<?= $party_id ?>"
                    data-i_order="<?= $i_order ?>"
                    data-players_number="<?= $players_number ?>"
                    id="add-round"
                    <?= $disabled_round ?>>
                Ajouter
            </button>
        </div>
    </article>
    <?php if($party_id): ?>
        <article id="rounds-list">
            <?php foreach(Rounds::party_rounds_list($party_id) as $round): ?>
                <?php 
                    $round_id = $round['id']; 
                    $hidden_teams_list = Teams::round_teams_list($party_id, $round_id) ? '' : ' hidden';
                    $hidden_teams_btn = Teams::round_teams_list($party_id, $round_id) ? ' hidden' : '';
                ?>
                <div class="cell-flex cell-columns-2">
                    <div id="teams-list-<?= $round_id ?>"
                            data-round_ready="<?= $hidden_teams_btn ?>"
                            data-party_id="<?= $party_id ?>"
                            data-round_id="<?= $round_id ?>">
                        <header>
                            <div class="flex-between">
                                <h3>Manche <?= $round['i_order'] ?> - Équipes</h3>
                                <a href="index.php?page=config#rounds"><i class="fa fa-cog"></i></a>
                            </div>
                            <span class="description"><?= $round['players_number'] ?> joueurs - <?= rules($round['players_number']) ?></span>
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
                                        <td><?= $index + 1 ?></td>
                                        <td><?= $team['player_1_name'] ?></td>
                                        <td><?= $team['player_2_name'] ?></td>
                                        <td><?= $team['player_3_name'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="games-list" class="<?= $hidden_teams_list ?>" data-team_ready="<?= $round_id ?>">
                        <header>
                            <h3>Manche <?= $round['i_order'] ?> - Rencontres</h3>
                        </header>
                        <button
                                id="add-fights-<?= $round['i_order'] ?>"
                                data-party_id="<?= $party_id ?>"
                                data-round_id="<?= $round_id ?>"
                                class="button">
                            Créer les rencontres de la manche
                        </button>
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

        if ($('#add-party').hasClass('hidden'))
            $('#add-round-container').removeClass('hidden');
    </script>
</section>

