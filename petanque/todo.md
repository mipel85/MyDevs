# TODO
## Connection
    ~~ Séparer les identifiants de connexion à la bdd pour ne pas le transmettre dans github ~~

## Accueil
    créer la doc dans /theme/templates/home.php

## Partie
    - ~~ initialisation d'une partie au chargement de la page ~~
    - ~~ récupérer la date de façon cachée ~~

### Manche
    manche max = 4
    exception si 7 joueurs sélectionnés, désactiver le bouton d'ajout +  message error = "sélectionnez au moins 4 joueurs"

    ~~ ajouter un index de 1 à 4 à chaque manche (index: i_order = 1 ; i_order++) ~~
    création
        - ~~ afficher liste des équipes + vérif rules.php ~~
    suppression
        - une par une
            - interdire la suppression d'une manche si 
                - une manche supérieure de la même partie est présente
                - des scores sont déclarés pour la manche
        - par paquet
            - pertinence du bouton `supprimer toutes les manches` car ça ne supprime pas les parties auquelles elles appartiennent

### Équipes
    - ~~ se déclenche automatiquement après la création d'une manche ~~
    - ~~ id partie ~~
    - ~~ id manche ~~
    - ~~ nb de joueurs ~~
    - ~~ type d'équipe (rules.php) ~~

### Rencontres
    - ~~ se déclenche automatiquement après la création d'une manche et la création des équipes de la manche ~~
    - ~~ id partie ~~
    - ~~ id manche ~~
    - ~~ n° terrain ~~

### Scores
    - id partie
    - id manche
    - ids équipes de la manche

### Classement
    - ids joueurs
    - nb rencontres
    - scores
    - points
        - win = score + diff win/loss
        - loss = score

## Config
    ~~bouton fin de journée => décocher la présence de tous les joueurs~~
    js forcer le haut de page quand on click sur un onglet de tabs

## Params
    - modal sur page partie
    - nb de joueurs min par defaut 8
    - nb de manche max par defaut 4
    - nb de terrains par defaut 14

## Language
party/partie => la journée commence on crée une partie
    > round/manche => de 1 à x manches dans une partie
        > fight/rencontre => chaque rencontre entre 2 équipes dans une manche
            > team/equipe => un groupe de 2 ou 3 participants
                > player/joueur => un participant

