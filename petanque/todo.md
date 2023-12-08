# TODO
## Connection
    ~~Séparer les identifiants de connexion à la bdd pour ne pas le transmettre dans github~~

## Accueil
créer la doc dans /theme/templates/home.php

## Partie
    ~~initialisation d'une partie = bouton d'ajout + récupérer la date de façon cachée~~
    si partie existe déjà
        - bouton d'ajout => disabled
        - message notice = "Partie déjà créée"
    si partie ok
        - message success flottant (5s)
        - disactiver le boutton d'ajout
        - afficher formulaire de manches

## Manche
    formulaire caché par default si aucune partie créée
    exception si 7 joueurs sélectionnés, désactiver le bouton d'ajout +  message error = "sélectionnez au moins 4 joueurs"

    manche max = 4
    ajouter un index de 1 à 4 à chaque manche (index: i_order = 1 ; i_order++)
    à la création de la manche
        - afficher liste des équipes + vérif rules.php
        - créer rencontres + afficher les rencontres dans la page rencontre

## Admin
    bouton reset all sauf joueurs
    input nb de joueurs min
    bouton fin de journée => décocher la présence de tous les joueurs

## Language
party/partie => la journée commence on crée une partie
    > round/manche => de 1 à 4 manches dans une partie
        > fight/rencontre => chaque rencontre entre 2 équipes dans une manche
            > team/equipe => un groupe de 2 ou 3 participants
                > player/joueur => un participant

win = score + diff
lose = score

