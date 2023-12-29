<?php

// Home
$lang['home.title'] = 'Présentation du logiciel';
$lang['home.hat'] = '
    Ce logiciel permet de créer des parties de pétanque sur une journée, sur le principe de la mêlée en tenant compte des joueurs présents et des terrains disponibles.
    <br />La composition des équipes et des matches et l\'attribution des terrains sont générées de façon aléatoire pour chaque partie.
';
$lang['home.config.title'] = 'Gestion des membres';
$lang['home.config.link'] = 'Accéder à la gestion des membres';
$lang['home.config.content'] = '
    Cette page est disponible via l\'icône en haut à droite (<i class="fa fa-cog"></i>). On peut y ajouter ou supprimer des joueurs.
';
$lang['home.menu.title'] = 'Menus';
$lang['home.menu.content'] = '
    <ul>
        <li><strong>Accueil</strong> : donne les informations de base sur le fonctionnement du logiciel</li>
        <li><strong>Joueurs présents</strong> : Une fois les joueurs présents sélectionnés dans la liste des membres, on peut les marquer comme "habitués" s\'ils sont présents régulièrement. </li>
        <li>
            <strong>Gestion des parties</strong> : dans ce menu, on peut choisir les numéros des terrains qui seront utilisés puis créer une partie qui prendra en compte les joueurs sélectionnés comme présents.
            La composition des équipes est alors générée automatiquement, puis le tableau des rencontres est affiché avec une affectation des terrains à utiliser.
        </li>
        <li><strong>Saisie des scores</strong> : Permet de saisir les scores des rencontres en sélectionnant le score du perdant, le gagnant prend 13 points automatiquement.</li>
        <li>
            <strong>Classement</strong> : On calcule la différence des points marqués entre gagnant et perdant. Exemple : l\'équipe A gagne 13 à 8.
            Chaque joueur de cette équipe marque 13 points plus l\'écart du score des perdants par rapport à 13 soit (13-8 = 5). Ce joueur marquera donc 13 + 5 soit 18 points. 
            Le perdant marquera 8 + (8-13 = -5) soit 8 -(-5) donc 3 points.
        </li>
    </ul>
    Pour une documentation plus détaillée, n\'hésitez pas à vous référer à la <a href="index.php?page=config#doc">documentation interne</a>
';

// Config
$lang['doc.lexicon.title'] = 'Lexique';
$lang['doc.lexicon.content'] = '
    <ul>
        <li><strong>Days</strong> = journée d\'activité.</li>
        <li><strong>Members</strong> = membre du club, devient <strong>Players</strong> une fois qu\'un score lui est attribué.</li>
        <li><strong>Teams</strong> = les équipes constituées de 2 ou 3 joueurs.</li>
        <li><strong>Rounds</strong> = les parties jouées dans une journée, 4 en général.</li>
        <li><strong>Matches</strong> = les rencontres à faire dans chaque partie.</li>
        <li><strong>Rankings</strong> = les classements des joueurs.</li>
    </ul>
';

$lang['doc.day.title'] = 'Déroulement d\'une journée';
$lang['doc.members.title'] = '1°/ Joueurs présents';
$lang['doc.members.content'] = '
    <h5>Sélection des joueurs</h5>
    <ul>
        <li><strong>Un nombre minimum de 4 joueurs (et différent de 7) est nécessaire pour acceder à l\'initialisation d\'une journée (2°) ou la création d\'une partie (3°).</strong></li>
        <li>On sélectionne les joueurs présents avant chaque partie avec la possibilité de faire une sélection rapide selon des filtres.</li>
        <li>Le nombre de joueurs sélectionnés détermine automatiquement le nombre et le type d\'équipes (doublettes/triplettes) et le nombre de terrains nécessaire. </li>
        <li>Le logiciel privilegie un maximum de doublettes. Le nombre de triplettes est défini seulement pour qu\'il y est un nombre pair d\'équipe.</li>
    </ul>
    <h5>Définir les habitués</h5>
    <ul>
        <li>En cliquant sur les étoiles à côté du nom des joueurs, on défini un joueur en tant qu\'habitué ou non.</li>
        <li>Étoile verte et pleine, le joueur est un habitué, étoile noire et vide le joueur ne l\'est pas.</li>
        <li>Un filtre de sélection rapide permet de sélectionner seulement les habitués</li>
    </ul>
';
$lang['doc.init.title'] = '2°/ Initialisation d\'une journée';
$lang['doc.init.content'] = '
    <ul>
        <li>Lorsque suffisamment de joueurs sont sélectionnés, l\'onglet <strong>Gestion des parties</strong> est accessible.</li>
        <li>L\'initialisation d\'une journée s\'effectue automatiquement, chaque jour d\'utilisation, lorsqu\'on rejoint la page <strong>Gestion des parties</strong> pour la première fois.</li>
    </ul>
';
$lang['doc.round.title'] = '3°/ Création d\'une partie';
$lang['doc.round.content'] = '
    <ul>
        <li>Lorsque la journée est initialisée, l\'encart de création de partie est accessible.</li>
        <li>Avant chaque partie, on peut sélectionner le nombre et le choix des terrains.</li>
        <li>Le bouton <strong>Créer la partie 1</strong> lance la génération automatique et aléatoire des équipes, puis des rencontres de la partie 1.</li>
        <li>L\'onglet <strong>Saisie des scores</strong> devient accessible.</li>
        <li>le bouton de création des parties disparait jusqu\'à ce qu\'au moins un score soit validé sur la page <strong>Saisie des scores</strong>.</li>
    </ul>
';
$lang['doc.scores.title'] = '4°/ Scores';
$lang['doc.scores.content'] = '
    <h5>Mode automatique</h5>
    <ul>
        <li>On sélectionne le champ du score de l\'équipe perdante et on renseigne son score parmi la liste des boutons (0 à 12).</li>
        <li>Le score de l\'équipe gagnante se rempli automatiquement avec le score maximum (13).</li>
        <li>Le score est validé uniquement après avoir cliqué sur le bouton <strong>Valider</strong> de la rencontre. On peut donc le modifier avec le même procédé tant que celui-ci n\'a pas été validé.</li>
        <li>Une fois validé le score peut encore être modifié en cliquant sur le bouton <strong>Modifier</strong>.</li>
    </ul>
    <h5>Mode Manuel</h5>
    En cas de nécessité de renseigner un score maximum différent de 13, le bouton <i class="fa fa-keyboard"></i> permet d\'ouvrir à l\'écriture manuelle, les champs de score des 2 équipes d\'une rencontre.
';
$lang['doc.rankings.title'] = '5°/ Classements';
$lang['doc.rankings.content'] = 'En cours de rédaction...';
?>