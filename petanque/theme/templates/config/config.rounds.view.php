<!-- <div class="del-all-manches">
    <header>
        <h3>Supprimer toutes les manches :</h3>
    </header>
    <div class="content">
        <button class="submit button" type="submit" id="remove-all-rounds" name="all_games">Tout supprimer</button>
    </div>
</div> -->
<div id="rounds-list" class="content">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Journée</th>
                <th>Partie</th>
                <th>Suppression</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (Rounds::rounds_list() as $round):?>
                <tr>
                    <td><?= $round['id'] ?></td>
                    <td><?= $round['day_id'] ?> | <?= $round['date'] ?></td>
                    <td><?= $round['i_order'] ?></td>
                    <td>
                        <button type="submit" 
                                data-day_id="<?= $round['day_id'] ?>" 
                                data-round_id="<?= $round['id'] ?>" 
                                class="submit-button remove-round" />
                            <i class="fa fa-fx fa-lg fa-square-xmark error"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>