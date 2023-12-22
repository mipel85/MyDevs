# Classement
~~bouton 'Mettre à jour le classement' sur la page des scores  ~~

## Liste des joueurs
- cdc : On ne peut pas supprimer des entrées dans la table `rankings`
~~ - Insérer les players dans les tables `players` puis `rankings` à la validation du score ~~
~~ - si le player est non existant dans les 2 tables => insert, avec valeurs du score dans la table `players` ~~
~~ - sinon update ~~

## table rankings dans bdd
~~| id | id de la journée | id du membre | Nom du membre | Nombre de matches joués | Nombre de victoires | Nombre de defaites | points pour | points contre | ~~
~~| id | day_id           | member_id    | member_name   | played                  | victory             | loss               | pos_points  | neg_points    | ~~

## Tableau du classement
~~| place | Nom | Joués | Victoires | Défaites | Points pour | Points contre | ~~

## Ordre
~~1. Nombre de victoires ~~
~~2. points pour ~~
~~3. points contre ~~

## simulation de points
~~victiore => 13 + diff ~~
~~défaite  => score - diff ~~