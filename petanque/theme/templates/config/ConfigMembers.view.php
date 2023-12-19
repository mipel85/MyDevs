<div id="add-joueur" class="cell-1-3">
    <header>
        <h3>Ajouter un joueur</h3>
    </header>
    <div id="config_saisie">
        <label>Nom du joueur : </label>
        <input type="text" id="member_name" class="input add-name" />
        <div class="line align-center">
            <button type="submit" id="add-member" class="button">Ajouter</button>
        </div>
    </div>
</div>
<div id="member-list" class="cell-2-3 content">
    <header>
        <h3>Liste des joueurs</h3>
    </header>
    <table id="registred-members" class="table">  <!-- -->
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
                    $fav = $member['fav'] ? '<i class="fa fa-fw fa-star"></i>' : '<i class="far fa-fw fa-star"></i>';
                    $edit_check = $member['edit'] ? ' checked' : '';
                    $edit_class = $member['edit'] ? ' bgc-notice change-button' : ' edit-button';
                    $button_class = $member['edit'] ? ' change-button' : ' edit-button';
                    $edit_readonly = $member['edit'] ? '' : ' readonly';
                    $edit_icon = $member['edit'] ? 'Valider' : 'Modifier'
                ?>
                <tr>
                    <td><?= $member['id'] ?></td>
                    <td>
                        <span class="hidden"><?= $member['name'] ?></span>
                        <div class="flex-between-center">
                            <input size="15"<?= $edit_readonly ?> type="text" class="input member-name<?= $edit_class ?>" value="<?=$member['name']?>">
                            <button 
                                    data-member_id="<?= $member['id'] ?>"
                                    class="change-name button<?= $button_class ?>" 
                                    name="edit-<?= $member['id'] ?>">
                                <?= $edit_icon ?>
                            </button>
                        </div>
                    </td>
                    <td class="fav-list-member"><?= $fav ?></td>
                    <td><button type="button" id="<?= $member['id'] ?>" class="icon-button remove-member"><i class="fa fa-fw fa-lg fa-square-xmark error"></i></button></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>