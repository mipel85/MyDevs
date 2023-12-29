# TODO
## Connection
~~- Séparer les identifiants de connexion à la bdd pour ne pas le transmettre dans github~~

## Design général
~~- compresser en vertical~~
- créer composant tooltip + mettre sur tous les icon-button

### Menu
~~- design comme joueur : horizontal + border + radius ~~

~~- chaque item sur 2 lignes ~~
    ~~- Accueil / date ~~
    ~~- Joueurs présents / nombre de joueurs ~~
    ~~- Gestion des parties / partie en cours ou label ~~
    ~~- Saisie des scores / X matches terminés sur Y matches  ou label ~~
    ~~- Classement / partie en cours ou label ~~

## Header
~~- Bienvenue à la partie du date sous le titre ~~
~~- n° de la partie ~~

## Membres
~~- déplacer la build des favoris sur la page sélection ~~
~~- reload(true) sur décocher tout ~~
~~- liste des sélection full page ~~
~~- affichage de la liste des sélectionnés en popup sans id ~~
~~- agir en ajax sur la liste des sélectionnés pour ne pas avoir à recharger la page ~~
~~- pouvoir modifier le nom du membre ~~
~~- revoir le tableau des membres dans la config member selection like ~~

## Accueil
créer la doc dans /theme/templates/home.php

## Journée
À la création d'une journée = chargement de la page `Gestion des parties` : 
~~- purger les tables sauf `members`, `rankings` et `days` ~~
~~- initialisation de la journée du jour ~~
~~- récupérer la date de façon cachée ~~

### Terminer la journée
~~- bouton `Terminer la journée` + date dans les classements en face du h1 ~~
    ~~- => bloquer l'ajout d'une nouvelle journée = flag(active) dans la table `days` ~~
        ~~si 1 => ok ~~
        ~~si 0 => bloquer onglets partie + score + redirection, le bouton devient `Réouvrir la journée` ~~
    ~~- => prévoir de réouvrir la journée + date ~~

### Partie
~~exception moins de 4 joueurs ou si 7 joueurs sélectionnés, désactiver le bouton d'ajout +  message error = "sélectionnez au moins 4 joueurs" ~~

~~ajouter un index à chaque manche (index: i_order = 1 ; i_order++) ~~
création
    ~~- afficher liste des équipes + vérif rules.php ~~
    ~~- après création la manche 1, impossible de créer une manche suivante si scores manche en cours non saisis ~~
suppression
    ~~- une par une ~~
        ~~- uniquement sur la manche en cours ~~
        ~~- interdire la suppression d'une manche si des scores sont déclarés pour la manche ~~
    ~~- par paquet ~~
        ~~- pertinence du bouton `supprimer toutes les manches` car ça ne supprime pas les days auquelles elles appartiennent ~~

### Équipes
~~- pas possible si 7 joueurs ~~
~~- se déclenche automatiquement après la création d'une manche ~~
~~- id partie ~~
~~- id manche ~~
~~- nb de joueurs ~~
~~- type d'équipe (rules.php) ~~

### Rencontres
~~- se déclenche automatiquement après la création d'une manche et la création des équipes de la manche ~~
~~- id partie ~~
~~- id manche ~~
~~- n° terrain ~~
~~- rencontres, dont les scores sont validés, sur fond bleu ~~
(-) pas de nelle manche tant que TOUS les scores de la manche en cours ne sont pas saisis

### Scores
~~- id partie ~~
~~- id manche ~~
~~- ids équipes de la manche ~~
~~- manches par tabs ~~
~~- bouton de validation/edition pour chaque rencontre ~~
    ~~- si score non validé Validation => ~~
        ~~- table matches flag = 1 ~~
        ~~- les 2 inputs disabled ~~
    ~~- si score validé Édition =>  ~~
        ~~- table matches flag = 0 ~~
        ~~- les 2 inputs enabled ~~
~~- liste de score possible de 0 à 12 ~~
    ~~- focus sur le score des perdants à saisir ~~
    ~~- cliquer sur sur un des numéros de la liste ~~
    ~~- envoyer automatiquement le 13 sur l'autre score ~~
    ~~- tester si une des 2 équipes a 13 ~~
~~- empêcher de mettre du texte dans les input ou score >= 13 si taper au clavier ou interdire la frappe ~~
~~- scores validés sur fond vert ~~
~~- changer couleur du bouton de validation ~~
    ~~- Valider => rien car le score n'est pas validé ~~
    ~~- Modifier => vert comme le score qui est validé ~~
- prévoir une saisie de score différent de 13 pour chaque match de la partie en cas de fin de partie obligatoire pour chaque match de la partie
    ~~- bouton icon keyboard + tooltip ~~
    ~~- ouvrir les input de score à la saisie manuelle ~~
    - ATTENTION si score egal (ex: 5-5)
    - ATTENTION modification des règles de calcul des points
~~- grossir les boutons scores 1.1 ~~
~~- mettre la liste des score en fixe au scroll ~~
~~- améliorer le focus jusqu'à validation ~~
~~- revoir le tableau member selection like ~~
~~- possibilité de changer le score envoyé (0 à 12) avant validation (actuellement, on ne peut cliquer qu'une fois et il faut valider puis modifier pour changer) ~~

### Classement
~~- day_id ~~
~~- day_date ~~
~~- joueurs_id ~~
~~- joueurs_name ~~
~~- nb rencontres ~~
~~- points ~~
    ~~- win = score + diff win/loss ~~
    ~~- loss = score - diff win/loss ~~
~~- condition pour match joué = score validé et pour defaite = score validé (score status) ~~
    ~~=> ajouter score status dans la table `players` et récup dans players.ctrl depuis scores.view ~~
- annuler la journée => supprimer toutes les entrées day_id des tables `rankings` et `players`

## Config
~~bouton fin de journée => décocher la présence de tous les joueurs ~~
~~js forcer le haut de page quand on click sur un onglet de tabs ~~

## Terrains
~~- interdire 0 terrain ~~
~~- interraction avec matches ~~
    ~~- si nb de terrains < au nombre de matches remettre la liste complète ~~
~~- demarrage de journée ~~
    ~~- pouvoir choisir le nombre et les n° des terrains ~~
    ~~- nb de terrains sélection parmi 14 possibles ~~
    ~~- design checkbox ~~
    ~~- cacher si pas d'ajout de partie possible ~~
~~- afficher le plan des terrains un par un ~~

## Language
code/front~config
~~day/journée => la journée commence on la crée ~~
~~round/partie => de 1 à x parties dans une journée ~~
~~matches/rencontre => chaque rencontre entre 2 équipes dans une partie ~~
~~team/equipe => un groupe de 2 ou 3 participants ~~
~~member/joueur~membre => un joueur en front, un membre dans la config ~~
~~player => un membre ayant au moins un score ~~
~~rankings/classement

## Idées
- Revoir le logo

## Nettoyage
    js `error:`
    reorder and clean css

