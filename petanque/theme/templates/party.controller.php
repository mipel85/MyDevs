<?php

require_once('./classes/Players.class.php');
require_once('./classes/Parties.class.php');
require_once('./classes/Rounds.class.php');
require_once('./functions/party.manager.php');

?>
<div id="partie_ajoutee" class="message-helper bgc-full success hidden">La partie a bien été ajoutée.<br /> La page va être rechargée.</div>
<div id="manche_ajoutee" class="message-helper bgc-full success hidden">La manche <?= $i_order ?> a bien été ajoutée.<br /> La page va être rechargée.</div>
<section>
    <header class="section-header">
        <h1>Création</h1>
    </header>
    <article class="cell-flex cell-columns-2">
        <div id="party-manager" class="content">
            <header class="<?= $hidden_party ?>">
                <h3>Initialiser une Partie :</h3>
                <!-- <a href="index.php?page=config#party"><i class="fa fa-cog"></i></a> -->
            </header>
            <label for="party-date"><?= $label_partie ?></label>
            <input type="hidden" id="party-date" name="party-date" value="" />
            <button class="submit button<?= $hidden_party ?>" type="submit" id="add-party" name="day"<?= $disabled_partie ?>>Ajouter</button>
        </div>
        <div id="add-round" class="content hidden">
            <header>
                <h3>Créer une manche :</h3>
                <!-- <a href="index.php?page=config#manches"><i class="fa fa-cog"></i></a> -->
            </header>
            <label for="choix_partie"><?= $label_manche ?></label>
            <button
                    class="submit button<?= $hidden_manche ?>"
                    data-party_id="<?= $party_id ?>"
                    data-i_order="<?= $i_order ?>"
                    data-players_number="<?= $players_number ?>"
                    id="add_manche"
                    name="round"
                    <?= $disabled_manche ?>>
                Ajouter
            </button>
        </div>
    </article>
    <?php if($party_id): ?>
        <article class="cell-flex cell-columns-2">
            <div id="teams-list">
                <?php foreach(Rounds::party_rounds_list($party_id) as $values): ?>
                    <div>
                        <header>
                            <h3>Manche <?= $values['i_order'] ?> - Équipes</h3>
                        </header>
                    </div>
                <?php endforeach ?>
            </div>
            <div id="games-list">
                <?php foreach(Rounds::party_rounds_list($party_id) as $values): ?>
                    <div>
                        <header>
                            <h3>Manche <?= $values['i_order'] ?> - Matches</h3>
                        </header
                    </div>
                <?php endforeach; ?>
            </div>
        </article>
    <?php endif ?>
    <script>
        // set today format
        let date = new Date(), d = date.getDate(), m = date.getMonth() + 1, y = date.getFullYear();
        if (d < 10) d = '0' + d;
        if (m < 10) m = '0' + m;
        const formatDate = d + '-' + m + '-' + y;
        // send today to hidden input of partie
        document.getElementById('party-date').value = formatDate;

        if ($('#add-party').hasClass('hidden'))
            $('#add-round').removeClass('hidden');
    </script>
</section>

