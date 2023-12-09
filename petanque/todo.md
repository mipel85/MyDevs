# TODO
## Connection
    ~~Séparer les identifiants de connexion à la bdd pour ne pas le transmettre dans github~~

## Accueil
créer la doc dans /theme/templates/home.php

## Partie
    ~~initialisation d'une partie = créer la partie au chargement de la page + récupérer la date de façon cachée~~

## Manche
    manche max = 4
    exception si 7 joueurs sélectionnés, désactiver le bouton d'ajout +  message error = "sélectionnez au moins 4 joueurs"

    ~~ajouter un index de 1 à 4 à chaque manche (index: i_order = 1 ; i_order++)~~
    à la création de la manche
        - ~~afficher liste des équipes + vérif rules.php~~
        - créer rencontres
            - afficher les rencontres dans la page scores
            - créer le tableau des joueurs dans la page classement

### création des équipes
    - se déclenche à la création d'une manche

### création des rencontres
    - se déclenche à la création d'une manche après les équipes

## Config
    input nb de joueurs min
    ~~bouton fin de journée => décocher la présence de tous les joueurs~~
    js forcer le haut de page quand on click sur un onglet de tabs

## Language
party/partie => la journée commence on crée une partie
    > round/manche => de 1 à 4 manches dans une partie
        > fight/rencontre => chaque rencontre entre 2 équipes dans une manche
            > team/equipe => un groupe de 2 ou 3 participants
                > player/joueur => un participant

### création du classement
win = score + diff
lose = score

