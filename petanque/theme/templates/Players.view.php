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
            <table id="members-list" class="table">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nom</th>
                        <th>Habitués</th>
                        <th>Choisir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (Members::members_list() as $member): ?>
                        <?php
                            $checked = $member['present'] ? ' checked' : '';
                            $fav = $member['fav'] ? '<i class="fa fa-fw fa-star"></i>' : '<i class="far fa-fw fa-star"></i>';
                        ?>
                        <tr>
                            <td><?= $member['id'] ?></td>
                            <td><?= $member['name'] ?></td>
                            <td><?= $fav ?></td>
                            <td><input type="checkbox" id="<?= $member['id'] ?>" class="select-member"<?= $checked ?> /></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <div class="line flex-between">
                <span>&nbsp;</span>
                <input type="button" id="btn_valid_present" onclick="location.reload();" class="button submit" value="Valider les présents" />
                <input type="button" id="reset-all-members" class="button btn-reset-present" value="Décocher tout" />
            </div>
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
