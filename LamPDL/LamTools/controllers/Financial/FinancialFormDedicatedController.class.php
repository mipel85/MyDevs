<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2023 03 03
 * @since       PHPBoost 6.0 - 2022 12 20
 */
class FinancialFormDedicatedController extends DefaultModuleController
{

    public function execute(HTTPRequestCustom $request)
    {
        $this->init();
        $this->check_authorizations();
        $this->build_form($request);

        if ($this->submit_button->has_been_submited() && $this->form->validate()){
            $this->save();
//            $this->send_form_email();
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
        $form->set_layout_title($this->lang['lamfinancial.dedicated.title']);

        $dedicated_description = new FormFieldsetHTML('dedicated description', $this->lang['lamfinancial.requests.description.title']);
        $form->add_fieldset($dedicated_description);
        $dedicated_description->set_description($this->lang['lamfinancial.dedicated.description']);

        $choices = new FormFieldsetHTML('dedicated_type', $this->lang['lamfinancial.form.radio.choices']);
        $form->add_fieldset($choices);

        // radio buttons
        $choices->add_field(new FormFieldRadioChoice('form_radio_dedicated', $this->lang['lamfinancial.dedicated.title'], '', array(
                new FormFieldRadioChoiceOption($this->lang['lamfinancial.dedicated.handicap'], $this->lang['lamfinancial.dedicated.handicap']),
                new FormFieldRadioChoiceOption($this->lang['lamfinancial.dedicated.works'], $this->lang['lamfinancial.dedicated.works']),
                ), array(
                'required' => true,
                'class'    => 'lamfinancial-radio inline-radio',
                )
        ));

        $fieldset = new FormFieldsetHTML('dedicated', $this->lang['lamfinancial.fill.form']);
        $form->add_fieldset($fieldset);

        // other fields
        $fieldset->add_field(new FinancialFormFieldClubsEditor('club_infos', $this->lang['lamfinancial.club.infos'], array(), array('description' => $this->lang['lamfinancial.club.infos.clue'])), array('required' => true));
        $fieldset->add_field(new FormFieldMultiLineTextEditor('club_dedicated_details', $this->lang['lamfinancial.dedicated.details'], '', array('description' => $this->lang['lamfinancial.dedicated.details'])), array('required' => true));
        $fieldset->add_field(new FormFieldNumberEditor('club_dedicated_budget', $this->lang['lamfinancial.dedicated.budget'], '', array('required' => true)));
        $fieldset->add_field(new FormFieldTextEditor('club_dedicated_location', $this->lang['lamfinancial.dedicated.location'], '', array('required' => true)));
        $fieldset->add_field(new FormFieldTextEditor('club_dedicated_city', $this->lang['lamfinancial.dedicated.city'], '', array('required' => true)));

        $mail_fieldset = new FormFieldsetHTML('mail_form', $this->lang['lamfinancial.not_registred_fields']);
        $mail_fieldset->add_field(new FormFieldFree('not_registred_fields', '', ''));
        $mail_fieldset->add_field(new FormFieldTextEditor('club_sender_name', $this->lang['lamfinancial.club.sender.name'], '', array('required' => true)));
        $mail_fieldset->add_field(new FormFieldMailEditor('club_sender_mail', $this->lang['lamfinancial.club.sender.mail'], '', array('required' => true)));

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
                    $this->item = LamToolsService::get_item($id);
                }catch (RowNotFoundException $e){
                    $error_controller = PHPBoostErrors::unexisting_page();
                    DispatchManager::redirect($error_controller);
                }
            }else{
                $this->is_new_item = true;
                $this->item = new FinancialDedicatedItem();
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
        $dedicated_item = $this->get_item();
        $dedicated_item->set_club_request_date(new Date());
        $dedicated_item->set_dedicated_object($this->form->get_value('form_radio_dedicated')->get_raw_value());
        foreach ($this->form->get_value('club_infos') as $id => $club)
        {

            $club = explode(' - ', $club);
            $dedicated_item->set_club_ffam_number($club[0]);
            $dedicated_item->set_club_dept($club[1]);
            $dedicated_item->set_club_name($club[2]);
        }
        $dedicated_item->set_dedicated_details($this->form->get_value('club_dedicated_details'));
        $dedicated_item->set_dedicated_budget($this->form->get_value('club_dedicated_budget'));
        $dedicated_item->set_club_activity_location($this->form->get_value('club_dedicated_location'));
        $dedicated_item->set_club_activity_city($this->form->get_value('club_dedicated_city'));
        $dedicated_item->set_archived(0);
        $id = LamToolsService::add($dedicated_item);
        $dedicated_item->set_id($id);
    }

    private function build_response(View $view)
    {
        $response = new SiteDisplayResponse($view);
        $graphical_environment = $response->get_graphical_environment();
        $graphical_environment->set_page_title($this->lang['lamfinancial.dedicated.title']);

        $breadcrumb = $graphical_environment->get_breadcrumb();
        $breadcrumb->add($this->lang['lamfinancial.home'], ToolsUrlBuilder::home());
        $breadcrumb->add($this->lang['lamfinancial.dedicated.title'], ToolsUrlBuilder::dedicated());

        return $response;
    }

    private function send_form_email()
    {
        $item_message = '';
        $dedicated_type = $this->form->get_value('form_radio_dedicated');
        $item_subject = $this->lang['lamfinancial.activity.desc'] . ' --- ' . $activity_type;
        $item_sender_name = $this->form->get_value('club_sender_name');
        $item_sender_email = $this->form->get_value('club_sender_email');

        //msg content
        $item_message = StringVars::replace_vars($this->lang['lamfinancial.mail.msg'], array(
                'club_sender_name' => $this->form->get_value('club_sender_name'),
                'club_sender_mail' => $this->form->get_value('club_sender_mail'),
                'club_name'        => $this->item->get_club_name(),
                'club_ffam_number' => $this->item->get_club_ffam_number(),
//                'activity'               => $activity_type,
//                'club_activity_date'     => Date::to_format($this->form->get_value('club_activity_date')->get_timestamp(), Date::FORMAT_DAY_MONTH_YEAR),
//                'club_activity_location' => $this->form->get_value('club_activity_location'),
//                'club_activity_city'     => $this->form->get_value('club_activity_city'),
        ));

        $item_email = new Mail();
        $item_email->set_sender(MailServiceConfig::load()->get_default_mail_sender(), $this->lang['lamfinancial.form']);
        $item_email->set_reply_to($item_sender_email, $item_sender_name);
        $item_email->set_subject($item_subject);
        $item_email->set_content(TextHelper::html_entity_decode($item_message));

        $item_email->add_recipient(LamToolsConfig::load()->get_recipient_mail_1());
        $item_email->add_recipient(!empty(LamToolsConfig::load()->get_recipient_mail_2()) ? LamToolsConfig::load()->get_recipient_mail_2() : '');
        $item_email->add_recipient(!empty(LamToolsConfig::load()->get_recipient_mail_3()) ? LamToolsConfig::load()->get_recipient_mail_3() : '');
        $send_email = AppContext::get_mail_service();

        return $send_email->try_to_send($item_email);
    }

    private function redirect()
    {
        AppContext::get_response()->redirect(ToolsUrlBuilder::home(), $this->lang['lamfinancial.email.sent']);
    }
}
?>
