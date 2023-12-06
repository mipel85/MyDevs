<?php
$title = 'Configuration';
require_once('./functions/header.php');
?>
    <section>
        <header class="section-header">
            <h1>Gestion des joueurs</h1>
        </header>
        <div class="cell-flex cell-columns-2">
            <article id="add-player" class="cell-1-3 content">
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
            </article>
            <article id="player-list" class="cell-2-3 content">
                <header>
                    <h3>Liste des joueurs</h3>
                </header>
                <table id="table_joueurs_connus" class="table">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nom</th>
                            <th>Sup</th>
                        </tr>
                        </thead>
                    <tbody>
                        <?php
                            foreach (Joueurs::liste_joueurs_connus() as $joueur)
                            {
                                echo '<tr>
                                    <td>' . $joueur['id'] . '</td>
                                    <td>' . $joueur['nom'] . '</td>
                                    <td><input type="button" id="' . $joueur['id'] . '" class="button btn-sup-joueur" /></td>
                                </tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </article>
        </div>
    </section>
<?php
require_once('./functions/footer.php');
?>