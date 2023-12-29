<div id="member-list" class="content">
    <header class="flex-between-center">
        <h3><?= $lang['config.members.title'] ?></h3>
        <div class="message-helper full-notice">
            <label><?= $lang['config.members.add'] ?></label>
            <input type="text" id="add-member-name" class="input add-name" />
            <button type="submit" id="add-member" class="button"><?= $lang['common.add'] ?></button>
        </div>
    </header>
    <div id="registred-members-list" class="cell-flex cell-columns-5">
        <?php foreach (Members::members_list() as $member): ?>
            <?php 
                $fav = $member['fav'] ? '<i class="fa fa-fw fa-star success"></i>' : '';
            ?>
            <div class="row-item pos-relative">
                <div class="pos-absolute"><?=$fav?></div>
                <div class="flex-main">
                    <input size="12" readonly type="text" class="input member-name" value="<?=$member['name']?>">
                    <button 
                            data-member_id="<?= $member['id'] ?>"
                            class="change-name icon-button edit-button"
                            name="edit-<?= $member['id'] ?>"
                            data-tooltip="right"
                            aria-label="<?= $lang['common.edit'] ?>">
                        <i class="fa fa-edit warning"></i>
                    </button>
                </div>
                <div class="flex-between-center">
                    <div class="small"><?= $member['id'] ?></div>
                    <div><button type="button" id="<?= $member['id'] ?>" data-tooltip="left" aria-label="<?= $lang['config.members.remove'] ?>" class="icon-button remove-member"><i class="fa fa-fw fa-lg fa-square-xmark error"></i></button></div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>

