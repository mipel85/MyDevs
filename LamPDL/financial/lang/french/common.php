<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 11
 * @since       PHPBoost 6.0 - 2024 12 04
 */

###################################################
#                    French                        #
####################################################

$lang['financial.module.title'] = 'Aide Financière';

$lang['financial.item'] = 'demande';
$lang['financial.items'] = 'demandes';

// TreeLinks
$lang['financial.budgets.management'] = 'Gestion des budgets';
$lang['financial.budget.add'] = 'Ajouter un budget';
$lang['financial.budget.edit'] = 'Modifier un budget';
$lang['financial.budget.archived'] = 'Budgets archivés';
$lang['financial.requests.archived'] = 'Demandes archivées';

// Titles
$lang['financial.item.add'] = 'Ajouter une demande';
$lang['financial.item.edit'] = 'Modifier une demande';
$lang['financial.item.delete'] = 'Supprimer la demande';
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
$lang['financial.club.dpt'] = 'Dépt.';
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
$lang['financial.display.year'] = 'Afficher l\'exercice :';
$lang['financial.budget.domain'] = 'Domaine';
$lang['financial.budget.name'] = 'Nom du budget';
$lang['financial.amount.paid'] = 'Montant versé';
$lang['financial.budget.description'] = 'Description du budget';
$lang['financial.budget.fiscal.year'] = 'Année de l\'exercice';
$lang['financial.budget.annual.amount'] = 'Budget annuel';
$lang['financial.budget.pending'] = 'Des demandes sont en attente';
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
$lang['financial.request.decimal.input'] = '<strong>Saisir le montant sous la forme 9999.99</strong>';
$lang['financial.input.number.length'] = '<strong>Le montant saisi ne doit pas dépasser 4 chiffres et 2 décimales.</strong>';
$lang['financial.request.allocated.budget'] = 'Budget alloué pour cette demande';
$lang['financial.request.bill'] = '
    <br /><span class="message-helper bgc warning">Attention !!!<br />Vous devez fournir un devis, une facture ou un bilan financier selon la demande !
    <br />Pour les travaux, vous pouvez fournir un devis en début de processus, vous pourrez plus tard fournir une facture pour obtenir le paiement.</span>
';
$lang['financial.request.club'] = 'Identifiants du club';
$lang['financial.request.city'] = 'Ville';
$lang['financial.request.event.date'] = 'Prévue le';
$lang['financial.request.creation.date'] = 'Créée le';
$lang['financial.request.validation.date'] = 'Validée le';
$lang['financial.request.content'] = 'Descriptif (optionnel)';
$lang['financial.request.files.url'] = 'Fichiers';
$lang['financial.request.estimate.url'] = 'Devis ou budget prévisionnel';
$lang['financial.request.estimate.url.clue'] = 'Si vous n\'avez pas encore de facture';
$lang['financial.request.invoice.url'] = 'Facture ou bilan financier';
$lang['financial.request.invoice.url.clue'] = 'Nécessaire pour le règlement de votre demande';
$lang['financial.request.no.files'] = 'Un devis ou une facture sont nécessaires pour traiter votre demande<br />Éditez avec le bouton <i class=\'fa fa-edit\'></i> pour en ajouter';
$lang['financial.request.no.invoice'] = 'Une facture est nécessaire pour traiter votre demande<br />Éditez avec le bouton <i class=\'fa fa-edit\'></i> pour en ajouter';

$lang['financial.request.email'] = 'Informations email';
$lang['financial.request.email.clue'] = '<i>Les informations suivantes, nécessaires pour les échanges, ne sont pas affichées sur le site.</i>';
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
	<i>Dossier suivi par :club_sender_name (:club_sender_email)</i> - <a href="' . GeneralConfig::load()->get_site_url() . '/financial/pending/">Aller sur le site</a><br /><br /> 
    Le club <strong>:club_name</strong> souhaite obtenir une aide pour la demande : :activity.
    <br /><br /><strong>Département :</strong> :club_activity_dpt
    <br /><strong>Numéro FFAM :</strong> :club_ffam_number
    <br /><strong>Date de réalisation :</strong> :club_activity_date
    <br /><br /><strong>Descriptif :</strong> :request_description
    :signature
';

$lang['financial.mail.confirm.msg'] = 'Bonjour :club_sender_name, <br /><br />
	Votre demande d\'aide financière pour : :activity, concernant votre club :club_name, a bien été prise en compte (<a href="' . GeneralConfig::load()->get_site_url() . '/financial/pending/">Voir le site</a>).
    <br /><br />Elle sera traitée après le :club_activity_date, date de l\'événement.
    <br /><br />Si nécessaire, des informations complémentaires vous seront demandées sur cette même adresse email.
    :signature
';

$lang['financial.paid.mail.msg'] = 'Bonjour, <br /><br />
	<i>Dossier suivi par :club_sender_name (:club_sender_email)</i>
    <br /><br />La demande :activity du :club_activity_date de votre club <strong>:club_ffam_number - :club_name</strong> a été réglée par paiement et archivée.
    :signature
';

$lang['financial.rejected.mail.msg'] = 'Bonjour, <br /><br />
	<i>Dossier suivi par :club_sender_name (:club_sender_email)</i>
    <br /><br />La demande :activity du :club_activity_date de votre club <strong>:club_ffam_number - :club_name</strong> a été refusée.
    <br />Pour plus d\'informations, répondez à ce mail pour obtenir des explications supplémentaires du bureau de la ligue.
    :signature
';

$lang['financial.ongoing.mail.msg'] = 'Bonjour, <br /><br />
	<i>Dossier suivi par :club_sender_name (:club_sender_email)</i>
    <br /><br />La demande :activity du :club_activity_date de votre club <strong>:club_ffam_number - :club_name</strong> a été prise en compte et requiert une action de votre part :
    <br />- Vous devez fournir une facture.
    :signature
';

$lang['financial.mail.invoice.msg'] = 'Bonjour, <br /><br />
	<i>Dossier suivi par :club_sender_name (:club_sender_email)</i> - <a href="' . GeneralConfig::load()->get_site_url() . '/financial/pending/">Aller sur le site</a><br /><br /> 
    Le club <strong>:club_name</strong> a fourni une facture dans le suivi de son dossier pour la demande : :activity
    <br /><strong>Numéro FFAM :</strong> :club_ffam_number
    <br /><strong>Date de réalisation :</strong> :club_activity_date
    <br /><br /><strong>Descriptif :</strong> :request_description
    :signature
';

$lang['financial.mail.finished.event'] = 'Bonjour, <br /><br />
	L\'événement <strong>:event_title</strong> du club :club_name est terminé. Il peut être traité par le trésorier.
    :signature
';

$lang['financial.mail.signature'] = '<br /><br />
	<i>Ce message a été envoyé par le site <a href="' . GeneralConfig::load()->get_site_url() . '/financial/pending/">' . GeneralConfig::load()->get_site_url() . '</a>
    <br />pour le compte de la Ligue d\'Aéromodélisme des Pays de la Loire<br /></i>
    
';

// Config
$lang['financial.recipient.mail_1'] = 'Adresse du destinataire principal :';
$lang['financial.recipient.mail_2'] = 'Adresse du destinataire n° 2 :';
$lang['financial.recipient.mail_3'] = 'Adresse du destinataire n° 3 :';
$lang['financial.email.configuration.default'] = 'Adresse mail obligatoire. par défaut : :default_mail';
$lang['financial.email.configuration.optional'] = 'Adresse mail optionnelle';

$lang['financial.winter.break'] = 'Suspendre la saisie des demandes, préparation fin d\'exercice';

$lang['financial.reset'] = 'Nouvel exercice comptable';
$lang['financial.reset.clue'] = '
    Mise à jour des compteurs de demandes par budget
';
$lang['financial.reset.date'] = 'Année du nouvel exercice';
$lang['financial.reset.date.clue'] = 'Exactement 4 chiffres';
$lang['financial.reset.button.name'] = 'Valider le nouvel exercice';

// SEO
$lang['financial.seo.description.root'] = 'Tous les demandes du site :site.';
$lang['financial.seo.description.pending'] = 'Tous les demandes en attente.';
$lang['financial.seo.description.member'] = 'Tous les demandes de :author.';
$lang['financial.seo.description.requests.list'] = 'Liste des demandes du site :site.';

// Feed name
$lang['financial.feed.name'] = 'Événement';

// Messages helper
$lang['financial.message.success.add'] = 'La demande <strong>:request_type</strong> a été ajoutée';
$lang['financial.message.success.edit'] = 'La demande <strong>:request_type</strong> a été modifiée';
$lang['financial.message.success.delete'] = 'La demande <strong>:request_type</strong> a été supprimée';
$lang['financial.message.success.reject'] = 'La demande <strong>:request_type</strong> a été rejetée et placée en archive';
$lang['financial.message.success.accept'] = 'La demande <strong>:request_type</strong> a été acceptée et placée en archive';
$lang['financial.message.error.annual.budget'] = 'Le montant déclaré pour la validation de la demande: <strong>:request_type</strong> entraîne un dépassement du budget annuel';
$lang['financial.message.error.maximum.budget'] = 'Le montant maximum prévu pour la demande : <strong>:request_type</strong> est de : <strong>:max_budget€</strong>';
$lang['financial.message.error.remaining.budget'] = 'Le montant saisi pour la demande : <strong>:request_type</strong> est supérieur au budget restant : <strong>:remaining_budget€</strong>';
$lang['financial.message.empty.accept'] = 'Le montant déclaré pour la validation de la demande: <strong>:request_type</strong> ne peut pas être nul';
$lang['financial.message.success.ongoing'] = 'La demande <strong>:request_type</strong> a été placée à l\'étude';

$lang['financial.message.success.budget.add'] = 'Le budget <strong>:budget_type</strong> a été ajouté';
$lang['financial.message.success.budget.edit'] = 'Le budget <strong>:budget_type</strong> a été modifié';
$lang['financial.message.success.budget.delete'] = 'Le budget <strong>:budget_type</strong> a été supprimé';

// Errors
$lang['financial.warnings'] = 'Information !';
$lang['financial.warnings.lamclubs'] = 'Le module Lamclubs est manquant, le module financial ne pourra pas fonctionner correctement.';
$lang['financial.warnings.break'] = 'En vue de la préparation de la fin de l\'exercice comptable, la saisie des demandes est suspendue.<br /> La reprise sera possible après l\'Assemblée Générale.';
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
$lang['financial.legend.user.archived'] = 'Si votre demande n\'apparaît plus, c\'est qu\'elle a été traitée.';
$lang['financial.legend.user.file'] = 'Colonne Fichiers';
$lang['financial.legend.user.none'] = 'vide :  Aucune action n\'est requise pour que votre demande soit étudiée.';
$lang['financial.legend.user.error'] = '<i class="fa fa-circle-question error"></i> : vous devez fournir au moins un devis pour que votre demande soit étudiée.';
$lang['financial.legend.user.warning'] = '<i class="fa fa-triangle-exclamation warning"></i> : votre demande est à l\'étude et une facture vous est demandée.';
$lang['financial.legend.user.estimate'] = '<i class="far fa-file-lines link-color"></i> : vous avez fourni un devis.';
$lang['financial.legend.user.invoice'] = '<i class="fa fa-file-contract link-color"></i> : vous avez fourni une facture.';

$lang['financial.legend.user.controls'] = 'Pour chacune de vos demandes, vous avez accès à des boutons de contrôle.';
$lang['financial.legend.user.edit'] = '<i class="far fa-edit link-color"></i> pour éditer votre demande';
$lang['financial.legend.user.delete'] = '<i class="fa fa-trash-alt link-color"></i> pour supprimer votre demande';

// Budjet archives
$lang['financial.archived.budget'] = 'Archive du budget';
$lang['financial.budget.archive.th.budget_domain'] = 'Domaine';
$lang['financial.budget.archive.th.budget_type'] = 'Nom du Budget';
$lang['financial.budget.archive.th.annual_amount'] = 'Budget annuel';
$lang['financial.budget.archive.th.real_amount'] = 'Solde<br /><span class="smaller">en fin d\'exercice</span>';
$lang['financial.budget.archive.th.unit_amount'] = 'Forfait';
$lang['financial.budget.archive.th.real_quantity'] = 'Quantité<br /><span class="smaller">en fin d\'exercice</span>';
$lang['financial.budget.archive.th.quantity'] = 'Quantité';
$lang['financial.budget.archive.no.tables'] = 'Aucune archive de budget n\'a été créée.';
$lang['financial.budget.archive.unexists'] = 'Aucune table n\'existe pour cet exercice.';
$lang['financial.budget.archive.home'] = 'Sélectionner une date dans le sélecteur "Afficher l\'année".';

// financial statement
$lang['financial.statement'] = 'Situation financière';
$lang['financial.pending.chart'] = 'Demandes en attente';
$lang['financial.chart.budgets.used'] = 'Graphique des dépenses par activités';
$lang['financial.budgets.statement'] = 'Liste des dépenses par activités';
?>
