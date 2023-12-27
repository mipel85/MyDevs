<section>
    <header class="section-header"><h1>Présentation du logiciel</h1></header>
    <article>
        Ce logiciel permet de créer des parties de pétanque sur une journée, sur le principe de la mêlée en tenant compte des joueurs présents et des terrains disponibles.
        <br>La composition des équipes et des matches et l'attribution des terrains sont générées de façon aléatoire pour chaque partie.
    </article>
    <article>
        <header class="flex-between-center">
            <h4>Gestion des membres</h4>
            <span class="description"><a href="index.php?page=config">Accéder à la gestion des membres</a></span>
        </header>
        <div class="content">Cette page est disponible via l'icône en haut à droite (<i class="fa fa-cog"></i>). On peut y ajouter ou supprimer des joueurs.</div>
    </article>
    <footer></footer>
</section>
<section>
    <header class="setion-header"><h4>Menus</h4></header>
    <article>
        <ul>
            <li><strong>Accueil</strong> : donne les informations de base sur le fonctionnement du logiciel</li>
            <li><strong>Joueurs présent</strong> : Une fois les joueurs présents sélectionnés dans la liste des membres, on peut les marquer comme "habitués" s'ils sont présents régulièrement. </li>
            <li>
                <strong>Gestion des parties</strong> : dans ce menu, on peut choisir les numéros des terrains qui seront utilisés puis créer une partie qui prendra en compte les joueurs sélectionnés comme présents.
                La composition des équipes est alors générée automatiquement, puis le tableau des rencontres est affiché avec une affectation des terrains à utiliser.
            </li>
            <li><strong>Saisie des scores</strong> : Permet de saisir les scores des rencontres en sélectionnant le score du perdant, le gagnant prend 13 points automatiquement.</li>
            <li>
                <strong>Classement</strong> : On calcule la différence des points marqués entre gagnant et perdant. Exemple : l'équipe A gagne 13 à 8.
                Chaque joueur de cette équipe marque 13 points plus l'écart du score des perdants par rapport à 13 soit (13-8 = 5). Ce joueur marquera donc 13 + 5 soit 18 points. 
                Le perdant marquera 8 + (8-13 = -5) soit 8 -(-5) donc 3 points.
            </li>
        </ul>
        Pour une documentation plus détaillée n'hésitez pas à vous référer à la <a href="index.php?page=config#doc">documentation interne</a>
    </article>
    <footer></footer>
</section>