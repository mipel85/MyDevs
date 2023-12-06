<section>
    <header class="section-header">
        <h1>Sélection des joueurs présents</h1>
    </header>
    <div class="cell-flex cell-columns-2">
        <article class="content">
            <table id="table_joueurs_connus" class="table">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nom</th>
                        <th>Choisir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach (Joueurs::liste_joueurs_connus() as $joueur)
                        {
                            $checked = '';
                            if ($joueur['present'])
                                $checked = ' checked';
                            echo '<tr>
                                <td>' . $joueur['id'] . '</td>
                                <td>' . $joueur['nom'] . '</td>
                                <td><input type="checkbox" id="' . $joueur['id'] . '" class="checkbox-choix-joueur"' . $checked . ' /></td>
                            </tr>';
                        }
                    ?>
                </tbody>
            </table>
            <div class="line flex-between">
                <span>&nbsp;</span>
                <input type="button" id="btn_valid_present" onclick="location.reload();" class="button submit" value="Valider les présents" />
                <input type="button" id="btn_reset_present" class="button btn-reset-present" value="Décocher tout" />
            </div>
        </article>
        <article class="content">
            <header>
                <h3>Joueurs présents</h3>
            </header>
            <table id="table_joueurs_presents" class="table">
                <caption><?= count(Joueurs::liste_joueurs_presents()); ?> joueurs</caption>
                <thead><tr><th>N°</th><th>Nom</th></tr></thead>
                <tbody>
                    <?php
                        foreach (Joueurs::liste_joueurs_presents() as $present)
                        {
                            echo '<tr>
                                <td>' . $present['id'] . '</td>
                                <td>' . $present['nom'] . '</td>
                            </tr>';
                        }
                    ?>
                </tbody>
            </table>
        </article>
    </div>
</section>
