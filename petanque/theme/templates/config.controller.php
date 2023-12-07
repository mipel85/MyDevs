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
            <div id="del-all">
                <header>
                    <h3>Supprimer toutes les parties :</h3>
                </header>
                <div class="content">
                    <button class="submit button" type="submit" id="delete-all-parties" name="all_games">Tout supprimer</button>
                </div>
            </div>
            <div id="parties-list" class="content">
                <header>
                    <h3>Liste des parties</h3>
                </header>
                <table id="table_liste_parties" class="table">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Date</th>
                            <th>Suppr</th>
                        </tr>
                        </thead>
                    <tbody>
                        <?php
                            foreach (Parties::liste_parties() as $partie)
                            {
                                echo '<tr>
                                    <td>' . $partie['id'] . '</td>
                                    <td>' . $partie['date'] . '</td>
                                    <td><button type="submit" id="' . $partie['id'] . '" class="button btn-sup-partie" /><i class="fa fa-fx fa-square-xmark error"></i></button></td>
                                </tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </article>
        <article id="manches" class="tab-content cell-flex cell-columns-2">
            <div id="del-all">
                <header>
                    <h3>Supprimer toutes les manches :</h3>
                </header>
                <div class="content">
                    <button class="submit button" type="submit" id="delete-all-manches" name="all_games">Tout supprimer</button>
                </div>
            </div>
            <div id="manches-list" class="content">
                <header>
                    <h3>Liste des manches</h3>
                </header>
                <table id="table_liste_manches" class="table">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Partie</th>
                            <th>Manche</th>
                            <th>Suppr</th>
                        </tr>
                        </thead>
                    <tbody>
                        <?php
                            foreach (Manches::liste_manches() as $manche)
                            {
                                echo '<tr>
                                    <td>' . $manche['id'] . '</td>
                                    <td>' . $manche['j_id'] . '</td>
                                    <td>' . $manche['i_order'] . '</td>
                                    <td><button type="submit" id="' . $manche['id'] . '" class="button btn-sup-manche" /><i class="fa fa-fx fa-square-xmark error"></i></button></td>
                                </tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </article>
    </div>
</section>

<script></script>

