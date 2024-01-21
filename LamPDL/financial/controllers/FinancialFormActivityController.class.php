<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 18
 * @since       PHPBoost 6.0 - 2024 01 18
 */
class FinancialFormActivityController extends DefaultModuleController
{

    public function execute(HTTPRequestCustom $request)
    {
        $this->init();
        $this->check_authorizations();
        $this->build_form($request);

        if ($this->submit_button->has_been_submited() && $this->form->validate()){
            $this->save();
            $this->send_form_email();
            $this->redirect();
        }

        $this->view->put('CONTENT', $this->form->display());
        return $this->build_response($this->view);
    }

    public function init()
    {
        FinancialService::check_config();
    }

    private function build_form()
    {
        $form = new HTMLForm(__CLASS__);
        $form->set_layout_title($this->lang['financial.activity.title']);

        $requests_description = new FormFieldsetHTML('requests description', $this->lang['financial.requests.description.title']);
        $form->add_fieldset($requests_description);
        $requests_description->set_description($this->lang['financial.requests.description']);

        $choices = new FormFieldsetHTML('activity_type', $this->lang['financial.form.radio.choices']);
        $form->add_fieldset($choices);

        //radio buttons
        $nb_requests = FinancialService::get_remaining_requests_activity(array('jpo', 'exam'));

        $choices->add_field(new FormFieldRadioChoice('form_radio', $this->lang['financial.activity.title'], '', array(
                new FormFieldRadioChoiceOption(
                    StringVars::replace_vars($this->lang['financial.jpo.status.requests'], array('jpo_status_requests' => $nb_requests['nb_jpo_remaining'] . '/' . $nb_requests['nb_jpo_max'])), 'jpo', array('disable' => $nb_requests['nb_jpo_remaining'] == 0)
                ),
                new FormFieldRadioChoiceOption(
                    StringVars::replace_vars($this->lang['financial.exam.status.requests'], array('exam_status_requests' => $nb_requests['nb_exam_remaining'] . '/' . $nb_requests['nb_exam_max'])), 'exam', array('disable' => $nb_requests['nb_exam_remaining'] == 0)
                )
                ), array(
                'required' => true,
                'class'    => 'financial-radio inline-radio',
                )
        ));

        $fieldset = new FormFieldsetHTML('activity', $this->lang['financial.fill.form']);
        $form->add_fieldset($fieldset);

        // other fields
        
        $fieldset->add_field(new FormFieldSimpleSelectChoice('club_infos', $this->lang['financial.club.infos'], $this->get_item()->get_club_id(), LamclubsService::get_options_list(), array('required' => true)));
        $fieldset->add_field(new FormFieldDate('club_activity_date', $this->lang['financial.club.activity.date'], null, array('required' => true)));
        $fieldset->add_field(new FormFieldTextEditor('club_activity_location', $this->lang['financial.club.activity.location'], '', array('required' => true)));
        $fieldset->add_field(new FormFieldTextEditor('club_activity_city', $this->lang['financial.club.activity.city'], '', array('required' => true)));
        $fieldset->add_field(new FormFieldTextEditor('club_activity_description', $this->lang['financial.club.activity.description'], ''));

        $mail_fieldset = new FormFieldsetHTML('mail_form', $this->lang['financial.not_registred_fields']);
        $mail_fieldset->add_field(new FormFieldFree('not_registred_fields', '', ''));
        $mail_fieldset->add_field(new FormFieldTextEditor('club_sender_name', $this->lang['financial.club.sender.name'], '', array('required' => true)));
        $mail_fieldset->add_field(new FormFieldMailEditor('club_sender_mail', $this->lang['financial.club.sender.mail'], '', array('required' => true)));

        $form->add_fieldset($mail_fieldset);

        $this->submit_button = new FormButtonDefaultSubmit('Envoyer la demande', '', '');
        $form->add_button($this->submit_button);
        $form->add_button(new FormButtonReset('Annuler'));

        $this->form = $form;
    }

    private function get_item()
    {
        if ($this->item === null){
            $id = AppContext::get_request()->get_getint('id', 0);
            if (!empty($id)){
                try {
                    $this->item = FinancialService::get_item($id);
                }catch (RowNotFoundException $e){
                    $error_controller = PHPBoostErrors::unexisting_page();
                    DispatchManager::redirect($error_controller);
                }
            }else{
                $this->is_new_item = true;
                $this->item = new FinancialActivityItem();
            }
        }
        return $this->item;
    }

    private function check_authorizations()
    {
        if (!FinancialAuthorizationsService::check_authorizations()->officer()){
            $controller = PHPBoostErrors::user_not_authorized();
            DispatchManager::redirect($controller);
        }
    }

    private function save()
    {
        $activity_item = $this->get_item();
        $activity_item->set_activity_type($this->form->get_value('form_radio')->get_raw_value());
        $activity_item->set_club_id($this->form->get_value('club_infos')->get_raw_value());
        $activity_item->set_club_activity_date($this->form->get_value('club_activity_date'));
        $activity_item->set_club_activity_location($this->form->get_value('club_activity_location'));
        $activity_item->set_club_activity_city($this->form->get_value('club_activity_city'));
        $activity_item->set_club_activity_description($this->form->get_value('club_activity_description'));
        $activity_item->set_club_request_date(new Date());
        $activity_item->set_amount_paid(0);
        $activity_item->set_archived(0);

        $id = FinancialService::add($activity_item);
        $activity_item->set_id($id);
    }

    private function build_response(View $view)
    {
        $response = new SiteDisplayResponse($view);
        $graphical_environment = $response->get_graphical_environment();
        $graphical_environment->set_page_title($this->lang['financial.home']);

        $breadcrumb = $graphical_environment->get_breadcrumb();
        $breadcrumb->add($this->lang['financial.home'], FinancialUrlBuilder::home());
        $breadcrumb->add($this->lang['financial.activity.title'], FinancialUrlBuilder::activity());

        return $response;
    }

    private function send_form_email()
    {
        $item_message = '';
        $activity_type = $this->form->get_value('form_radio')->get_raw_value() == 'jpo' ? $this->lang['financial.jpo'] : $this->lang['financial.exam'];
        $item_subject = $this->lang['financial.activity.desc'] . ' --- ' . $activity_type;
        $item_sender_name = $this->form->get_value('club_sender_name');
        $item_sender_email = $this->form->get_value('club_sender_email');
        $club_item = LamclubsService::get_item($this->item->get_club_id());
        
        //msg content
        $item_message = StringVars::replace_vars($this->lang['financial.mail.msg'], array(
                'club_sender_name'       => $this->form->get_value('club_sender_name'),
                'club_sender_mail'       => $this->form->get_value('club_sender_mail'),
                'club_name'              => $club_item->get_name(),
                'club_ffam_number'       => $club_item->get_ffam_nb(),
                'activity'               => $activity_type,
                'club_activity_date'     => Date::to_format($this->form->get_value('club_activity_date')->get_timestamp(), Date::FORMAT_DAY_MONTH_YEAR),
                'club_activity_location' => $this->form->get_value('club_activity_location'),
                'club_activity_city'     => $this->form->get_value('club_activity_city'),
        ));

        $item_email = new Mail();
        $item_email->set_sender(MailServiceConfig::load()->get_default_mail_sender(), $this->lang['financial.home']);
        $item_email->set_reply_to($item_sender_email, $item_sender_name);
        $item_email->set_subject($item_subject);
        $item_email->set_content(TextHelper::html_entity_decode($item_message));

        $item_email->add_recipient(FinancialConfig::load()->get_recipient_mail_1());
        $item_email->add_recipient(!empty(FinancialConfig::load()->get_recipient_mail_2()) ? FinancialConfig::load()->get_recipient_mail_2() : '');
        $item_email->add_recipient(!empty(FinancialConfig::load()->get_recipient_mail_3()) ? FinancialConfig::load()->get_recipient_mail_3() : '');
        $send_email = AppContext::get_mail_service();

        return $send_email->try_to_send($item_email);
    }

    private function redirect()
    {
        AppContext::get_response()->redirect(FinancialUrlBuilder::home(), $this->lang['financial.email.sent']);
    }
}
?>

