<!-- <div class="del-all-manches">
    <header>
        <h3>Supprimer toutes les parties :</h3>
    </header>
    <div class="content">
        <button class="submit button" type="submit" id="remove-all-rounds" name="all_games">Tout supprimer</button>
    </div>
</div> -->
<div id="rounds-list" class="content">
    <header>
        <h3>Supprimer une partie</h3>
    </header>
    <div class="cell-flex cell-columns-2">
        <?php foreach (Days::days_list() as $day):?>
            <table class="table">
                <caption>Journée <?= $day['id'] ?> du <?= $day['date'] ?></caption>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Partie</th>
                        <th></th>
                    </tr>
                    </thead>
                <tbody>
                    <?php foreach (Rounds::day_rounds_list($day['id']) as $round):?>
                        <tr>
                            <td><?= $round['id'] ?></td>
                            <td><?= $round['i_order'] ?></td>
                            <td>
                                <button type="submit" 
                                        data-day_id="<?= $round['day_id'] ?>"
                                        data-round_id="<?= $round['id'] ?>"
                                        data-redirect="#rounds"
                                        class="icon-button remove-round" />
                                    <i class="fa fa-fx fa-lg fa-square-xmark error"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php endforeach ?>
    </div>
</div>