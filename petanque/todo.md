# TODO
## Connection
    ~~ Séparer les identifiants de connexion à la bdd pour ne pas le transmettre dans github ~~

## Accueil
    créer la doc dans /theme/templates/home.php

## Partie
    ~~ - initialisation d'une partie au chargement de la page ~~
    ~~ - récupérer la date de façon cachée ~~
    ~~ - manches par tabs ~~

### Manche
    ~~ exception moins de 4 joueurs ou si 7 joueurs sélectionnés, désactiver le bouton d'ajout +  message error = "sélectionnez au moins 4 joueurs" ~~

    ~~ ajouter un index à chaque manche (index: i_order = 1 ; i_order++) ~~
    création
        ~~ - afficher liste des équipes + vérif rules.php ~~
        ~~ - après création la manche 1, impossible de créer une manche suivante si scores manche en cours non saisis ~~
    suppression
        ~~ - une par une ~~
            ~~ - uniquement sur la manche en cours ~~
            ~~ - interdire la suppression d'une manche si des scores sont déclarés pour la manche ~~
        ~~ - par paquet ~~
            ~~ - pertinence du bouton `supprimer toutes les manches` car ça ne supprime pas les parties auquelles elles appartiennent ~~

### Équipes
    ~~ - pas possible si 7 joueurs ~~
    ~~ - se déclenche automatiquement après la création d'une manche ~~
    ~~ - id partie ~~
    ~~ - id manche ~~
    ~~ - nb de joueurs ~~
    ~~ - type d'équipe (rules.php) ~~

### Rencontres
    - ~~ se déclenche automatiquement après la création d'une manche et la création des équipes de la manche ~~
    - ~~ id partie ~~
    - ~~ id manche ~~
    - ~~ n° terrain ~~
    (-) pas de nelle manche tant que TOUS les scores de la manche en cours ne sont pas saisis

### Scores
    ~~ - id partie ~~
    ~~ - id manche ~~
    ~~ - ids équipes de la manche ~~
    ~~ - manches par tabs ~~
    ~~ - bouton de validation/edition pour chaque rencontre ~~
        ~~ - si score non validé Validation => ~~
            ~~ - table matches flag = 1 ~~
            ~~ - les 2 inputs disabled ~~
        ~~ - si score validé Édition =>  ~~
            ~~ - table matches flag = 0 ~~
            ~~ - les 2 inputs enabled ~~
    ~~ - liste de score possible de 0 à 12 ~~
        ~~ - focus sur le score des perdants à saisir ~~
        ~~ - cliquer sur sur un des numéros de la liste ~~
        ~~ - envoyer automatiquement le 13 sur l'autre score ~~
        ~~ - tester si une des 2 équipes a 13 ~~
    ~~ - empêcher de mettre du texte dans les input ou score >= 13 si taper au clavier ou interdire la frappe ~~

### Classement
    - ids joueurs
    - nb rencontres
    - scores
    - points
        - win = score + diff win/loss
        - loss = score

## Config
    ~~ bouton fin de journée => décocher la présence de tous les joueurs ~~
    ~~ js forcer le haut de page quand on click sur un onglet de tabs ~~

## Params
    - dans la config
    - nb de joueurs min par defaut 8 // A SUPPRIMER
    - nb de manche max par defaut 4 // A SUPPRIMER
    - nb de terrains par defaut 14

## Terrains
    - si nb de terrains < au nombre de matches remettre la liste complète
    - pouvoir choisir les n° des terrains

## Language
    ~~ party/partie => la journée commence on crée une partie ~~
    ~~ > round/manche => de 1 à x manches dans une partie ~~
    > matches/rencontre => chaque rencontre entre 2 équipes dans une manche
    ~~ > team/equipe => un groupe de 2 ou 3 participants ~~
    > member/membre => un membre
    > player/joueur => un participant à une partie
    > ranking/classement
