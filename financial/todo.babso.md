# todo

~~- table financial_table => financial_request_table~~

~~- setup import csv des budgets cf lamclubs~~
- pareil pour la config maj de l'exercice ?

- gestion des compteurs
~~- champ `domaine` pour les budget (titre des tableaux du pdf)~~
- modifier le lien du module dans le panneau de contribution

passer les états en bouton sur le pending plutôt qu'à l'édition

~~const pending / en attente -> pending~~
~~const ongoing / à l'étude -> pending~~
~~const rejected / rejeté -> archived~~
~~const accepted / accepté -> archived~~

archivé = non modifiable par auteur => modifier texte de la contrib

# fichiers
~~un champ devis~~
~~un champ facture~~

# cheminement
demande -> mail + en attente => league

## Cheminement simple (pas de devis/facture)
accepté/payé -> archive + décompte

## Cheminement complexe 
user envoie devis  -> état = 'devis envoyé'
                   -> const accepté état 'facture en attente'
user envoi facture -> état = 'facture envoyée'
                   -> si pas new_item -> mail

si facture -> payable

pour plus tard 
faire un controller Les demandes de mon club


