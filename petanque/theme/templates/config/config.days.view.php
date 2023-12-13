<div id="del-all" class="flex-between-center">
    <header>
        <span class="description">La suppression de toutes les journées supprime également toutes les parties, équipes, rencontres, scores et classements.</span>
        <button class="submit button" type="submit" id="remove-all-days" name="all_games">Supprimer toutes les journées</button>
    </header>
</div>
<div id="days-list" class="content">
    <span class="description">La suppression d'une journée supprime également toutes les parties, équipes, rencontres, scores et classements <strong>de la journée</strong>.</span>
    <table id="days_list" class="table">
        <thead>
            <tr>
                <th>N°</th>
                <th>Date</th>
                <th>Nb de terrains</th>
                <th>Liste des terrains</th>
                <th>Suppr</th>
            </tr>
            </thead>
        <tbody>
            <?php foreach (Days::days_list() as $day): ?>
                <tr>
                    <td><?= $day['id'] ?></td>
                    <td><?= $day['date'] ?></td>
                    <td>
                        <input data-fields_number="" type="number" name="" value="<?= $day['fields_number'] ?>">
                        <button type="submit" 
                                data-id="<?= $day['id'] ?>"
                                class="submit-button update-fields-number" />
                            <i class="fa fa-fx fa-lg fa-rotate warning"></i>
                        </button>
                    </td>
                    <td>
                        <button type="submit" 
                                data-id="<?= $day['id'] ?>"
                                class="submit-button update-fields-list" />
                            <i class="fa fa-fx fa-lg fa-rotate warning"></i>
                        </button>
                    </td>
                    <td><button type="submit" id="<?= $day['id'] ?>" class="submit-button remove-day" /><i class="fa fa-fx fa-lg fa-square-xmark error"></i></button></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>