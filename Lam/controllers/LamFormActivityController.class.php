<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2023 03 03
 * @since       PHPBoost 6.0 - 2022 12 20
 */
class LamFormActivityController extends DefaultModuleController
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
        
    }

    private function build_form()
    {
        $form = new HTMLForm(__CLASS__);
        $form->set_layout_title($this->lang['lam.form']);

        $choices = new FormFieldsetHTML('form_name', $this->lang['lam.form.radio.choices']);
       
        
        $form->add_fieldset($choices);

        //radio buttons
        $nb_requests = LamService::get_remaining_requests_activity(array($this->lang['lam.jpo'], $this->lang['lam.exam']));

        $choices->add_field(new FormFieldRadioChoice('form_radio', $this->lang['lam.form.activity.type'], '', array(
            new FormFieldRadioChoiceOption(
                StringVars::replace_vars($this->lang['lam.jpo.status.requests'], array('jpo_status_requests' => $nb_requests['nb_jpo_remaining'] . '/' . $nb_requests['nb_jpo_max'])), $this->lang['lam.jpo'], array('disable' => $nb_requests['nb_jpo_remaining'] == 0)
            ),
            new FormFieldRadioChoiceOption(
                StringVars::replace_vars($this->lang['lam.exam.status.requests'], array('exam_status_requests' => $nb_requests['nb_exam_remaining'] . '/' . $nb_requests['nb_exam_max'])), $this->lang['lam.exam'], array('disable' => $nb_requests['nb_exam_remaining'] == 0)
            )
            ), array(
            'required' => true,
            'class'    => 'lam-radio inline-radio',
            )
        ));

        $fieldset = new FormFieldsetHTML('activity', $this->lang['lam.fill.form']);
        $form->add_fieldset($fieldset);

        // other fields
        $fieldset->add_field(new LamFormFieldClubsEditor('club_infos', $this->lang['lam.club.infos'], array(), array('description' => $this->lang['lam.club.infos.clue'])));
        $fieldset->add_field(new FormFieldDate('club_activity_date', $this->lang['lam.club.activity.date'], null, array('required' => true)));
        $fieldset->add_field(new FormFieldTextEditor('club_activity_location', $this->lang['lam.club.activity.location'], '', array('required' => true)));
        $fieldset->add_field(new FormFieldTextEditor('club_activity_city', $this->lang['lam.club.activity.city'], '', array('required' => true)));
        $fieldset->add_field(new FormFieldTextEditor('club_activity_description', $this->lang['lam.club.activity.description'], ''));


        $mail_fieldset = new FormFieldsetHTML('mail_form', $this->lang['lam.not_registred_fields']);
        $mail_fieldset->add_field(new FormFieldFree('not_registred_fields', '', ''));
        $mail_fieldset->add_field(new FormFieldTextEditor('club_sender_name', $this->lang['lam.club.sender.name'], '', array('required' => true)));
        $mail_fieldset->add_field(new FormFieldMailEditor('club_sender_mail', $this->lang['lam.club.sender.mail'], '', array('required' => true)));

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
                    $this->item = LamService::get_item($id);
                }catch (RowNotFoundException $e){
                    $error_controller = PHPBoostErrors::unexisting_page();
                    DispatchManager::redirect($error_controller);
                }
            }else{
                $this->is_new_item = true;
                $this->item = new LamItem();
            }
        }
        return $this->item;
    }

    private function check_authorizations()
    {
        if (!AppContext::get_current_user()->check_level(User::MEMBER_LEVEL)){
            $controller = PHPBoostErrors::user_not_authorized();
            DispatchManager::redirect($controller);
        }
    }

    private function save()
    {
        $item = $this->get_item();
        $item->set_form_date(new Date());
        $item->set_form_name($this->form->get_value('form_radio')->get_raw_value());
        foreach ($this->form->get_value('club_infos') as $id => $club)
        {
            $club = explode(' - ', $club);
            $item->set_club_name($club[1]);
            $item->set_club_ffam_number($club[0]);
        }
        $item->set_club_activity_date($this->form->get_value('club_activity_date'));
        $item->set_club_activity_location($this->form->get_value('club_activity_location'));
        $item->set_club_activity_city($this->form->get_value('club_activity_city'));
        $item->set_club_activity_description($this->form->get_value('club_activity_description'));

        $id = LamService::add($item);
        $item->set_id($id);
    }

    private function build_response(View $view)
    {
        $response = new SiteDisplayResponse($view);
        $graphical_environment = $response->get_graphical_environment();
        $graphical_environment->set_page_title($this->lang['lam.form']);

        $breadcrumb = $graphical_environment->get_breadcrumb();
        $breadcrumb->add($this->lang['lam.form'], LamUrlBuilder::home());
        $breadcrumb->add($this->lang['lam.form'], LamUrlBuilder::activity());

        return $response;
    }

    private function send_form_email()
    {
        $item_message = '';
        $item_subject = $this->lang['lam.activity.desc'] . ' : ' . $this->form->get_value('form_radio')->get_raw_value();
        $item_sender_name = $this->form->get_value('club_sender_name');
        $item_sender_email = $this->form->get_value('club_sender_email');

        //msg content
        $item_message = StringVars::replace_vars($this->lang['lam.mail.msg'], array(
                'club_sender_name'       => $this->form->get_value('club_sender_name'),
                'club_sender_mail'       => $this->form->get_value('club_sender_mail'),
                'club_name'              => $this->item->get_club_name(),
                'club_ffam_number'       => $this->item->get_club_ffam_number(),
                'activity'               => $this->form->get_value('form_radio')->get_raw_value(),
                'club_activity_date'     => Date::to_format($this->form->get_value('club_activity_date')->get_timestamp(), Date::FORMAT_DAY_MONTH_YEAR),
                'club_activity_location' => $this->form->get_value('club_activity_location'),
                'club_activity_city'     => $this->form->get_value('club_activity_city'),
        ));

        $item_email = new Mail();
        $item_email->set_sender(MailServiceConfig::load()->get_default_mail_sender(), $this->lang['lam.form']);
        $item_email->set_reply_to($item_sender_email, $item_sender_name);
        $item_email->set_subject($item_subject);
        $item_email->set_content(TextHelper::html_entity_decode($item_message));

        $item_email->add_recipient(LamConfig::load()->get_recipient_mail_1());
        $item_email->add_recipient(!empty(LamConfig::load()->get_recipient_mail_2()) ? LamConfig::load()->get_recipient_mail_2() : '');
        $item_email->add_recipient(!empty(LamConfig::load()->get_recipient_mail_3()) ? LamConfig::load()->get_recipient_mail_3() : '');
        $send_email = AppContext::get_mail_service();

        return $send_email->try_to_send($item_email);
    }

    private function redirect()
    {
        AppContext::get_response()->redirect(LamUrlBuilder::home(), $this->lang['lam.email.sent']);
    }
}
?>

