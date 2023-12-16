# Classement
pour envoyer les scores dans le classement : 
bouton 'Envoyer les scores dans le classement' sur la page des scores 
ou
checker si tous les score_status du round sont à 1 
ou
checker si un score_status est à 1 ( doit upade quand le score_status passe à 0 sur une modification?

## Liste des joueurs
- créer la liste des joueurs dans la table `ranking` à partir de la liste des joueurs sélectionnés
- Si c'est la 1ere partie de la journée
    - ajouter tous les membres de la liste des sélectionnés dans la table
- Sinon
    - Check de la liste des joueurs de la table ranking en fonction de la colonne day_id
        - si un joueur est absent on le laisse dans la liste
        - si un joueur est ajouté comme présent on l'ajoute dans la liste

## table ranking dans bdd
| id | id de la journée | id du membre | Nom du membre | Nombre de matches joués | Nombre de victoires | Nombre de defaites | points pour | points contre |
| id | day_id           | member_id    | member_name   | played                  | victory             | loss               | pos_points  | neg_points    |

## Tableau du classement
| place | Nom | Joués | Victoires | Défaites | Points pour | Points contre | Diff |

## Ordre
1 - Nombre de victoires
2 - points pour
3 - points contre