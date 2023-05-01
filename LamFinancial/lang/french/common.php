<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2023 03 03
 * @since       PHPBoost 6.0 - 2022 12 20
 */
####################################################
#                    French                        #
####################################################
// commmon
$lang['lamfinancial.requests.description.title'] = '<span class = "requests-description-title">Fonctionnement du formulaire de demande</span>';
$lang['lamfinancial.requests.description'] = '<span class = "requests-description">Choisissez le type de journée envisagée puis remplissez le formulaire. Une fois validé, il sera automatiquement envoyé par mail à'
    . ' la Ligue. <br /> Vous pouvez consulter les demandes en cours sur cette liste : <a href = "../pending_requests/"><b>Demandes en cours</b></a></span>';
$lang['lamfinancial.form'] = 'Formulaire de demande d\'aide financière';
$lang['lamfinancial.form.radio.choices'] = 'Demande';
$lang['lamfinancial.form.activity.type'] = 'Organisation d\'une journée : ';
$lang['lamfinancial.fill.form'] = 'Remplir le formulaire <i><span class="smaller">(informations transmises dans le mail)</span></i>';
$lang['lamfinancial.activity.desc'] = 'Demande d\'aide pour l\'organisation d\'une journée (portes-ouvertes, qpdd, ailes...)';
$lang['lamfinancial.pending.requests.link'] = 'Consulter les demandes en cours';
$lang['lamfinancial.jpo'] = 'Journée portes-ouvertes';
$lang['lamfinancial.exam'] = 'Journée d\'examen';
$lang['lamfinancial.payment.validation.message'] = 'Demande archivée !';

// club_form
$lang['lamfinancial.club.infos'] = 'Sélectionner votre club <b>*</b>';
$lang['lamfinancial.club.infos.clue'] = 'Commencez la saisie, puis sélectionnez votre club dans la liste déroulante';
$lang['lamfinancial.club.name'] = 'Club';
$lang['lamfinancial.club.ffam.number'] = 'N°. FFAM';
$lang['lamfinancial.club.activity.date'] = 'Date de l\'évènement';
$lang['lamfinancial.club.activity.location'] = 'Adresse de l\'activité :';
$lang['lamfinancial.club.activity.city'] = 'Ville de l\'activité :';
$lang['lamfinancial.club.activity.description'] = 'Description de l\'activité (facultatif) :';
$lang['lamfinancial.club.sender.name'] = 'Nom du correspondant :';
$lang['lamfinancial.club.sender.mail'] = 'Adresse mail du correspondant :';
$lang['lamfinancial.not_registred_fields'] = '<i><span class = "smaller"> Les informations suivantes ne sont ni enregistrées ni conservées sur le site (RGPD) </span></i>';

// config
$lang['lamfinancial.check.configuration'] = 'La configuration financière de ce module n\'a pas été effectuée, c\'est ici : <a href="../LamFinancial/admin/config">Page de configuration</a>';
$lang['lamfinancial.email.configuration'] = 'Configuration des adresses des destinataires';
$lang['lamfinancial.email.configuration.default'] = 'Adresse mail obligatoire. par défaut : :default_mail';
$lang['lamfinancial.email.configuration.optional'] = 'Adresse mail optionnelle';
$lang['lamfinancial.recipient.mail_1'] = 'Adresse du destinataire principal :';
$lang['lamfinancial.recipient.mail_2'] = 'Adresse du destinataire n° 2 :';
$lang['lamfinancial.recipient.mail_3'] = 'Adresse du destinataire n° 3 :';
$lang['lamfinancial.financial.jpo.part'] = 'Configuration financière - Journée portes-ouvertes';
$lang['lamfinancial.financial.exam.part'] = 'Configuration financière - Journée d\'examen <span style="font-size: 13px"><i>(QPDD, ailes, brevets...)</i></span>';
$lang['lamfinancial.jpo.total.amount'] = 'Montant total attribué pour les portes-ouvertes';
$lang['lamfinancial.jpo.day.amount'] = 'Montant attribué par journée portes-ouvertes';
$lang['lamfinancial.exam.total.amount'] = 'Montant total attribué par journée d\'examen';
$lang['lamfinancial.exam.day.amount'] = 'Montant attribué par journée d\'examen';
$lang['lamfinancial.financial.maximum'] = 'Montant maximum en euros';

//mail
$lang['lamfinancial.email.sent'] = 'Votre demande a bien été envoyée à la Ligue';
$lang['lamfinancial.mail.msg'] = 'Bonjour, <br /><br />
	<i>Dossier suivi par :club_sender_name (:club_sender_mail)</i><br /><br /> 
        Le club <b>:club_name</b> (affiliation FFAM n° :club_ffam_number) souhaite obtenir une aide pour l\'organisation d\'une :activity prévue le :club_activity_date<br /><br />
        <b>Lieu de l\'activité :</b> :club_activity_location<br /> <br />
        <b>Ville :</b> :club_activity_city.';

// radio buttons
$lang['lamfinancial.requests.status'] = 'Situation des demandes';
$lang['lamfinancial.jpo.status.requests'] = '<i class="radio-target" aria-hidden="true"></i> Portes-Ouvertes <span class="d-block small">Demandes restantes : :jpo_status_requests</span>';
$lang['lamfinancial.exam.status.requests'] = '<i class="radio-target" aria-hidden="true"></i> Examen (ailes, qpdd...) <span class="d-block small">Demandes restantes : :exam_status_requests</span>';

//lists
$lang['lamfinancial.no.current.items'] = 'Aucune demande en cours !';
$lang['lamfinancial.no.archived.items'] = 'Aucune demande archivée !';
$lang['lamfinancial.filter.choice'] = 'Choisir une activité';
$lang['lamfinancial.pending.requests'] = 'Demandes en cours';
$lang['lamfinancial.financial.statement'] = 'Suivi financier';
$lang['lamfinancial.total.planned.budget'] = 'Budget total prévu';
$lang['lamfinancial.list.day.amount'] = 'Budget par journée';
$lang['lamfinancial.activity.nb.requests'] = 'Nb. de demandes';
$lang['lamfinancial.club.request.date'] = 'Date de demande';
$lang['lamfinancial.estimated.amount'] = 'Solde estimé <br /><span class="smaller">(demandes en cours)</span>';
$lang['lamfinancial.real.amount'] = 'Solde réel <br /><span class="smaller">(demandes archivées)</span>';
$lang['lamfinancial.archived.requests'] = 'Demandes archivées';
$lang['lamfinancial.archived.date'] = 'Date d\'archivage';
$lang['lamfinancial.amount.paid'] = 'Montant à verser';
$lang['lamfinancial.amount.real.paid'] = 'Montant payé';
$lang['lamfinancial.club.payment'] = 'Valider paiement et archiver';

// Authorizations
$lang['lamfinancial.authorization.requests'] = 'Autorisation des demandes';
$lang['lamfinancial.authorization.treasurer'] = 'Autorisation du suivi financier';
?>