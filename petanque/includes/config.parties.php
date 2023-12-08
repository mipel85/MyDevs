<div id="del-all">
    <header>
        <h3>Supprimer toutes les parties :</h3>
        <span class="description">Cette action supprime également toutes les manches.</span>
    </header>
    <div class="content">
        <button class="submit button" type="submit" id="delete-all-parties" name="all_games">Tout supprimer</button>
    </div>
    <header>
        <h3>Réinitialiser la liste des présents :</h3>
    </header>
    <div class="content">
        <input type="button" id="reset-all-players" class="button btn-reset-present" value="Décocher tout" />
    </div>
</div>
<div id="parties-list" class="content">
    <header>
        <h3>Supprimer une partie</h3>
        <span class="description">Cette action supprime également toutes les manches de la partie.</span>
    </header>
    <table id="table_liste_parties" class="table">
        <thead>
            <tr>
                <th>N°</th>
                <th>Date</th>
                <th>Suppr</th>
            </tr>
            </thead>
        <tbody>
            <?php
                foreach (Parties::liste_parties() as $partie)
                {
                    echo '<tr>
                        <td>' . $partie['id'] . '</td>
                        <td>' . $partie['date'] . '</td>
                        <td><button type="submit" id="' . $partie['id'] . '" class="button btn-sup-partie" /><i class="fa fa-fx fa-square-xmark error"></i></button></td>
                    </tr>';
                }
            ?>
        </tbody>
    </table>
</div>