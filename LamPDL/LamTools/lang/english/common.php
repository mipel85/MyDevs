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
$lang['lamfinancial.financial.requests.description.title'] = '<span class = "requests-description-title">How the application form works</span>';
$lang['lamfinancial.requests.description'] = '<span class = "requests-description">Choose the type of day envisaged then fill in the form. Once validated, it will be automatically sent by email'
    . ' to the League. <br /> You can consult current requests on this list : <a href = "../pending_requests/"><b>Pending requests</b></a></span>';
$lang['lamfinancial.form'] = 'Financial aid application form';
$lang['lamfinancial.form.radio.choices'] = 'Nature of the request';
$lang['lamfinancial.form.activity.type'] = 'Organization of a day : ';
$lang['lamfinancial.fill.form'] = 'Fill in the form <i><span class="smaller">(information sent in the email)</span></i>';
$lang['lamfinancial.activity.desc'] = 'Help request for the organization of a day (open house, qpdd, wings...)';
$lang['lamfinancial.pending.requests.link'] = 'View current requests';
$lang['lamfinancial.jpo'] = 'Open day';
$lang['lamfinancial.exam'] = 'Exam day';
$lang['lamfinancial.payment.validation.message'] = 'archived request !';

// club_form
$lang['lamfinancial.club.infos'] = 'Select your club <b>*</b>';
$lang['lamfinancial.club.infos.clue'] = 'Start typing, then select your club from the drop-down list';
$lang['lamfinancial.club.name'] = 'Club';
$lang['lamfinancial.club.ffam.number'] = 'FFAM number';
$lang['lamfinancial.club.activity.date'] = 'Event date';
$lang['lamfinancial.club.activity.location'] = 'Activity adress :';
$lang['lamfinancial.club.activity.city'] = 'City of activity :';
$lang['lamfinancial.club.activity.description'] = 'Description of the activity (optional) :';
$lang['lamfinancial.club.sender.name'] = 'Correspondent\'s name :';
$lang['lamfinancial.club.sender.mail'] = 'Correspondent\'s email address :';
$lang['lamfinancial.not_registred_fields'] = '<i><span class = "smaller"> The following information is neither recorded nor stored on the site (RGPD) </span></i>';

// config
$lang['lamfinancial.check.configuration'] = 'The financial configuration of this module has not been made, it is here : <a href="../Lam/admin/config">Setup page</a>';
$lang['lamfinancial.email.configuration'] = 'Configuring recipient addresses';
$lang['lamfinancial.email.configuration.default'] = 'Mandatory email address. By default: :default_mail';
$lang['lamfinancial.email.configuration.optional'] = 'Optional email address';
$lang['lamfinancial.recipient.mail_1'] = 'Main consignee address :';
$lang['lamfinancial.recipient.mail_2'] = 'Address of consignee 2 :';
$lang['lamfinancial.recipient.mail_3'] = 'Address of consignee 3 :';
$lang['lamfinancial.financial.jpo.part'] = 'Financial Setup - Open Day';
$lang['lamfinancial.financial.exam.part'] = 'Financial Setup - Exam Day <span style="font-size: 13px"><i>(QPDD, Wings, Patents...)</i></span>';
$lang['lamfinancial.jpo.total.amount'] = 'Total amount allocated for open days';
$lang['lamfinancial.jpo.day.amount'] = 'Amount allocated for one open day';
$lang['lamfinancial.exam.total.amount'] = 'Total amount allocated for exam days';
$lang['lamfinancial.exam.day.amount'] = 'Amount allocated for one exam day';
$lang['lamfinancial.financial.maximum'] = 'Maximum amount in euros';

//mail
$lang['lamfinancial.email.sent'] = 'Your request has been sent to the League';
$lang['lamfinancial.mail.msg'] = 'Good morning, <br /><br />
	<i>Activity followed by :club_sender_name (:club_sender_mail)</i><br /><br /> 
        The club <b>:club_name</b> (FFAM affiliation n° :club_ffam_number) would like to obtain assistance for the organization of a :activity scheduled on :club_activity_date<br /><br />
        <b>Location of the activity :</b> :club_activity_location<br /><br /> 
        <b>City :</b> :club_activity_city.';

// radio buttons
$lang['lamfinancial.requests.status'] = 'Status of requests';
$lang['lamfinancial.jpo.status.requests'] = '<i class="radio-target" aria-hidden="true"></i> open doors <span class="d-block small">remaining requests : :jpo_status_requests</span>';
$lang['lamfinancial.exam.status.requests'] = '<i class="radio-target" aria-hidden="true"></i> Exam (wings, qpdd...) <span class="d-block small">remaining requests : :exam_status_requests</span>';

//lists
$lang['lamfinancial.no.current.items']      = 'No request in progress!';
$lang['lamfinancial.no.archived.items']     = 'No archived request!';
$lang['lamfinancial.filter.choice']         = 'Choose an activity';
$lang['lamfinancial.pending.requests']      = 'Follow-up of requests';
$lang['lamfinancial.financial.statement']   = 'Financial monitoring';
$lang['lamfinancial.total.planned.budget']  = 'Total planned budget';
$lang['lamfinancial.list.day.amount']       = 'Amount allocated per Day';
$lang['lamfinancial.activity.nb.requests']  = 'number of requests';
$lang['lamfinancial.club.request.date']     = 'request date';
$lang['lamfinancial.estimated.amount']      = 'Provisional balance <br /><span class="smaller">(pending requests)</span>';
$lang['lamfinancial.real.amount']           = 'Real amount <br /><span class="smaller">(archived requests)</span>';
$lang['lamfinancial.archived.requests']     = 'archived requests';
$lang['lamfinancial.archived.date']         = 'Archive date';
$lang['lamfinancial.amount.paid']           = 'Total cost to pay';
$lang['lamfinancial.amount.real.paid']      = 'Payroll amount';
$lang['lamfinancial.club.payment']          = 'Validate payment and archive';

// Authorizations
$lang['lamfinancial.authorization.requests'] = 'Authorization of requests';
$lang['lamfinancial.authorization.treasurer'] = 'Financial Tracking Authorization';
?>