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
                <button type="button" id="display-selected-players" class="button full-success modal-button">Afficher la liste<br />des présents</button>
                <article id="selected-members" class="modal-content hidden">
                    <header class="flex-between">
                        <h3 class="selected-number"></h3>
                        <button type="submit" class="icon-button close-modal-button error"><i class="fa fa-fw fa-square-xmark"></i></button>
                    </header>
                    <div id="selected-members-list" class="content line"></div>
                </article>
            </div>
        </div>
    </header>
    <article class="content">
        <span class="error-4 message-helper full-error floatting<?php if (count(Members::selected_members_list()) >= 4): ?> hidden<?php endif ?>">
            Moins de 4 joueurs n'est pas une sélection valide pour créer un nombre d'équipes pair de 2 et 3 joueurs.
        </span>
        <span class="error-7 message-helper full-error floatting<?php if (count(Members::selected_members_list()) != 7): ?> hidden<?php endif ?>">
            7 joueurs n'est pas une sélection valide pour créer un nombre d'équipes pair de 2 et 3 joueurs.
        </span>
        
        <table id="members-list" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Habitué</th>
                    <th>Présent</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (Members::members_list() as $member): ?>
                    <?php
                        $checked_fav = $member['fav'] ? ' checked' : '';
                        $fav = $member['fav'] ? '<i class="fa fa-fw fa-star"></i>' : '<i class="far fa-fw fa-star"></i>';
                        $fav_sort = $member['fav'] ? '1' : '0';
                        $checked_player_in = $member['present'] ? ' checked' : '';
                        $present = $member['present'] ? '<i class="fa fa-sm fa-check"></i>' : '';
                        $present_sort = $member['present'] ? '1' : '0';
                    ?>
                    <tr>
                        <td><?= $member['id'] ?></td>
                        <td><?= $member['name'] ?></td>
                        <td class="fav-checkbox">
                            <span class="hidden-sort hidden"><?= $fav_sort ?></span>
                            <label for="fav-<?= $member['id'] ?>" class="checkbox">
                                <input data-id="<?= $member['id'] ?>" type="checkbox" id="fav-<?= $member['id'] ?>" class="fav-member"<?= $checked_fav ?> />
                                <span><?= $fav ?></span>
                            </label>
                        </td>
                        <td class="present-checkbox">
                            <span class="hidden-sort hidden"><?= $present_sort ?></span>
                            <label for="present-<?= $member['id'] ?>" class="checkbox">
                                <input data-id="<?= $member['id'] ?>" type="checkbox" id="present-<?= $member['id'] ?>" class="present-member"<?= $checked_player_in ?> />
                                <span><?= $present ?></span>
                            </label>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
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
