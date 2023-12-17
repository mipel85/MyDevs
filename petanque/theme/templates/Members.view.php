<?php
require_once('./classes/Members.class.php');
require_once('./controllers/Rules.controller.php');
?>
<section>
    <header class="section-header flex-between-center">
        <h1>Sélection des joueurs</h1>
        <div class="line">
            <button type="button" id="reset-all-members" class="button btn-reset-present">Décocher tous<br />les présents</button>
            <div class="modal-container">
                <button type="button" id="display-selected-members" class="button full-success modal-button">Afficher la liste<br />des présents</button>
                <article id="selected-members" class="modal-content hidden">
                    <header class="flex-between">
                        <h3 class="selected-number">Aucun joueur sélectionné</h3>
                        <button type="submit" class="icon-button close-modal-button error"><i class="fa fa-fw fa-square-xmark"></i></button>
                    </header>
                    <div id="selected-members-list" class="content line"></div>
                </article>
            </div>
        </div>
    </header>
    <article class="content">
        <span id="error-4" class="message-helper full-error floatting<?php if (count(Members::selected_members_list()) >= 4): ?> hidden<?php endif ?>">
            Moins de 4 joueurs n'est pas une sélection valide pour créer un nombre d'équipes pair de 2 et 3 joueurs.
        </span>
        <span id="error-7" class="message-helper full-error floatting<?php if (count(Members::selected_members_list()) != 7): ?> hidden<?php endif ?>">
            7 joueurs n'est pas une sélection valide pour créer un nombre d'équipes pair de 2 et 3 joueurs.
        </span>
        <!-- <div id="display-members-list" class="cell-flex cell-columns-5"></div> -->
        <div id="members-list-inline" class="cell-flex cell-columns-5">
            <?php foreach (Members::members_list() as $member): ?>
                <?php
                    $checked_present = $member['present'] ? ' checked' : '';
                    $present_icon = $member['present'] ? '<i class="fa fa-sm fa-check"></i>' : '';
                    $present_sort = $member['present'] ? '1' : '0';
                    $checked_fav = $member['fav'] ? ' checked' : '';
                    $fav_icon = $member['fav'] ? '<i class="fa fa-fw fa-star"></i>' : '<i class="far fa-fw fa-star"></i>';
                    $fav_sort = $member['fav'] ? '1' : '0';
                ?>
                <div class="display-member-row">
                    <div class="present-checkbox">
                        <label for="present-<?= $member['id'] ?>" class="checkbox" id="label-present-<?= $member['id'] ?>">
                            <input data-id="<?= $member['id'] ?>" type="checkbox" name="present-<?= $member['id'] ?>" id="present-<?= $member['id'] ?>" class="present-member"<?= $checked_present ?>>
                            <span><?= $present_icon ?></span>
                        </label>
                    </div>
                    <div class="flex-main"><?= $member['name'] ?></div>
                    <div class="small"><?= $member['id'] ?></div>
                    <div class="fav-checkbox">
                        <label for="fav-<?= $member['id'] ?>" class="checkbox" id="label-fav-<?= $member['id'] ?>">
                            <input data-id="<?= $member['id'] ?>" type="checkbox" name="fav-<?= $member['id'] ?>" id="fav-<?= $member['id'] ?>" class="fav-member"<?= $checked_fav ?>>
                            <span><?= $fav_icon ?></span>
                        </label>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </article>
</section>

<script>
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
</script>
