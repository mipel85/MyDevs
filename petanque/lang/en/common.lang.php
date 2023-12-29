<?php

$lang['site.name']   = 'Pétanque Loisirs Sainte-Foy';
$lang['site.logo']   = 'Logo Pétanque Loisirs Sainte-Foy';

$lang['common.add']   = 'Ajouter';
$lang['common.close']   = 'Fermer';
$lang['common.edit']   = 'Modifier';
$lang['common.submit']   = 'Valider';

// Config
$lang['config.title']   = 'Configuration';
$lang['config.tab.members']   = 'Gestion des membres';
$lang['config.tab.days']   = 'Gestion des journées';
$lang['config.tab.rounds']   = 'Gestion des parties';
$lang['config.tab.doc']   = 'Documentation';

$lang['config.members.title'] = 'Liste des membres';
$lang['config.members.add'] = 'Ajouter un membre : ';
$lang['config.members.remove'] = 'Supprimer ce membre';

$lang['config.days.remove.all'] = 'Supprimer toute les journées';
$lang['config.days.help.all'] = 'La suppression de toutes les journées supprime également toutes les parties, équipes, rencontres, scores et classements.';
$lang['config.days.date'] = 'Date';
$lang['config.days.remove'] = 'Supprimer cette journée';
$lang['config.days.help'] = 'La suppression d\'une journée supprime également toutes les parties, équipes, rencontres, scores et classements <strong>de la journée</strong>.';

// Menu
$lang['menu.home']      = 'Accueil';
$lang['menu.members']   = '<strong>Joueurs</strong> présents';
$lang['menu.rounds']    = 'Gestion des <strong>Parties</strong>';
$lang['menu.scores']    = 'Saisie des <strong>Scores</strong>';
$lang['menu.rankings']  = 'Classement';

$lang['menu.sub.no.members']      = 'Aucun joueur sélectionné';
$lang['menu.sub.member']          = ':number joueur sélectionné';
$lang['menu.sub.members']         = ':number joueurs sélectionnés';
$lang['menu.sub.no.days']         = 'Aucune journée créée';
$lang['menu.sub.end.day']         = 'Journée terminée';
$lang['menu.sub.no.rounds']       = 'Aucune partie créée';
$lang['menu.sub.round']           = 'Partie :number : ';
$lang['menu.sub.current.round']   = 'Partie :number en cours';
$lang['menu.sub.no.scores']       = 'Aucun score déclaré';
$lang['menu.sub.score']           = ':number rencontre jouée';
$lang['menu.sub.scores']          = ':number rencontres jouées';
$lang['menu.sub.no.rankings']     = 'Aucune rencontre mise à jour';
$lang['menu.sub.ranking']         = 'Après :number rencontre';
$lang['menu.sub.rankings']        = 'Après :number rencontres';

// Members
    // Front
$lang['members.title'] = 'Sélection des joueurs';
$lang['members.selected.members'] = ':number sélectionnés';
$lang['members.selected.member'] = ':number sélectionné';
$lang['members.quick.select'] = 'Sélection<br>rapide';
$lang['members.quick.select.modal'] = 'Sélection rapide';
$lang['members.quick.init.favs'] = 'Réinitialiser<br>tous les habitués';
$lang['members.quick.select.favs'] = 'Sélectionner<br>seulement les habitués';
$lang['members.quick.unselect.all'] = 'Désélectionner<br>tous les membres';
$lang['members.quick.select.all'] = 'Sélectionner<br>tous les membres';
$lang['members.display'] = 'Afficher la liste<br>des présents';
$lang['members.display.none'] = 'Aucun joueur sélectionné';
$lang['members.alert.4'] = 'Moins de 4 joueurs n\'est pas une sélection valide pour créer un nombre d\'équipes pair de 2 et 3 joueurs.';
$lang['members.alert.7'] = '7 joueurs n\'est pas une sélection valide pour créer un nombre d\'équipes pair de 2 et 3 joueurs.';

// Days
$lang['days.title']   = 'Gestion des parties';
$lang['days.init']   = 'Initialisation de la journée ...';

$lang['days.select.fields']   = 'Sélection des<br>terrains disponibles';

$lang['days.add.round']   = 'Créer la <strong>partie :number</strong>';
$lang['days.round.players']   = 'Avec les :number joueurs présents.';
$lang['days.no.round.allowed'] = 'Aucun score de la partie en cours n\'est renseigné.<br />L\'ajout d\'une nouvelle partie est désactivé.';

$lang['footer']   = '&copy; PLSF :year --- Version 1.0';

// Scores
$lang['scores.title']   = 'Scores';

$lang['scores.update.rankings']   = 'Mettre à jour le classement';

$lang['scores.help.scores']   = '
    Sélectionner le score des perdants puis sélectionner un nombre dans la liste ci-dessus.
    <br />Le score des gagnants (13) est renseigné automatiquement.
';
$lang['scores.help.colors']   = '
    Sur fond vert, les scores validés.
    <br />Sur fond blanc, les scores non validés
';
$lang['scores.manual.edit']   = 'Renseigner le score manuellement';

// Rankings

$lang['rankings.title']   = 'Classement';

$lang['rankings.no.days']   = 'Aucune journée créée.';
$lang['rankings.days.close']   = 'Terminer la journée';
$lang['rankings.days.reopen']   = 'Réouvrir la journée';

$lang['rankings.place']   = 'Place';
$lang['rankings.name']   = 'Nom';
$lang['rankings.played']   = 'Joués';
$lang['rankings.victory']   = 'Victoires';
$lang['rankings.loss']   = 'Défaites';
$lang['rankings.points.for']   = 'Points pour';
$lang['rankings.points.against']   = 'Points contre';

?>
