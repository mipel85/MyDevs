<div id="del-all">
    <header>
        <h3>Supprimer toutes les parties :</h3>
        <span class="description">Cette action supprime également toutes les manches et toutes les équipes.</span>
    </header>
    <div class="content">
        <button class="submit button" type="submit" id="remove-all-parties" name="all_games">Tout supprimer</button>
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
        <span class="description">Cette action supprime également toutes les manches et toutes les équipes de la partie.</span>
    </header>
    <table id="parties_list" class="table">
        <thead>
            <tr>
                <th>N°</th>
                <th>Date</th>
                <th>Suppr</th>
            </tr>
            </thead>
        <tbody>
            <?php foreach (Parties::parties_list() as $partie): ?>
                <tr>
                    <td><?= $partie['id'] ?></td>
                    <td><?= $partie['date'] ?></td>
                    <td><button type="submit" id="<?= $partie['id'] ?>" class="remove-button remove-party" /><i class="fa fa-fx fa-lg fa-square-xmark error"></i></button></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>