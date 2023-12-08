<section>
    <header class="section-header">
        <h1>Sélection des joueurs présents</h1>
    </header>
    <div class="cell-flex cell-columns-2">
        <article class="content">
            <table id="table_select_joueurs" class="table">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nom</th>
                        <th>Habitués</th>
                        <th>Choisir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (Joueurs::liste_joueurs_connus() as $joueur): ?>
                        <?php
                            $checked = $joueur['present'] ? ' checked' : '';
                            $fav = $joueur['fav'] ? '<i class="fa fa-fw fa-star"></i>' : '<i class="far fa-fw fa-star"></i>';
                        ?>
                        <tr>
                            <td><?= $joueur['id'] ?></td>
                            <td><?= $joueur['nom'] ?></td>
                            <td><?= $fav ?></td>
                            <td><input type="checkbox" id="<?= $joueur['id'] ?>" class="checkbox-choix-joueur"<?= $checked ?> /></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <div class="line flex-between">
                <span>&nbsp;</span>
                <input type="button" id="btn_valid_present" onclick="location.reload();" class="button submit" value="Valider les présents" />
                <input type="button" id="reset-all-players" class="button btn-reset-present" value="Décocher tout" />
            </div>
        </article>
        <article class="content">
            <header>
                <h3><?= count(Joueurs::liste_joueurs_presents()); ?> joueurs présents</h3>
            </header>
            <table id="table_joueurs_presents" class="table">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nom</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (Joueurs::liste_joueurs_presents() as $present): ?>
                        <tr>
                            <td><?= $present['id'] ?></td>
                            <td><?= $present['nom'] ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </article>
    </div>
</section>
