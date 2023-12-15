<div id="add-joueur" class="cell-1-3">
    <header>
        <h3>Ajouter des joueurs</h3>
    </header>
    <div id="config_saisie">
        <label>Nom du joueur : </label>
        <input type="text" id="member_name" class="nom-ajout" />
        <div class="line align-center">
            <button type="submit" id="add-member" class="button btn-ajout">Ajouter</button>
        </div>
    </div>
    <header>
        <h3>Réinitialiser la liste des présents :</h3>
    </header>
    <div class="content">
        <input type="button" id="reset-all-members" class="button btn-reset-present" value="Décocher tout" />
    </div>
</div>
<div id="member-list" class="cell-2-3 content">
    <header>
        <h3>Liste des joueurs</h3>
    </header>
    <table id="registred-members" class="table">
        <thead>
            <tr>
                <th>N°</th>
                <th>Nom</th>
                <th>Habitués</th>
                <th>Sup</th>
            </tr>
            </thead>
        <tbody>
            <?php foreach (Members::members_list() as $member): ?>
                <?php $checked = $member['fav'] ? ' checked' : ''; ?>
                <tr>
                    <td><?= $member['id'] ?></td>
                    <td><?= $member['name'] ?></td>
                    <td><input type="checkbox" data-id="<?= $member['id'] ?>" class="fav-member"<?= $checked ?> /></td>
                    <td><button type="button" id="<?= $member['id'] ?>" class="icon-button delete-member"><i class="fa fa-fw fa-lg fa-square-xmark error"></i></button></td>
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