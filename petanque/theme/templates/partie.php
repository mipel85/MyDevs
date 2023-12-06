<?php
    require_once('./classes/joueurs.class.php');
    require_once('./classes/parties.class.php');
    require_once('./classes/manches.class.php');
?>
<section>
    <header class="section-header">
        <h1>Création</h1>
    </header>
    <div class="cell-flex cell-columns-2">
        <article>
            <header>
                <h3>Initialiser une Partie :</h3>
            </header>
            <div class="content">
                <label for="date_partie">Partie du jour</label>
                <input type="hidden" id="date_partie" name="date_partie" value="" />
                <input class="submit button" type="submit" id="add_partie" name="day" value="Ajouter" />
            </div>
            <header>
                <h3>Créer une manche :</h3>
            </header>
            <div class="content">
                <label for="choix_partie">Choix de la partie : </label>
                <select name="" id="choix_partie">
                    <option value="0"></option>
                    <!-- foreach des parties -->
                    <?php
                        foreach(Parties::liste_parties() as $values)
                        {
                            echo '<option value="'. $values['id'] . '">Journée du '. $values['date'] . '</option>';
                        }
                    ?>
                </select>
                <input class="submit button" type="submit" id="add_manche" name="round" value="Ajouter" />
            </div>
        </article>
        <script>
            const date = new Date(), d = date.getDate(), m = date.getMonth() + 1, y = date.getFullYear();
            const formatDate = d + '-' + m + '-' + y;
            document.getElementById('date_partie').value = formatDate;
            console.log(formatDate);
        </script>
    </div>
</section>

