<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 18
 * @since       PHPBoost 6.0 - 2024 01 18
 */
####################################################
#                    French                        #
####################################################
// Home
$lang['financial.home'] = 'Demandes d\'aides financières';
$lang['financial.clubs.module.missing'] = 'Le module LamClubs est manquant et/ou innactif';

// TreeLinks
$lang['financial.treelinks.financial'] = 'Finances';
$lang['financial.treelinks.planning'] = 'Calendrier';

// common
$lang['financial.form.radio.choices'] = 'Nature de la demande';
$lang['financial.requests.description.title'] = '<span class = "requests-description-title">Fonctionnement du formulaire de demande</span>';
$lang['financial.requests.description'] = '<span class = "requests-description">Choisissez le type de journée envisagée puis remplissez le formulaire. Une fois validé, il sera automatiquement envoyé par mail à'
    . ' la Ligue. <br /> Vous pouvez consulter les demandes en cours sur cette page : <a href = "../pending_requests/"><b>Demandes en cours</b></a></span>';
$lang['financial.fill.form'] = 'Remplir le formulaire <i><span class="smaller">(informations transmises dans le mail)</span></i>';
$lang['financial.pending.requests.link'] = 'Consulter les demandes en cours';
$lang['financial.payment.validation.message'] = 'Demande archivée !';

// activity
$lang['financial.activity.title'] = 'Organisation d\'une journée';
$lang['financial.activity.desc'] = 'Organisation journée portes-ouvertes ou examens (Brevets, QPDD, ailes...)';
$lang['financial.jpo'] = 'Journée portes-ouvertes';
$lang['financial.exam'] = 'Journée d\'examen';

// dedicated
$lang['financial.dedicated.desc'] = 'Autres demandes sur fonds dédiés (Handicap, Féminisation, Travaux...)';
$lang['financial.dedicated.details.title'] = 'Précisions sur votre demande';
$lang['financial.dedicated.details'] = 'Décrivez en quelques mots la nature de votre demande.';
$lang['financial.dedicated.title'] = 'Demandes sur fonds dédiés';
$lang['financial.dedicated.choices'] = 'Cliquer sur le bouton concernant <br>la nature de votre demande :';
$lang['financial.dedicated.description'] = '<span class = "requests-description">Ces demandes concernent l\'utilisation des fonds dédiés. Une fois validé, ce formulaire sera automatiquement envoyé par mail à'
    . ' la Ligue. <br /> Vous pouvez consulter les demandes en cours sur cette page : <a href = "../pending_requests/"><b>Demandes en cours</b></a></span>';
$lang['financial.dedicated.handicap'] = 'Handicap';
$lang['financial.dedicated.feminization'] = 'Féminisation';
$lang['financial.dedicated.security'] = 'Sécurité';
$lang['financial.dedicated.works'] = 'Travaux';
$lang['financial.dedicated.others'] = 'Autres';
$lang['financial.form.open'] = 'Ouvrir';
$lang['financial.dedicated.object'] = 'Nature de la demande :';
$lang['financial.dedicated.budget'] = 'Budget estimé (€)';
$lang['financial.dedicated.location'] = 'Adresse concernant votre demande :';
$lang['financial.dedicated.city'] = 'Ville :';
$lang['financial.dedicated.selection'] = 'Choix des demandes :';
$lang['financial.form.url'] = 'Joindre des documents à votre demande :<br>
    <i>(à regrouper dans un fichier .zip qui sera stocké sur le site)</i>';

// config
$lang['financial.check.configuration'] = 'La configuration financière de ce module n\'a pas été effectuée, c\'est ici : <a href="../financial/admin/config">Page de configuration</a>';
$lang['financial.email.configuration'] = 'Configuration des adresses des destinataires';
$lang['financial.email.configuration.default'] = 'Adresse mail obligatoire. par défaut : :default_mail';
$lang['financial.email.configuration.optional'] = 'Adresse mail optionnelle';
$lang['financial.recipient.mail_1'] = 'Adresse du destinataire principal :';
$lang['financial.recipient.mail_2'] = 'Adresse du destinataire n° 2 :';
$lang['financial.recipient.mail_3'] = 'Adresse du destinataire n° 3 :';
$lang['financial.financial.jpo.part'] = 'Configuration financière - Journée portes-ouvertes';
$lang['financial.financial.exam.part'] = 'Configuration financière - Journée d\'examen <span style="font-size: 13px"><i>(QPDD, ailes, brevets...)</i></span>';
$lang['financial.jpo.total.amount'] = 'Montant total attribué pour les portes-ouvertes';
$lang['financial.jpo.day.amount'] = 'Montant attribué par journée portes-ouvertes';
$lang['financial.exam.total.amount'] = 'Montant total attribué par journée d\'examen';
$lang['financial.exam.day.amount'] = 'Montant attribué par journée d\'examen';
$lang['financial.financial.maximum'] = 'Montant maximum en euros';

// club_form
$lang['financial.club.infos'] = 'Sélectionnez votre club';
$lang['financial.club.infos.clue'] = 'Un double clic dans la zone de saisie fait apparaître la liste triée par n° de club.';
$lang['financial.club.ffam.number'] = 'N°. FFAM';
$lang['financial.club.dept'] = 'Dept';
$lang['financial.club.dept.filter'] = 'Département';
$lang['financial.club.name'] = 'Club';
$lang['financial.club.activity.date'] = 'Date de l\'évènement';
$lang['financial.club.activity.location'] = 'Adresse de l\'activité :';
$lang['financial.club.activity.city'] = 'Ville de l\'activité :';
$lang['financial.club.activity.description'] = 'Description de l\'activité (facultatif) :';
$lang['financial.club.sender.name'] = 'Nom du correspondant :';
$lang['financial.club.sender.mail'] = 'Adresse mail du correspondant :';
$lang['financial.not_registred_fields'] = '<i><span class = "smaller"> Les informations suivantes ne sont ni enregistrées ni conservées sur le site (RGPD) </span></i>';

//mail
$lang['financial.email.sent'] = 'Votre demande a bien été envoyée à la Ligue';
$lang['financial.mail.msg'] = 'Bonjour, <br /><br />
	<i>Dossier suivi par :club_sender_name (:club_sender_mail)</i><br /><br /> 
        Le club <b>:club_name</b> (affiliation FFAM n° :club_ffam_number) souhaite obtenir une aide pour l\'organisation d\'une :activity prévue le :club_activity_date<br /><br />
        <b>Lieu de l\'activité :</b> :club_activity_location<br /> <br />
        <b>Ville :</b> :club_activity_city.';

// radio buttons
$lang['financial.requests.status'] = 'Situation des demandes';
$lang['financial.jpo.status.requests'] = '<i class="radio-target" aria-hidden="true"></i> Portes-Ouvertes <span class="d-block small">Demandes restantes : :jpo_status_requests</span>';
$lang['financial.exam.status.requests'] = '<i class="radio-target" aria-hidden="true"></i> Examen (ailes, qpdd...) <span class="d-block small">Demandes restantes : :exam_status_requests</span>';

//lists
$lang['financial.no.current.items'] = 'Aucune demande en cours !';
$lang['financial.no.archived.items'] = 'Aucune demande archivée !';
$lang['financial.filter.choice'] = 'Choisir une activité';
$lang['financial.pending.requests'] = 'Demandes en cours';
$lang['financial.financial.statement'] = 'Suivi financier';
$lang['financial.total.planned.budget'] = 'Budget total prévu';
$lang['financial.list.day.amount'] = 'Budget par journée';
$lang['financial.activity.nb.requests'] = 'Nb. de demandes';
$lang['financial.club.request.date'] = 'Date de demande';
$lang['financial.estimated.amount'] = 'Solde estimé <br /><span class="smaller">(demandes en cours)</span>';
$lang['financial.real.amount'] = 'Solde réel <br /><span class="smaller">(demandes archivées)</span>';
$lang['financial.archived.requests'] = 'Demandes archivées';
$lang['financial.archived.date'] = 'Date d\'archivage';
$lang['financial.amount.paid'] = 'Montant à verser';
$lang['financial.amount.real.paid'] = 'Montant payé';
$lang['financial.club.payment'] = 'Valider paiement et archiver';

// Authorizations
$lang['financial.authorization.requests'] = 'Autorisation de saisie des demandes';
$lang['financial.authorization.treasurer'] = 'Autorisation du suivi financier';
?>
