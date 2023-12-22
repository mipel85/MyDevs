<div id="del-all">
    <div class="line">
        <div class="content flex-inline-center">
            <button class="submit button" type="submit" id="remove-all-days" name="all_games">Supprimer toutes les parties</button>
            <span class="description">La suppression de toutes les journées supprime également toutes les parties, équipes, rencontres, scores et classements.</span>
        </div>
    </div>
</div>
<div id="parties-list" class="content">
    <table id="parties_list" class="table">
        <caption>
            <span class="description">La suppression d'une journée supprime également toutes les parties, équipes, rencontres, scores et classements <strong>de la journée</strong>.</span>
        </caption>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th></th>
            </tr>
            </thead>
        <tbody>
            <?php foreach (Days::days_list() as $partie): ?>
                <tr>
                    <td><?= $partie['id'] ?></td>
                    <td><?= $partie['date'] ?></td>
                    <td><button type="submit" id="<?= $partie['id'] ?>" class="icon-button remove-day" /><i class="fa fa-fx fa-lg fa-square-xmark error"></i></button></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>