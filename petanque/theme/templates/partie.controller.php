<?php
    require_once('./classes/joueurs.class.php');
    require_once('./classes/parties.class.php');
    require_once('./classes/manches.class.php');

    // check partie du jour déjà créée
    $today = date('d-m-Y');
    $liste = [];
    foreach(Parties::liste_parties() as $values)
    {
        $liste[] = $values['date'];
    }
    $disabled_partie = $hidden = ''; 
    $label_partie = 'Partie du jour';
    if (in_array($today, $liste)) {
        $disabled_partie = ' disabled';
        $hidden = ' hidden';
        $label_partie = 'La partie du jour est créée (<a class="small text-italic" href="./index.php?page=config#parties">Voir la liste</a>)';
    }
?>
<div id="partie_ajoutee" class="message-helper bgc-full success hidden">La partie a bien été ajoutée</div>
<section>
    <header class="section-header">
        <h1>Création</h1>
    </header>
    <article class="cell-flex cell-columns-2">
        <div class="content">
            <div id="add-partie">
                <header>
                    <h3>Initialiser une Partie :</h3>
                </header>
                <label for="date_partie"><?= $label_partie ?></label>
                <input type="hidden" id="date_partie" name="date_partie" value="" />
                <input class="submit button<?= $hidden ?>" type="submit" id="add_partie" name="day" value="Ajouter" ' . <?= $disabled_partie ?> . ' />
            </div>
            <div id="add-manche" class="hidden">
                <header>
                    <h3>Créer une manche :</h3>
                </header>
                <label for="choix_partie">Choix de la partie : </label>
                <select name="" id="choix_partie">
                    <option value="0"></option>
                    <?php
                        foreach(Parties::liste_parties() as $values)
                        {
                            echo '<option value="'. $values['id'] . '">Partie du '. $values['date'] . '</option>';
                        }
                    ?>
                </select>
                <input class="submit button" type="submit" id="add_manche" name="round" value="Ajouter" />
            </div>
        </div>
        <script>
            // set today format
            let date = new Date(), d = date.getDate(), m = date.getMonth() + 1, y = date.getFullYear();
            if (d < 10) d = '0' + d;
            if (m < 10) m = '0' + m;
            const formatDate = d + '-' + m + '-' + y;
            console.log(formatDate);
            // send today to hidden input of partie
            document.getElementById('date_partie').value = formatDate;

            if ($('#add_partie').attr('disabled'))
                $('#add-manche').removeClass('hidden');
        </script>
    </article>
</section>

