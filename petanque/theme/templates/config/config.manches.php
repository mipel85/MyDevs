<div class="del-all-manches">
    <header>
        <h3>Supprimer une manches :</h3>
    </header>
    <div class="content">
        <button class="submit button" type="submit" id="delete-all-manches" name="all_games">Tout supprimer</button>
    </div>
</div>
<div id="manches-list" class="content">
    <header>
        <h3>Liste des manches</h3>
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
            <?php foreach (Manches::liste_manches() as $manche):?>
                <tr>
                    <td><?= $manche['id'] ?></td>
                    <td><?= $manche['p_id'] ?></td>
                    <td><?= $manche['i_order'] ?></td>
                    <td><button type="submit" id="<?= $manche['id'] ?>" class="button btn-sup-manche" /><i class="fa fa-fx fa-square-xmark error"></i></button></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>