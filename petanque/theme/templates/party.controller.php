<?php
    require_once('./classes/joueurs.class.php');
    require_once('./classes/parties.class.php');
    require_once('./classes/manches.class.php');
    require_once('./functions/party.manager.php');

    
    // dev 
    // echo'<pre>';print_r('p_id = ' . $p_id);echo'</pre>';
    // echo'<pre>';print_r('i_order = ' . $i_order);echo'</pre>';
    // echo'<pre>';print_r(Manches::liste_partie_manches($p_id));echo'</pre>';
?>
<div id="partie_ajoutee" class="message-helper bgc-full success hidden">La partie a bien été ajoutée.<br /> La page va être rechargée.</div>
<div id="manche_ajoutee" class="message-helper bgc-full success hidden">La manche <?= $i_order ?> a bien été ajoutée.<br /> La page va être rechargée.</div>
<section>
    <header class="section-header">
        <h1>Création</h1>
    </header>
    <article class="cell-flex cell-columns-2">
        <div id="add-partie" class="content">
            <header class="<?= $hidden_party ?>">
                <h3>Initialiser une Partie :</h3>
                <!-- <a href="index.php?page=config#party"><i class="fa fa-cog"></i></a> -->
            </header>
            <label for="date_partie"><?= $label_partie ?></label>
            <input type="hidden" id="date_partie" name="date_partie" value="" />
            <button class="submit button<?= $hidden_party ?>" type="submit" id="add_partie" name="day"<?= $disabled_partie ?>>Ajouter</button>
        </div>
        <div id="add-manche" class="content hidden">
            <header>
                <h3>Créer une manche :</h3>
                <!-- <a href="index.php?page=config#manches"><i class="fa fa-cog"></i></a> -->
            </header>
            <label for="choix_partie"><?= $label_manche ?></label>
            <button
                    class="submit button<?= $hidden_manche ?>"
                    data-p_id="<?= $p_id ?>"
                    data-i_order="<?= $i_order ?>"
                    data-nbj="<?= $nbj ?>"
                    id="add_manche"
                    name="round"
                    <?= $disabled_manche ?>>
                Ajouter
            </button>
        </div>
    </article>
    <article class="cell-flex cell-columns-2">
        <div id="rounds-list">
            <?php 
                foreach(Manches::liste_partie_manches($p_id) as $values)
                {
                    echo '
                        <div>
                            <header>
                                <h3>Manche ' . $values['i_order'] . ' - Équipes</h3>
                            </header>';
                            // require_once('./functions/teams.manager.php');
                    echo '</div> ';
                }
            ?>
        </div>
        <div id="games-list">
            <?php 
                foreach(Manches::liste_partie_manches($p_id) as $values)
                {
                    echo '
                        <div>
                            <header>
                                <h3>Manche ' . $values['i_order'] . ' - Matches</h3>
                            </header>';
                            // require_once('./functions/teams.manager.php');
                    echo '</div> ';
                }
            ?>
        </div>
    </article>
        <script>
            // set today format
            let date = new Date(), d = date.getDate(), m = date.getMonth() + 1, y = date.getFullYear();
            if (d < 10) d = '0' + d;
            if (m < 10) m = '0' + m;
            const formatDate = d + '-' + m + '-' + y;
            // send today to hidden input of partie
            document.getElementById('date_partie').value = formatDate;

            if ($('#add_partie').attr('disabled'))
                $('#add-manche').removeClass('hidden');
        </script>
</section>

