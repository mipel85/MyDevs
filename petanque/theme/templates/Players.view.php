<?php
require_once('./classes/Members.class.php');
require_once('./controllers/Rules.controller.php');
?>
<section>
    <header class="section-header">
        <h1>Sélection des joueurs</h1>
    </header>
    <div class="cell-flex cell-columns-2">
        <article class="content">
            <div class="line flex-between">
                <span></span>
                <span>
                    <button type="button" id="btn_valid_present" onclick="location.reload();" class="button submit">Valider la liste<br />des présents</button>
                    <button type="button" id="reset-all-members" class="button btn-reset-present">Décocher tous<br />les présents</button>
                </span>
            </div>
            <table id="members-list" class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Habitué</th>
                        <th>Choisir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (Members::members_list() as $member): ?>
                        <?php
                            $checked_fav = $member['fav'] ? ' checked' : '';
                            $fav = $member['fav'] ? '<i class="fa fa-xs fa-star"></i>' : '<i class="far fa-xs fa-star"></i>';
                            $fav_sort = $member['fav'] ? '1' : '0';
                            $checked_player_in = $member['present'] ? ' checked' : '';
                            $present = $member['present'] ? '<i class="fa fa-xs fa-check"></i>' : '';
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
        <article id="selected-members" class="content">
            <header class="flex-between">
                <h3><?= count(Members::selected_members_list()); ?> joueurs sélectionnés</h3>
                <span class="description">Equipes proposées : <?= rules(count(Members::selected_members_list())); ?> </span>
            </header>
            <?php if (count(Members::selected_members_list()) < 4): ?>
                <span class="message-helper bgc-full error">Moins de 4 joueurs n'est pas une sélection valide pour créer un nombre d'équipes pair de 2 et 3 joueurs</span>
            <?php elseif (count(Members::selected_members_list()) == 7): ?>
                <span class="message-helper bgc-full error">7 joueurs n'est pas une sélection valide pour créer un nombre d'équipes pair de 2 et 3 joueurs</span>
            <?php endif ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nom</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (Members::selected_members_list() as $present): ?>
                        <tr>
                            <td><?= $present['id'] ?></td>
                            <td><?= $present['name'] ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </article>
    </div>
</section>

<script>
    $('.fav-member').each(function() {
        $(this).on('click', function() {
            if ($(this).is(":checked")) {
                $(this).next('span').html('<i class="fa fa-xs fa-star"></i>');
                $(this).removeAttr('checked');
            }
            else {
                $(this).next('span').html('<i class="far fa-xs fa-star"></i>');
                $(this).attr('checked');
            }
        });
    });
    $('.present-member').each(function() {
        $(this).on('click', function() {
            if ($(this).is(":checked")) {
                $(this).next('span').html('<i class="fa fa-xs fa-check"></i>');
                $(this).removeAttr('checked');
            }
            else {
                $(this).next('span').html('');
                $(this).attr('checked');
            }
        });
    });
</script>
