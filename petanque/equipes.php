<?php
$title = 'équipes';
require_once('./functions/header.php');
?>
<section></section>
    <header class="section-header">
        <h1>Création des équipes</h1>
    </header>
    <article class="content">
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
                    foreach (Joueurs::liste_joueurs_presents() as $joueur)
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
    <footer></footer>
</section>
<?php
require_once('./functions/footer.php');
?>
