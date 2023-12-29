<?php
require_once('./classes/Members.class.php');
require_once('./controllers/Rules.controller.php');

$c_several_players = count(Members::selected_members_list()) > 1;
$players_number = count(Members::selected_members_list());
?>
<section>
    <header class="section-header flex-between-center">
        <h1><?= $lang['members.title'] ?></h1>
        <div>
            <span class="text-italic">
                <?= $c_several_players ?
                    str_replace(':number', $players_number, $lang['members.selected.members']) :
                    str_replace(':number', $players_number, $lang['members.selected.member']) 
                ?>
            </span> - 
            <span class="text-italic"><?= rules(count(Members::selected_members_list())) ?></span>
        </div>
        <div>
            <div class="modals">
                <div class="modal-container">
                    <button type="button" id="display-quick-buttons" class="button modal-button"><?= $lang['members.quick.select']?></button>
                    <article id="selected-members" class="modal-content hidden">
                        <header class="flex-between">
                            <h3 class=""><?= $lang['members.quick.select.modal'] ?></h3>
                            <button type="submit" class="icon-button close-modal-button" data-tooltip="left" aria-label="<?= $lang['common.close'] ?>"><i class="fa fa-fw fa-square-xmark error"></i></button>
                        </header>
                        <div id="quick-list" class="content line cell-flex cell-columns-2">
                            <button type="button" id="reset-all-favs" class="button btn-reset-present full-warning"><?= $lang['members.quick.init.favs'] ?></button>
                            <button type="button" id="select-all-favs" class="button"><?= $lang['members.quick.select.favs'] ?></button>
                            <button type="button" id="unselect-all-members" class="button btn-reset-present"><?= $lang['members.quick.unselect.all'] ?></button>
                            <button type="button" id="select-all-members" class="button btn-reset-present"><?= $lang['members.quick.select.all'] ?></button>
                        </div>
                    </article>
                </div>
                <div class="modal-container">
                    <button type="button" id="display-selected-members" class="button full-success modal-button"><?= $lang['members.display'] ?></button>
                    <article id="selected-members" class="modal-content hidden">
                        <header class="flex-between">
                            <h3 class="selected-number"><?= $lang['members.display.none'] ?></h3>
                            <button class="icon-button close-modal-button" data-tooltip="left" aria-label="<?= $lang['common.close'] ?>"><i class="fa fa-fw fa-square-xmark error"></i></button>
                        </header>
                        <div id="selected-members-list" class="content line cell-flex cell-columns-6"></div>
                    </article>
                </div>
            </div>
        </div>
    </header>
    <article class="content">
        <span id="error-4" class="message-helper full-error floatting<?php if (count(Members::selected_members_list()) >= 4): ?> hidden<?php endif ?>">
            <?= $lang['members.alert.4'] ?>
        </span>
        <span id="error-7" class="message-helper full-error floatting<?php if (count(Members::selected_members_list()) != 7): ?> hidden<?php endif ?>">
            <?= $lang['members.alert.7'] ?>
        </span>
        
        <div id="all-members-list" class="cell-flex cell-columns-6">
            <?php foreach (Members::members_list() as $member): ?>
                <?php
                    $checked_present = $member['present'] ? ' checked' : '';
                    $present_icon = $member['present'] ? '<i class="fa fa-sm fa-check"></i>' : '';
                    $present_sort = $member['present'] ? '1' : '0';
                    $checked_fav = $member['fav'] ? ' checked' : '';
                    $fav_icon = $member['fav'] ? '<i class="fa fa-fw fa-star"></i>' : '<i class="far fa-fw fa-star"></i>';
                    $fav_sort = $member['fav'] ? '1' : '0';
                ?>
                <div class="row-item">
                    <div class="icon-checkbox present-checkbox">
                        <label for="present-<?= $member['id'] ?>" class="checkbox" id="label-present-<?= $member['id'] ?>">
                            <input data-present_id="<?= $member['id'] ?>" type="checkbox" name="present-<?= $member['id'] ?>" id="present-<?= $member['id'] ?>" class="present-member"<?= $checked_present ?>>
                            <span><?= $present_icon ?></span>
                        </label>
                    </div>
                    <div class="flex-main"><?= $member['name'] ?></div>
                    <div class="small member-id"><?= $member['id'] ?></div>
                    <div class="icon-checkbox fav-checkbox">
                        <label for="fav-<?= $member['id'] ?>" class="checkbox" id="label-fav-<?= $member['id'] ?>">
                            <input data-fav_id="<?= $member['id'] ?>" type="checkbox" name="fav-<?= $member['id'] ?>" id="fav-<?= $member['id'] ?>" class="fav-member"<?= $checked_fav ?>>
                            <span><?= $fav_icon ?></span>
                        </label>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </article>
</section>

<script>
    $(document).ready(function() {
        // change fav status, icon and color before reload
        $('.fav-member').each(function() {
            $(this).on('click', function() {
                if ($(this).is(":checked")) {
                    $(this).next('span').html('<i class="fa fa-fw fa-star"></i>');
                    $(this).removeAttr('checked');
                }
                else {
                    $(this).next('span').html('<i class="far fa-fw fa-star"></i>');
                    $(this).attr('checked');
                }
            });
        });
        // change member selection status, icon and color before reload
        $('.present-member').each(function() {
            $(this).on('click', function() {
                if ($(this).is(":checked")) {
                    $(this).next('span').html('<i class="fa fa-sm fa-check"></i>');
                    $(this).removeAttr('checked');
                }
                else {
                    $(this).next('span').html('');
                    $(this).attr('checked');
                }
            });
        });

        // Reorder horizontal order to vertical
        $(document).ready(function() { rowtocolumn('#all-members-list', '.row-item', 'row-col', 6); });
    });


</script>
