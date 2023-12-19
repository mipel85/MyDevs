<div id="member-list" class="content">
    <header class="flex-between-center">
        <h3>Liste des membres</h3>
        <div class="content">
            <label>Ajouter un membre : </label>
            <input type="text" id="add-member-name" class="input add-name" />
            <button type="submit" id="add-member" class="button">Ajouter</button>
        </div>
    </header>
    <div id="registred-members-list" class="cell-flex cell-columns-5">
        <?php foreach (Members::members_list() as $member): ?>
            <?php 
                $fav = $member['fav'] ? '<i class="fa fa-fw fa-star success"></i>' : '';
            ?>
            <div class="row-item pos-relative">
                <div class="pos-absolute"><?= $fav ?></div>
                <div class="flex-main">
                    <input size="12" readonly type="text" class="input member-name" value="<?=$member['name']?>">
                    <button 
                            data-member_id="<?= $member['id'] ?>"
                            class="change-name icon-button edit-button"
                            name="edit-<?= $member['id'] ?>">
                        <i class="fa fa-edit warning"></i>
                    </button>
                </div>
                <div class="flex-between-center">
                    <div class="small"><?= $member['id'] ?></div>
                    <div><button type="button" id="<?= $member['id'] ?>" class="icon-button remove-member"><i class="fa fa-fw fa-lg fa-square-xmark error"></i></button></div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        rowtocolumn('#registred-members-list', '.row-item', 'flex-main', 5);
    });
</script>

