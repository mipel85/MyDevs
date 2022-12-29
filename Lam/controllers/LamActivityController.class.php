<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel85@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2022 12 27
 * @since       PHPBoost 6.0 - 2022 12 20
 */
class LamActivityController extends DefaultModuleController
{

    public function execute(HTTPRequestCustom $request)
    {
//        $this->check_authorizations();
        $this->build_form($request);

        if ($this->submit_button->has_been_submited() && $this->form->validate()){
            $this->save();
            // $this->redirect();
        }

        $this->view->put('CONTENT', $this->form->display());
        return $this->build_response($this->view);
    }

    private function build_form()
    {

// Start form
        $form = new HTMLForm(__CLASS__);
        $form->set_layout_title($this->lang['lam.form']);

        //radio buttons
        $fieldset = new FormFieldsetHTML('activity', $this->lang['lam.fill.form']);

        $choices = new FormFieldsetHTML('form_name', $this->lang['lam.form.choices']);
        $form->add_fieldset($choices);

        $choices->add_field(new FormFieldRadioChoice('form_radio', $this->lang['lam.form.activity.type'], '', 
          array(
            new FormFieldRadioChoiceOption($this->lang['lam.jpo'], 'jpo'),
            new FormFieldRadioChoiceOption($this->lang['lam.qpdd'], 'qpdd')
                )
        ));


        $fieldset->add_field(new FormFieldTextEditor('club_name', $this->lang['lam.club.name'], ''));
        $fieldset->add_field(new FormFieldNumberEditor('club_ffam_number', $this->lang['lam.club.ffam.number'], ''));
        $fieldset->add_field(new FormFieldDate('club_activity_date', $this->lang['lam.club.activity.date'], null));
        $fieldset->add_field(new FormFieldTextEditor('club_activity_location', $this->lang['lam.club.activity.location'], ''));
        $fieldset->add_field(new FormFieldTextEditor('club_activity_city', $this->lang['lam.club.activity.city'], ''));
        $fieldset->add_field(new FormFieldTextEditor('club_activity_description', $this->lang['lam.club.activity.description'], ''));
        $fieldset->add_field(new FormFieldTextEditor('club_sender_name', $this->lang['lam.club.sender.name'], ''));
        $fieldset->add_field(new FormFieldTextEditor('club_sender_mail', $this->lang['lam.club.sender.mail'], ''));

        $form->add_fieldset($fieldset);
// End form

        $this->submit_button = new FormButtonDefaultSubmit();
        $form->add_button($this->submit_button);
        $form->add_button(new FormButtonReset());

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
        // if (!$this->config->is_authorized_to_send())
        // {
        // 	$error_controller = PHPBoostErrors::user_not_authorized();
        // 	DispatchManager::redirect($error_controller);
        // }
        if (AppContext::get_current_user()->is_readonly()){
            $controller = PHPBoostErrors::user_in_read_only();
            DispatchManager::redirect($controller);
        }
    }

    private function save()
    {

        $item = $this->get_item();
        $item->set_form_name($this->form->get_value('form_radio')->get_raw_value());
        $item->set_club_name($this->form->get_value('club_name'));
        $item->set_club_ffam_number($this->form->get_value('club_ffam_number'));
        $item->set_club_activity_date($this->form->get_value('club_activity_date'));
        $item->set_club_activity_location($this->form->get_value('club_activity_location'));
        $item->set_club_activity_city($this->form->get_value('club_activity_city'));
        $item->set_club_activity_description($this->form->get_value('club_activity_description'));
        $item->set_club_sender_name($this->form->get_value('club_sender_name'));
        $item->set_club_sender_mail($this->form->get_value('club_sender_mail'));
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
}
?>

