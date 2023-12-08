<div class="del-all-manches">
    <header>
        <h3>Supprimer toutes les manches :</h3>
    </header>
    <div class="content">
        <button class="submit button" type="submit" id="delete-all-manches" name="all_games">Tout supprimer</button>
    </div>
</div>
<div id="manches-list" class="content">
    <header>
        <h3>Supprimer une manche</h3>
    </header>
    <table id="table_liste_manches" class="table">
        <thead>
            <tr>
                <th>N°</th>
                <th>Partie</th>
                <th>Manche</th>
                <th>Suppr</th>
            </tr>
            </thead>
        <tbody>
            <?php foreach (Rounds::rounds_list() as $round):?>
                <tr>
                    <td><?= $round['id'] ?></td>
                    <td><?= $round['party_id'] ?></td>
                    <td><?= $round['i_order'] ?></td>
                    <td><button type="submit" id="<?= $round['id'] ?>" class="button btn-sup-manche" /><i class="fa fa-fx fa-square-xmark error"></i></button></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>