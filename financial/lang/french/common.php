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
$lang['financial.no.category'] = 'Sans catégorie';

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
$lang['financial.bill.max.amount'] = '<br /><span class="small text-italic">max :max_amount €</span>';
$lang['financial.budget.available'] = 'Possibilités';
$lang['financial.request.access'] = 'Formulaire';
$lang['financial.request.choice'] = 'Choisir';
$lang['financial.request.not.available'] = 'Non disponible';
$lang['financial.club.name'] = 'Nom du club';
$lang['financial.club.dpt'] = 'Dept';
$lang['financial.club.nb'] = 'Club';

// Labels
$lang['financial.monitoring'] = 'Suivi financier';
$lang['financial.monitoring.ongoing'] = 'Passer la demande `À l\'étude`';
$lang['financial.monitoring.reject'] = 'Rejeter la demande';
$lang['financial.monitoring.accept'] = 'Payer la demande';
$lang['financial.budget.annual'] = 'Budget annuel';
$lang['financial.budget.domain'] = 'Domaine';
$lang['financial.budget.name'] = 'Nom du budget';
$lang['financial.amount.paid'] = 'Montant';
$lang['financial.budget.description'] = 'Description du budget';
$lang['financial.budget.fiscal.year'] = 'Année de l\'exercice';
$lang['financial.budget.annual.amount'] = 'Budget annuel';
$lang['financial.budget.pending'] = 'Des demandes sont en attentes';
$lang['financial.budget.no.pending'] = 'Aucune demande en attente';
$lang['financial.budget.balance.temp'] = 'Prév';
$lang['financial.budget.balance.real'] = 'Réel';
$lang['financial.budget.balance.temp.alt'] = 'Prév';
$lang['financial.budget.balance.real.alt'] = 'Réelles';
$lang['financial.budget.amount'] = 'Montant';
$lang['financial.budget.unit.amount'] = 'Unitaire';
$lang['financial.budget.max.amount'] = 'Plafond';
$lang['financial.budget.quantity'] = 'Nombre de demandes possibles';
$lang['financial.budget.quantities'] = 'Quantités';
$lang['financial.budget.upload'] = 'Budget avec téléversement <br /><span class="small text-italic">Pour que le demandeur puisse fournir des devis, factures, etc</span>';

$lang['financial.request.form.title'] = '<span class="small">Demande d\'aide : </span>';
$lang['financial.request.allocated.budget'] = 'Budget alloué pour cette demande';
$lang['financial.request.bill'] = ' 
    <br />Vous pouvez fournir un devis en début de processus, mais il faudra fournir une facture pour la validation de la demande.
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
    Le club <strong>:club_name</strong> (affiliation FFAM n° :club_ffam_number) souhaite obtenir une aide pour l\'organisation d\'une :activity prévue le :club_activity_date
    <br /><strong>Ville :</strong> :club_activity_city
    <br /><strong>Département :</strong> :club_activity_dpt
    <br /><strong>Descriptif :</strong> :description
';

// Config
$lang['financial.recipient.mail_1'] = 'Adresse du destinataire principal :';
$lang['financial.recipient.mail_2'] = 'Adresse du destinataire n° 2 :';
$lang['financial.recipient.mail_3'] = 'Adresse du destinataire n° 3 :';
$lang['financial.email.configuration.default'] = 'Adresse mail obligatoire. par défaut : :default_mail';
$lang['financial.email.configuration.optional'] = 'Adresse mail optionnelle';

$lang['financial.reset'] = 'Nouvel exercice comptable';
$lang['financial.reset.clue'] = 'Mise à jour des compteurs de demandes par budget';
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
$lang['financial.message.error.accept'] = '<span class="message-helper bgc-full error">Le montant déclaré pour la validation de la demande: <strong>:title</strong> entraîne un dépassement du budget annuel</span>';
$lang['financial.message.success.ongoing'] = 'La demande <strong>:title</strong> a été placée à l\'étude';

$lang['financial.message.success.budget.add'] = 'Le budget <strong>:name</strong> a été ajouté';
$lang['financial.message.success.budget.edit'] = 'Le budget <strong>:name</strong> a été modifié';
$lang['financial.message.success.budget.delete'] = 'Le budget <strong>:name</strong> a été supprimé';

// Errors
$lang['financial.warnings'] = 'Attention !!';
$lang['financial.warnings.lamclubs'] = 'Le module Lamclubs est manquant, le module financial ne pourra pas fonctionner correctement.';
$lang['financial.warnings.categories'] = 'Il n\'y a aucune catégorie (activité) déclarée, le module financial ne pourra pas fonctionner correctement.';
$lang['financial.error.invalid.date'] = 'La date entrée est invalide';

// Legend
$lang['financial.legend'] = 'Légende';
$lang['financial.pending.legend.monitoring'] = 'Coucou le trésorier';
$lang['financial.pending.legend.user'] = 'Ça va les dirigeants ?';
?>
