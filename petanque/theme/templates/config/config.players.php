<div id="add-joueur" class="cell-1-3">
    <header>
        <h3>Ajouter des joueurs</h3>
    </header>
    <div id="config_saisie">
        <label>Nom du joueur : </label>
        <input type="text" id="player_name" class="nom-ajout" />
        <div class="line align-center">
            <button type="submit" id="add-player" class="button btn-ajout">Ajouter</button>
        </div>
    </div>
</div>
<div id="player-list" class="cell-2-3 content">
    <header>
        <h3>Liste des joueurs</h3>
    </header>
    <table id="registred-players" class="table">
        <thead>
            <tr>
                <th>N°</th>
                <th>Nom</th>
                <th>Habitués</th>
                <th>Sup</th>
            </tr>
            </thead>
        <tbody>
            <?php foreach (Players::players_list() as $player): ?>
                <?php $checked = $player['fav'] ? ' checked' : ''; ?>
                <tr>
                    <td><?= $player['id'] ?></td>
                    <td><?= $player['name'] ?></td>
                    <td><input type="checkbox" data-id="<?= $player['id'] ?>" class="fav-player"<?= $checked ?> /></td>
                    <td><button type="button" id="<?= $player['id'] ?>" class="delete-player"><i class="fa fa-fw fa-square-xmark error"></i></button></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <div class="line flex-between">
        <span>&nbsp;</span>
        <button type="button" onclick="location.reload(true);" class="button submit">Valider les favoris</button>
        <button type="button" id="reset-all-favs" class="button btn-reset-present">Décocher tout</button>
    </div>
</div>