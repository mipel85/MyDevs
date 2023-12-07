<?php
    require_once('./classes/joueurs.class.php');
    require_once('./classes/parties.class.php');
    require_once('./classes/manches.class.php');

    // Parties
    $today = date('d-m-Y');
    $date = [];
    foreach(Parties::liste_parties() as $values)
    {
        $date[] = $values['date'];
    }
    $disabled_partie = $hidden_party = ''; 
    $label_partie = 'Partie du jour';
    if (in_array($today, $date)) {
        $disabled_partie = ' disabled';
        $hidden_party = ' hidden';
        $label_partie = 'La partie du '.$today.' a été initialisée.';
    }
    
    // Rounds
    // get j_id
    $party = count(Parties::liste_parties());
    $j_id = $party ? Parties::partie_id($today) : '';
    // set i_order
    $i_order = count(Manches::manche_i_order($j_id)) + 1;
    // get players number
    $nbj = count(Joueurs::liste_joueurs_presents());
    // en/disable add button
    $disabled_manche = $hidden_manche = '';
    if ($i_order > 4 || $nbj < 8) {
        $disabled_manche = ' disabled';
        $hidden_manche = ' hidden';
    }
    // set label
    $label_manche = 'Ajouter la manche ' . $i_order . ' avec les ' . $nbj . ' participant.e.s sélectionné.e.s : ';
    if ($i_order > 4) $label_manche = 'Le nombre maximum de manches est atteint. ';
    if ($nbj < 8) $label_manche = 'Il faut sélectionner au moins 8 participant.e.s pour créer une manche.';
    // dev 
    // echo'<pre>';print_r('j_id = ' . $j_id);echo'</pre>';
    // echo'<pre>';print_r('i_order = ' . $i_order);echo'</pre>';
    // echo'<pre>';print_r(Manches::liste_partie_manches($j_id));echo'</pre>';
?>
<div id="partie_ajoutee" class="message-helper bgc-full success hidden">La partie a bien été ajoutée.</div>
<div id="manche_ajoutee" class="message-helper bgc-full success hidden">La manche <?= $i_order ?> a bien été ajoutée.<br /> La page va être rechargée.</div>
<section>
    <header class="section-header">
        <h1>Création</h1>
    </header>
    <article class="cell-flex cell-columns-2">
        <div class="content">
            <div id="add-partie">
                <header class="<?= $hidden_party ?>">
                    <h3>Initialiser une Partie :</h3>
                    <a href="index.php?page=config#manches"><i class="fa fa-cog"></i></a>
                </header>
                <label for="date_partie"><?= $label_partie ?></label>
                <input type="hidden" id="date_partie" name="date_partie" value="" />
                <button class="submit button<?= $hidden_party ?>" type="submit" id="add_partie" name="day"<?= $disabled_partie ?>>Ajouter</button>
            </div>
            <div id="add-manche" class="hidden">
                <header>
                    <h3>Créer une manche :</h3>
                    <a href="index.php?page=config#manches"><i class="fa fa-cog"></i></a>
                </header>
                <label for="choix_partie"><?= $label_manche ?></label>
                <button
                        class="submit button<?= $hidden_manche ?>"
                        data-j_id="<?= $j_id ?>"
                        data-i_order="<?= $i_order ?>"
                        data-nbj="<?= $nbj ?>"
                        id="add_manche"
                        name="round"
                        <?= $disabled_manche ?>>
                    Ajouter
                </button>
            </div>
        </div>
        <div id="rounds-list">
            <?php 
                foreach(Manches::liste_partie_manches($j_id) as $values)
                {
                    echo '
                        <article>
                            <header>
                                <h3>Manche ' . $values['i_order'] . '-' . $values['j_id'] . '</h3>
                            </header>';
                    // require_once('./functions/teams.manager.php');
                    echo '</article> ';
                }
            ?>
        </div>
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
    </article>
</section>

