<section>
    <header class="section-header">
        <h1>Sélection des joueurs présents</h1>
    </header>
    <div class="cell-flex cell-columns-2">
        <article class="content">
            <table id="select-players" class="table">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nom</th>
                        <th>Habitués</th>
                        <th>Choisir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (Players::players_list() as $player): ?>
                        <?php
                            $checked = $player['present'] ? ' checked' : '';
                            $fav = $player['fav'] ? '<i class="fa fa-fw fa-star"></i>' : '<i class="far fa-fw fa-star"></i>';
                        ?>
                        <tr>
                            <td><?= $player['id'] ?></td>
                            <td><?= $player['name'] ?></td>
                            <td><?= $fav ?></td>
                            <td><input type="checkbox" id="<?= $player['id'] ?>" class="checkbox-choix-joueur"<?= $checked ?> /></td>
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
        <article id="selected-players" class="content">
            <header>
                <h3><?= count(Players::present_players_list()); ?> joueurs présents</h3>
            </header>
            <table class="table">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nom</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (Players::present_players_list() as $present): ?>
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
