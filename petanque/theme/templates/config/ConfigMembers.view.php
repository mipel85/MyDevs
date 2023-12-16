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
</div>
<div id="member-list" class="cell-2-3 content">
    <header>
        <h3>Liste des joueurs</h3>
    </header>
    <table id="registred-members" class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Habitué</th>
                <th>Sup</th>
            </tr>
            </thead>
        <tbody>
            <?php foreach (Members::members_list() as $member): ?>
                <?php 
                    $checked = $member['fav'] ? ' checked' : ''; 
                    $fav = $member['fav'] ? '<i class="fa fa-fw fa-star"></i>' : '<i class="far fa-fw fa-star"></i>';
                ?>
                <tr>
                    <td><?= $member['id'] ?></td>
                    <td><?= $member['name'] ?></td>
                    <td class="fav-list-member"><?= $fav ?></td>
                    <td><button type="button" id="<?= $member['id'] ?>" class="icon-button remove-member"><i class="fa fa-fw fa-lg fa-square-xmark error"></i></button></td>
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