<?php
    $title = 'Accueil';
    require_once('./functions/header.php');
   
    // automatic installation of database and tables
    install::create_database();
    install::create_players_table();
    install::insert_data_players();
?>
    <section>
        <header class="section-header"><h1>Présentation du logiciel</h1></header>
        <article>
            <header><h3>Configuration</h3></header>
            <div class="content">On peut ajouter ou supprimer des joueurs</div>
        </article>
        <article>
            <header><h3>Sélection</h3></header>
            <div class="content">On sélectionne les joueurs présents pour la séance</div>
        </article>
        <footer></footer>
    </section>
<?php
require_once('./functions/footer.php');
?>

