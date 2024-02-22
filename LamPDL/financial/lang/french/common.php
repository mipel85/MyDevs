<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
 */
####################################################
#                    French                        #
####################################################

$lang['financial.module.title'] = 'Aide Financière';
$lang['financial.config.auth'] = 'Configuration de module Aide Financière';

$lang['financial.item'] = 'demande';
$lang['financial.items'] = 'demandes';

// TreeLinks
$lang['financial.budgets.management'] = 'Gestion des budgets';
$lang['financial.budget.add'] = 'Ajouter un budget';
$lang['financial.budget.edit'] = 'Modifier un budget';

// Titles
$lang['financial.item.add'] = 'Ajouter une demande';
$lang['financial.item.edit'] = 'Modifier une demande';
$lang['financial.item.delete'] = 'Supprimer la demande';
$lang['financial.monitored.items'] = 'Suivi financier';
$lang['financial.archived.items'] = 'Demandes archivées';
$lang['financial.pending.items'] = 'Demandes en attente';
$lang['financial.archived'] = 'archivées';
$lang['financial.pending'] = 'en attente';
$lang['financial.filter.items'] = 'Filtrer les demandes';
$lang['financial.items.management'] = 'Gestion des demandes';

$lang['financial.request.type'] = 'Type de demande';
$lang['financial.bill'] = '<span class="small text-italic"> sur facture</span>';
$lang['financial.bill.max.amount'] = '<span class="small text-italic">max :max_amount €</span>';
$lang['financial.budget.available'] = 'Possibilités';
$lang['financial.request.access'] = 'Formulaire';
$lang['financial.request.choice'] = 'Choisir';
$lang['financial.request.not.available'] = 'Non disponible';
$lang['financial.club.name'] = 'Nom du club';
$lang['financial.club.dpt'] = 'Dept';
$lang['financial.club.dpt.filter'] = 'Département :';
$lang['financial.club.nb'] = 'Club';

// Labels
$lang['financial.monitoring'] = 'Suivi financier';
$lang['financial.monitoring.ongoing'] = 'À l\'étude';
$lang['financial.monitoring.ongoing.clue'] = 'Passer la demande `À l\'étude`';
$lang['financial.monitoring.reject'] = 'Refuser';
$lang['financial.monitoring.reject.clue'] = 'Rejeter la demande';
$lang['financial.monitoring.accept'] = 'Payer';
$lang['financial.monitoring.accept.clue'] = 'Payer la demande';
$lang['financial.budget.annual'] = 'Budget annuel';
$lang['financial.budget.domain'] = 'Domaine';
$lang['financial.budget.name'] = 'Nom du budget';
$lang['financial.amount.paid'] = 'Montant';
$lang['financial.budget.description'] = 'Description du budget';
$lang['financial.budget.fiscal.year'] = 'Année de l\'exercice';
$lang['financial.budget.annual.amount'] = 'Budget annuel';
$lang['financial.budget.pending'] = 'Des demandes sont en attentes';
$lang['financial.budget.no.pending'] = 'Aucune demande en attente';
$lang['financial.budget.balance'] = 'Solde';
$lang['financial.budget.rest'] = 'Restantes';
$lang['financial.budget.temp'] = 'Prévisionnel';
$lang['financial.budget.real'] = 'Réel';
$lang['financial.budget.unit.amount'] = 'Forfait';
$lang['financial.budget.unit.amount.clue'] = 'Un nombre suivi de "€" ou "%" sans espace (ex: 0€)';
$lang['financial.budget.max.amount'] = 'Plafond';
$lang['financial.budget.quantity'] = 'Nombre de demandes possibles';
$lang['financial.budget.quantities'] = 'Quantités';
$lang['financial.budget.upload'] = 'Budget avec téléversement <br /><span class="small text-italic">Pour que le demandeur puisse fournir des devis, factures, etc</span>';
$lang['financial.budget.invoice.required'] = 'Facture obligatoire';

$lang['financial.request.form.title'] = '<span class="small">Demande d\'aide : </span>';
$lang['financial.request.allocated.budget'] = 'Budget alloué pour cette demande';
$lang['financial.request.bill'] = '
    <br /><span class="message-helper bgc warning">Attention !! Vous devez fournir un devis <strong>OU</strong> une facture !
    <br />Vous pouvez ne fournir qu\'un devis en début de processus, vous pourrez plus tard fournir une facture pour le paiement de la demande.</span>
';
$lang['financial.request.club'] = 'Identifiants du club';
$lang['financial.request.city'] = 'Ville';
$lang['financial.request.event.date'] = 'Prévue le';
$lang['financial.request.creation.date'] = 'Créée le';
$lang['financial.request.validation.date'] = 'Validée le';
$lang['financial.request.content'] = 'Descriptif (optionnel)';
$lang['financial.request.files.url'] = 'Fichiers';
$lang['financial.request.estimate.url'] = 'Devis';
$lang['financial.request.estimate.url.clue'] = 'Si vous n\'avez pas encore de facture';
$lang['financial.request.invoice.url'] = 'Facture';
$lang['financial.request.invoice.url.clue'] = 'Nécessaire pour la prise en compte de votre demande';
$lang['financial.request.no.files'] = 'Un devis ou une facture sont nécéssaires pour traiter votre demande<br />Éditez avec le bouton <i class=\'fa fa-edit\'></i> pour en ajouter';
$lang['financial.request.no.invoice'] = 'Une facture est nécéssaire pour traiter votre demande<br />Éditez avec le bouton <i class=\'fa fa-edit\'></i> pour en ajouter';

$lang['financial.request.email'] = 'Informations email';
$lang['financial.request.email.clue'] = 'Les informations suivantes ne sont ni enregistrées ni conservées sur le site (RGPD)';
$lang['financial.request.contact.user'] = 'Nom du correspondant';
$lang['financial.request.contact.email'] = 'Adresse email du correspondant';
$lang['financial.request.contact.email.clue'] = 'Email du responsable de club à contacter en cas de besoin';
$lang['financial.request.message'] = 'Descriptif';
$lang['financial.request.message.clue'] = 'Optionnel';

$lang['financial.status'] = 'Suivi de la demande';
$lang['financial.status.pending'] = 'En attente';
$lang['financial.status.ongoing'] = 'À l\'étude';
$lang['financial.status.accepted'] = 'Acceptée';
$lang['financial.status.rejected'] = 'Rejetée';

// Email
$lang['financial.mail.msg'] = 'Bonjour, <br /><br />
	<i>Dossier suivi par :club_sender_name (:club_sender_email)</i><br /><br /> 
    Le club <strong>:club_name</strong> (affiliation FFAM n° :club_ffam_number) souhaite obtenir une aide pour l\'activité : :activity, prévue le :club_activity_date
    <br /><strong>Département :</strong> :club_activity_dpt
    <br /><strong>Descriptif :</strong> :description
';
$lang['financial.mail.invoice.msg'] = 'Bonjour, <br /><br />
	<i>Dossier suivi par :club_sender_name (:club_sender_email)</i><br /><br /> 
    Le club <strong>:club_name</strong> (affiliation FFAM n° :club_ffam_number) a fourni une facture dans le suivi de son dossier pour l\'activité : :activity
';

// Config
$lang['financial.recipient.mail_1'] = 'Adresse du destinataire principal :';
$lang['financial.recipient.mail_2'] = 'Adresse du destinataire n° 2 :';
$lang['financial.recipient.mail_3'] = 'Adresse du destinataire n° 3 :';
$lang['financial.email.configuration.default'] = 'Adresse mail obligatoire. par défaut : :default_mail';
$lang['financial.email.configuration.optional'] = 'Adresse mail optionnelle';

$lang['financial.reset'] = 'Nouvel exercice comptable';
$lang['financial.reset.clue'] = '
    Mise à jour des compteurs de demandes par budget
';
$lang['financial.reset.date'] = 'Année du nouvel exercice';
$lang['financial.reset.date.clue'] = 'Exactement 4 chiffres';

// SEO
$lang['financial.seo.description.root'] = 'Tous les demandes du site :site.';
$lang['financial.seo.description.pending'] = 'Tous les demandes en attente.';
$lang['financial.seo.description.member'] = 'Tous les demandes de :author.';
$lang['financial.seo.description.requests.list'] = 'Liste des demandes du site :site.';

// Feed name
$lang['financial.feed.name'] = 'Événement';

// Messages helper
$lang['financial.message.success.add'] = 'La demande <strong>:title</strong> a été ajoutée';
$lang['financial.message.success.edit'] = 'La demande <strong>:title</strong> a été modifiée';
$lang['financial.message.success.delete'] = 'La demande <strong>:title</strong> a été supprimée';
$lang['financial.message.success.reject'] = 'La demande <strong>:title</strong> a été rejetée et placée en archive';
$lang['financial.message.success.accept'] = 'La demande <strong>:title</strong> a été acceptée et placée en archive';
$lang['financial.message.error.accept'] = 'Le montant déclaré pour la validation de la demande: <strong>:title</strong> entraîne un dépassement du budget annuel';
$lang['financial.message.empty.accept'] = 'Le montant déclaré pour la validation de la demande: <strong>:title</strong> ne peut pas être nul';
$lang['financial.message.success.ongoing'] = 'La demande <strong>:title</strong> a été placée à l\'étude';

$lang['financial.message.success.budget.add'] = 'Le budget <strong>:name</strong> a été ajouté';
$lang['financial.message.success.budget.edit'] = 'Le budget <strong>:name</strong> a été modifié';
$lang['financial.message.success.budget.delete'] = 'Le budget <strong>:name</strong> a été supprimé';

// Errors
$lang['financial.warnings'] = 'Attention !!';
$lang['financial.warnings.lamclubs'] = 'Le module Lamclubs est manquant, le module financial ne pourra pas fonctionner correctement.';
$lang['financial.error.invalid.date'] = 'La date entrée est invalide';
$lang['financial.warning.estimate.url'] = 'Vous devez fournir au moins un devis';

// Legend
$lang['financial.legend'] = 'Légende';

$lang['financial.legend.monitoring.input'] = 'Champ Forfait';
$lang['financial.legend.monitoring.input.disabled'] = 'Champ en marron, le champ n\'est pas modifiable.';
$lang['financial.legend.monitoring.input.enabled'] = 'Champ avec flêches, le champ est modifiable.';

$lang['financial.legend.monitoring.buttons'] = 'Boutons';
$lang['financial.legend.monitoring.button.payment'] = 'Bouton Payer: Archive la demande avec la mention Acceptée et decompte le budget annuel de la somme indiquée dans le champ Forfait.';
$lang['financial.legend.monitoring.button.ongoing'] = 'Bouton À l\'étude: Marque la demande pour signifier au demandeur qu\'il/elle doit fournir une facture.';
$lang['financial.legend.monitoring.button.reject'] = 'Bouton Refuser: Archive la demande avec la mention Refusée.';

$lang['financial.legend.user.pending'] = 'Cette page est accessible à tout moment en utilisant le menu <i class="fa fa-cog"></i>.';
$lang['financial.legend.user.archived'] = 'Si votre demande n\'apparait plus, c\'est qu\'elle a été traitée.';
$lang['financial.legend.user.file'] = 'Colonne Fichiers';
$lang['financial.legend.user.none'] = 'vide :  Aucune action n\'est requise pour que votre demande soit étudiée.';
$lang['financial.legend.user.error'] = '<i class="fa fa-circle-question error"></i> : vous devez fournir au moins un devis pour que votre demande soit étudiée.';
$lang['financial.legend.user.warning'] = '<i class="fa fa-triangle-exclamation warning"></i> : votre demande est à l\'étude et une facture vous est demandée.';
$lang['financial.legend.user.estimate'] = '<i class="far fa-file-lines link-color"></i> : vous avez fourni un devis.';
$lang['financial.legend.user.invoice'] = '<i class="fa fa-file-contract link-color"></i> : vous avez fourni une facture.';

$lang['financial.legend.user.controls'] = 'Pour chacune de vos demandes, vous avez accès à des boutons de controle.';
$lang['financial.legend.user.edit'] = '<i class="far fa-edit link-color"></i> pour éditer votre demande';
$lang['financial.legend.user.delete'] = '<i class="fa fa-trash-alt link-color"></i> pour supprimer votre demande';
?>
