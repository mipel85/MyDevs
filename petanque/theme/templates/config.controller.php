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
            <div id="add-joueur" class="cell-1-3">
                <header>
                    <h3>Ajouter des joueurs</h3>
                </header>
                <div id="config_saisie">
                    <label>Nom du joueur : </label>
                    <input type="text" id="nom_joueur" class="nom-ajout" />
                    <div class="line align-center">
                        <input type="submit" id="btn_ajout" class="button btn-ajout" value="Ajouter" />
                    </div>
                </div>
            </div>
            <div id="player-list" class="cell-2-3 content">
                <header>
                    <h3>Liste des joueurs</h3>
                </header>
                <table id="table_joueurs_connus" class="table">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nom</th>
                            <th>Habitués</th>
                            <th>Sup</th>
                        </tr>
                        </thead>
                    <tbody>
                        <?php
                            foreach (Joueurs::liste_joueurs_connus() as $joueur)
                            {
                                $checked = $joueur['fav'] ? ' checked' : '';
                                echo '<tr>
                                    <td>' . $joueur['id'] . '</td>
                                    <td>' . $joueur['nom'] . '</td>
                                    <td><input type="checkbox" data-id="' . $joueur['id'] . '" class="btn-fav-joueur"' . $checked . ' /></td>
                                    <td><input type="button" id="' . $joueur['id'] . '" class="btn-sup-joueur" /></td>
                                </tr>';
                            }
                        ?>
                    </tbody>
                </table>
                <div class="line flex-between">
                    <span>&nbsp;</span>
                    <input type="button" id="btn_valid_favs" onclick="location.reload();" class="button submit" value="Valider les favoris" />
                    <input type="button" id="btn_reset_favs" class="button btn-reset-present" value="Décocher tout" />
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
            <div id="parties-list" class="cell-100 content">
                <header>
                    <h3>Liste des parties</h3>
                </header>
                <table id="table_parties" class="table">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                    <tbody>
                        <?php
                            foreach (Parties::liste_parties() as $partie)
                            {
                                echo '<tr>
                                    <td>' . $partie['id'] . '</td>
                                    <td>' . $partie['date'] . '</td>
                                </tr>';
                            }
                        ?>
                    </tbody>
                </table>
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

