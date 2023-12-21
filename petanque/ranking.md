# Classement
pour envoyer les scores dans le classement : 
bouton 'Envoyer les scores dans le classement' sur la page des scores 
ou
checker si tous les score_status du round sont à 1 
ou
checker si un score_status est à 1 ( doit upade quand le score_status passe à 0 sur une modification?

## Liste des joueurs
### creation
- créer la liste des joueurs dans la table `players` à partir de la validation d'un match

### Supression
- si on supprime la partie.i_order == i_order
    - on supprime tous les round.joueurs 
- si on édite un match on supprime les match_id.players de la table

## table rankings dans bdd
| id | id de la journée | id du membre | Nom du membre | Nombre de matches joués | Nombre de victoires | Nombre de defaites | points pour | points contre |
| id | day_id           | member_id    | member_name   | played                  | victory             | loss               | pos_points  | neg_points    |

## Tableau du classement
| place | Nom | Joués | Victoires | Défaites | Points pour | Points contre | Diff |

## Ordre
1 - Nombre de victoires
2 - points pour
3 - points contre

## simulation de points
victiore => 13 + diff
défaite  => score - diff
| 13-6 | 13-9 | 2-13 | 13-11 |
| v+20 | v+17 | d-9  | v+15  | gagnant v+53 d-9
| d-1  | d+5  | v+23 | d+9   | perdant v+23 d+13


# Revoir l'insert des entrées de la table `rankings`
A cause que on peut pas supprimer des séléctionné en plus ou lorsque on supprime une partie créée par erreur : 
Insérer à la validation du score au lieu d'après la création des matchs
si joueur non existant dans la table `rankings` => insert avec valeur du score
sinon update