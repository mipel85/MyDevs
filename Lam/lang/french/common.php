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
$lang['lam.form'] = 'Formulaire de demande d\'aide financière';
$lang['lam.form.radio.choices'] = 'Nature de la demande';
$lang['lam.form.activity.type'] = 'Organisation d\'une journée : ';
$lang['lam.fill.form'] = 'Remplir le formulaire <i><span class="smaller">(informations transmises dans le mail)</span></i>';
$lang['lam.activity.desc'] = 'Demande d\'aide pour l\'organisation d\'une journée (portes-ouvertes, qpdd, ailes...)';
$lang['lam.jpo'] = 'Journée portes-ouvertes';
$lang['lam.exam'] = 'Journée d\'examen';

// club_form
$lang['lam.club.infos'] = 'Sélectionner votre club <b>*</b>';
$lang['lam.club.infos.clue'] = 'Commencez la saisie, puis sélectionnez votre club dans la liste déroulante';
$lang['lam.club.name'] = 'Club';
$lang['lam.club.ffam.number'] = 'N°. FFAM';
$lang['lam.club.activity.date'] = 'Date de l\'évènement';
$lang['lam.club.activity.location'] = 'Adresse de l\'activité :';
$lang['lam.club.activity.city'] = 'Ville de l\'activité :';
$lang['lam.club.activity.description'] = 'Description de l\'activité (facultatif) :';
$lang['lam.club.sender.name'] = 'Nom du correspondant :';
$lang['lam.club.sender.mail'] = 'Adresse mail du correspondant :';
$lang['lam.not_registred_fields'] = '<i><span class = "smaller"> Les informations suivantes ne sont ni enregistrées ni conservées sur le site (RGPD) </span></i>';

// config
$lang['lam.check.configuration'] = 'La configuration financière de ce module n\'a pas été effectuée, c\'est ici : <a href="../Lam/admin/config">Page de configuration</a>';
$lang['lam.email.configuration'] = 'Configuration des adresses des destinataires';
$lang['lam.email.configuration.default'] = 'Adresse mail obligatoire. par défaut : :default_mail';
$lang['lam.email.configuration.optional'] = 'Adresse mail optionnelle';
$lang['lam.recipient.mail_1'] = 'Adresse du destinataire principal :';
$lang['lam.recipient.mail_2'] = 'Adresse du destinataire n° 2 :';
$lang['lam.recipient.mail_3'] = 'Adresse du destinataire n° 3 :';
$lang['lam.financial.jpo.part'] = 'Configuration financière - Journée portes-ouvertes';
$lang['lam.financial.exam.part'] = 'Configuration financière - Journée d\'examen <span style="font-size: 13px"><i>(QPDD, ailes, brevets...)</i></span>';
$lang['lam.jpo.total.amount'] = 'Montant total attribué pour les portes-ouvertes';
$lang['lam.jpo.day.amount'] = 'Montant attribué par journée portes-ouvertes';
$lang['lam.exam.total.amount'] = 'Montant total attribué par journée d\'examen';
$lang['lam.exam.day.amount'] = 'Montant attribué par journée d\'examen';
$lang['lam.financial.maximum'] = 'Montant maximum en euros';

//mail
$lang['lam.email.sent'] = 'Votre demande a bien été envoyée à la Ligue';
$lang['lam.mail.msg'] = 'Bonjour, <br /><br />
	<i>Dossier suivi par :club_sender_name (:club_sender_mail)</i><br /><br /> 
        Le club <b>:club_name</b> (affiliation FFAM n° :club_ffam_number) souhaite obtenir une aide pour l\'organisation d\'une :activity prévue le :club_activity_date<br /><br />
        <b>Lieu de l\'activité :</b> :club_activity_location<br /> <br />
        <b>Ville :</b> :club_activity_city.';

// radio buttons
$lang['lam.requests.status'] = 'Situation des demandes';
$lang['lam.jpo.status.requests'] = '<i class="radio-target" aria-hidden="true"></i> Portes-Ouvertes <span class="d-block small">Demandes restantes : :jpo_status_requests</span>';
$lang['lam.exam.status.requests'] = '<i class="radio-target" aria-hidden="true"></i> Examen (ailes, qpdd...) <span class="d-block small">Demandes restantes : :exam_status_requests</span>';

//lists
$lang['lam.filter.items'] = 'Filtres';
$lang['lam.filter.choice'] = 'Choisir une activité';
$lang['lam.activity.requests'] = 'Suivi des demandes';
$lang['lam.financial.statement'] = 'Suivi financier';
$lang['lam.total.planned.budget'] = 'Budget total prévu';
$lang['lam.list.day.amount'] = 'Montant attribué par journée';
$lang['lam.activity.nb.requests'] = 'Nb. de demandes';
$lang['lam.club.request.date'] = 'Date de demande';
$lang['lam.provisional.budget.balance'] = 'Solde provisoire';

?>

