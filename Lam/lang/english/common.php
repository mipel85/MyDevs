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
$lang['lam.form'] = 'Financial aid application form';
$lang['lam.form.radio.choices'] = 'Nature of the request';
$lang['lam.form.activity.type'] = 'Organization of a day : ';
$lang['lam.fill.form'] = 'Fill in the form <i><span class="smaller">(information sent in the email)</span></i>';
$lang['lam.activity.desc'] = 'Help request for the organization of a day (open house, qpdd, wings...)';
$lang['lam.jpo'] = 'Open day';
$lang['lam.exam'] = 'Exam day';

// club_form
$lang['lam.club.infos'] = 'Select your club <b>*</b>';
$lang['lam.club.infos.clue'] = 'Start typing, then select your club from the drop-down list';
$lang['lam.club.name'] = 'Club';
$lang['lam.club.ffam.number'] = 'FFAM number';
$lang['lam.club.activity.date'] = 'Event date';
$lang['lam.club.activity.location'] = 'Activity adress :';
$lang['lam.club.activity.city'] = 'City of activity :';
$lang['lam.club.activity.description'] = 'Description of the activity (optional) :';
$lang['lam.club.sender.name'] = 'Correspondent\'s name :';
$lang['lam.club.sender.mail'] = 'Correspondent\'s email address :';
$lang['lam.not_registred_fields'] = '<i><span class = "smaller"> The following information is neither recorded nor stored on the site (RGPD) </span></i>';

// config
$lang['lam.check.configuration'] = 'The financial configuration of this module has not been made, it is here : <a href="../Lam/admin/config">Setup page</a>';
$lang['lam.email.configuration'] = 'Configuring recipient addresses';
$lang['lam.email.configuration.default'] = 'Adresse mail obligatoire. par défaut : :default_mail';
$lang['lam.email.configuration.optional'] = 'Optional email address';
$lang['lam.recipient.mail_1'] = 'Main consignee address :';
$lang['lam.recipient.mail_2'] = 'Address of consignee 2 :';
$lang['lam.recipient.mail_3'] = 'Address of consignee 3 :';
$lang['lam.financial.jpo.part'] = 'Financial Setup - Open Day';
$lang['lam.financial.exam.part'] = 'Financial Setup - Exam Day <span style="font-size: 13px"><i>(QPDD, Wings, Patents...)</i></span>';
$lang['lam.jpo.total.amount'] = 'Total amount allocated for open days';
$lang['lam.jpo.day.amount'] = 'Amount allocated for one open day';
$lang['lam.exam.total.amount'] = 'Total amount allocated for exam days';
$lang['lam.exam.day.amount'] = 'Amount allocated for one exam day';
$lang['lam.financial.maximum'] = 'Maximum amount in euros';

//mail
$lang['lam.email.sent'] = 'Your request has been sent to the League';
$lang['lam.mail.msg'] = 'Good morning, <br /><br />
	<i>Activity followed by :club_sender_name (:club_sender_mail)</i><br /><br /> 
        The club <b>:club_name</b> (FFAM affiliation n° :club_ffam_number) would like to obtain assistance for the organization of a :activity scheduled on :club_activity_date<br /><br />
        <b>Location of the activity :</b> :club_activity_location<br /><br /> 
        <b>City :</b> :club_activity_city.';

// radio buttons
$lang['lam.requests.status'] = 'Status of requests';
$lang['lam.jpo.status.requests'] = '<i class="radio-target" aria-hidden="true"></i> open doors <span class="d-block small">remaining requests : :jpo_status_requests</span>';
$lang['lam.exam.status.requests'] = '<i class="radio-target" aria-hidden="true"></i> Exam (wings, qpdd...) <span class="d-block small">remaining requests : :exam_status_requests</span>';

//lists
$lang['lam.filter.items'] = 'Filters';
$lang['lam.filter.choice'] = 'Choose an activity';
$lang['lam.activity.requests'] = 'Follow-up of requests';
$lang['lam.financial.statement'] = 'Financial monitoring';
$lang['lam.total.planned.budget'] = 'Total planned budget';
$lang['lam.list.day.amount'] = 'Amount allocated per Day';
$lang['lam.activity.nb.requests'] = 'number of requests';
$lang['lam.club.request.date'] = 'request date';
$lang['lam.provisional.budget.balance'] = 'Provisional balance';


?>


