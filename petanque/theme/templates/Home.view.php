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
    <header class="section-header"><h2>Déroulement d'une journée</h2></header>
    <div class="cell-flex cell-columns-2">
        <article>
            <header class="flex-between-center">
                <h4>1°/ Joueurs présents</h4>
                <span class="description"><a href="index.php?page=members">Accéder à la sélection des membres</a></span>
            </header>
            <div class="content">
                <h5>Sélection des joueurs</h5>
                <ul>
                    <li><strong>Un nombre minimum de 4 joueurs (et différent de 7) est nécessaire pour acceder à l'initialisation d'une journée (2°) ou la création d'une partie (3°).</strong></li>
                    <li>On sélectionne les joueurs présents avant chaque partie avec la possibilité de faire une sélection rapide selon des filtres.</li>
                    <li>Le nombre de joueurs sélectionnés détermine automatiquement le nombre et le type d'équipes (doublettes/triplettes) et le nombre de terrains nécessaire. </li>
                    <li>Le logiciel privilegie un maximum de doublettes. Le nombre de triplettes est défini seulement pour qu'il y est un nombre pair d'équipe.</li>
                </ul>
                <h5>Définir les habitués</h5>
                <ul>
                    <li>En cliquant sur les étoiles à côté du nom des joueurs, on défini un joueur en tant qu'habitué ou non.</li>
                    <li>Étoile verte et pleine, le joueur est un habitué, étoile noire et vide le joueur ne l'est pas.</li>
                    <li>Un filtre de sélection rapide permet de sélectionner seulement les habitués</li>
                </ul>
            </div>
        </article>
        
        <article>
            <header class="flex-between-center">
                <h4>2°/ Initialisation d'une journée</h4>
            </header>
            <div class="content">
                <ul>
                    <li>Lorsque suffisamment de joueurs sont sélectionnés, l'onglet <strong>Gestion des parties</strong> est accessible.</li>
                    <li>L'initialisation d'une journée s'effectue automatiquement, chaque jour d'utilisation, lorsqu'on rejoint la page <strong>Gestion des parties</strong> pour la première fois.</li>
                </ul>
            </div>
        </article>
        
        <article>
            <header class="flex-between-center">
                <h4>3°/ Création d'une partie</h4>
            </header>
            <div class="content">
                <ul>
                    <li>Lorsque la journée est initialisée, l'encart de création de partie est accessible.</li>
                    <li>Avant chaque partie, on peut sélectionner le nombre et le choix des terrains.</li>
                    <li>Le bouton <strong>Créer la partie 1</strong> lance la génération automatique et aléatoire des équipes, puis des rencontres de la partie 1.</li>
                    <li>L'onglet <strong>Saisie des scores</strong> devient accessible.</li>
                    <li>le bouton de création des parties disparait jusqu'à ce qu'au moins un score soit validé sur la page <strong>Saisie des scores</strong>.</li>
                </ul>
            </div>
        </article>
        
        <article>
            <header class="flex-between-center">
                <h4>4°/ Scores</h4>
            </header>
            <div class="content">
                <h5>Mode automatique</h5>
                <ul>
                    <li>On sélectionne le champ du score de l'équipe perdante et on renseigne son score parmi la liste des boutons (0 à 12).</li>
                    <li>Le score de l'équipe gagnante se rempli automatiquement avec le score maximum (13).</li>
                    <li>Le score est validé uniquement après avoir cliqué sur le bouton <strong>Valider</strong> de la rencontre. On peut donc le modifier avec le même procédé tant que celui-ci n'a pas été validé.</li>
                    <li>Une fois validé le score peut encore être modifié en cliquant sur le bouton <strong>Modifier</strong>.</li>
                </ul>
                <h5>Mode Manuel</h5>
                En cas de nécessité de renseigner un score maximum différent de 13, le bouton <i class="fa fa-keyboard"></i> permet d'ouvrir à l'écriture manuelle, les champs de score des 2 équipes d'une rencontre.
            </div>
        </article>
        
        <article>
            <header class="flex-between-center"><h4>Classement</h4></header>
            <div class="content">
                En cours...
            </div>
        </article>
    </div>
    <footer></footer>
</section>