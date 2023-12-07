<div id="add-joueur" class="cell-1-3">
    <header>
        <h3>Ajouter des joueurs</h3>
    </header>
    <div id="config_saisie">
        <label>Nom du joueur : </label>
        <input type="text" id="nom_joueur" class="nom-ajout" />
        <div class="line align-center">
            <input type="submit" id="btn_ajout" class="button btn-ajout" value="Ajouter" />
        </div>
    </div>
</div>
<div id="player-list" class="cell-2-3 content">
    <header>
        <h3>Liste des joueurs</h3>
    </header>
    <table id="table_joueurs_connus" class="table">
        <thead>
            <tr>
                <th>N°</th>
                <th>Nom</th>
                <th>Habitués</th>
                <th>Sup</th>
            </tr>
            </thead>
        <tbody>
            <?php
                foreach (Joueurs::liste_joueurs_connus() as $joueur)
                {
                    $checked = $joueur['fav'] ? ' checked' : '';
                    echo '<tr>
                        <td>' . $joueur['id'] . '</td>
                        <td>' . $joueur['nom'] . '</td>
                        <td><input type="checkbox" data-id="' . $joueur['id'] . '" class="btn-fav-joueur"' . $checked . ' /></td>
                        <td><input type="button" id="' . $joueur['id'] . '" class="btn-sup-joueur" /></td>
                    </tr>';
                }
            ?>
        </tbody>
    </table>
    <div class="line flex-between">
        <span>&nbsp;</span>
        <input type="button" id="btn_valid_favs" onclick="location.reload();" class="button submit" value="Valider les favoris" />
        <input type="button" id="btn_reset_favs" class="button btn-reset-present" value="Décocher tout" />
    </div>
</div>