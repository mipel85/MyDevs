<div id="del-all">
    <div class="line">
        <div class="content flex-inline-center">
            <button class="submit button" type="submit" id="remove-all-days" name="all_games"><?= $lang['config.days.remove.all'] ?></button>
            <span class="description"><?= $lang['config.days.help.all'] ?></span>
        </div>
    </div>
</div>
<div id="parties-list" class="content">
    <table id="parties_list" class="table">
        <caption>
            <span class="description"><?= $lang['config.days.help'] ?></span>
        </caption>
        <thead>
            <tr>
                <th>ID</th>
                <th><?= $lang['config.days.date'] ?></th>
                <th></th>
            </tr>
            </thead>
        <tbody>
            <?php foreach (Days::days_list() as $partie): ?>
                <tr>
                    <td><?= $partie['id'] ?></td>
                    <td><?= $partie['date'] ?></td>
                    <td><button type="submit" id="<?= $partie['id'] ?>" data-tooltip="left" aria-label="<?= $lang['config.days.remove'] ?>" class="icon-button remove-day" /><i class="fa fa-fx fa-lg fa-square-xmark error"></i></button></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>