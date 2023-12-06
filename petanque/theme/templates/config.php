<?php
    require_once('./classes/joueurs.class.php');
    require_once('./classes/parties.class.php');
    require_once('./classes/manches.class.php');
?>
<section>
    <header class="section-header">
        <h1>Administration</h1>
    </header>
    <div class="tabs-container">
        <div class="tabs-menu">
            <a data-trigger="joueurs" class="tab-trigger active-tab" onclick="openTab(event, 'joueurs');">Joueurs</a>
            <a data-trigger="parties" class="tab-trigger" onclick="openTab(event, 'parties');">Parties</a>
            <a data-trigger="manches" class="tab-trigger" onclick="openTab(event, 'manches');">Manches</a>
        </div>
        <article id="joueurs" class="tab-content active-tab cell-flex cell-columns-2">
            <div class="add-fav">
                <header>
                    <h3>Ajouter un joueur en favori :</h3>
                </header>
                <div class="content">
                    
                </div>
            </div>
            <div class="del-all">
                <header>
                    <h3>Supprimer tous les joueurs :</h3>
                </header>
                <div class="content">
                    <input class="submit button" type="submit" id="delete_all_joueurs" name="all_joueurs" value="Tout supprimer" />
                </div>
            </div>
        </article>
        <article id="parties" class="tab-content cell-flex cell-columns-2">
            <div class="del-one">
                <header>
                    <h3>Supprimer une partie :</h3>
                </header>
                <div class="content">
                    <label for="choix_partie">Partie du :</label>
                    <select name="" id="choix_partie">
                        <option value="0"></option>
                        <!-- foreach des parties -->
                        <?php
                            foreach(Parties::liste_parties() as $partie)
                            {
                                echo '<option value="'. $partie['id'] . '">Partie '. $partie['id'] . ' du '. $partie['date'] . '</option>';
                            }
                        ?>
                    </select>
                    <input class="submit button" type="submit" id="delete_partie" name="game" value="Supprimer" />
                </div>
            </div>
            <div class="del-all">
                <header>
                    <h3>Supprimer toutes les parties :</h3>
                </header>
                <div class="content">
                    <input class="submit button" type="submit" id="delete_all_parties" name="all_games" value="Tout supprimer" />
                </div>
            </div>
        </article>
        <article id="manches" class="tab-content">
            <header>
                <h3>Supprimer une manche :</h3>
            </header>
            <div class="content">
                <label for="choix_manche">Choix de la manche : </label>
                <select name="" id="choix_manche">
                    <option value="0"></option>
                    <!-- foreach des manches -->
                    <?php
                        foreach(Manches::liste_manches() as $manche)
                        {
                            echo '<option value="'. $manche['id'] . '">Manche '. $manche['id'] . ' de la Partie ' . $manche['j_id'] . ' du ' . $manche['date'] . '</option>';
                        }
                    ?>
                </select>
                <input class="submit button" type="submit" id="delete_manche" name="round" value="Supprimer" />
            </div>
        </article>
    </div>
</section>

