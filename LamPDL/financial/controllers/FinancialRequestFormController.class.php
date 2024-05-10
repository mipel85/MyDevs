<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
 */
class FinancialRequestFormController extends DefaultModuleController
{

    public function execute(HTTPRequestCustom $request)
    {
        $this->check_authorizations();
        $budget_params = FinancialBudgetService::get_budget_params($request->get_value('budget_id'));

        $this->build_form($budget_params);

        if ($this->submit_button->has_been_submited() && $this->form->validate())
        {
            $this->save($budget_params);
            if ($this->is_new_item) {
                $this->send_email();
            }
            if (!$this->is_new_item && !empty($this->form->get_value('invoice_url')) && Url::to_rel($this->form->get_value('invoice_url')) !== $this->get_item()->get_invoice_url()->rel()) {
                $this->send_invoice_email();
            }
            $this->redirect($budget_params);
        }

        $this->view->put('CONTENT', $this->form->display());

        return $this->generate_response($this->view, $request);
    }

    private function build_form($budget_params)
    {
        $description = $this->lang['financial.request.allocated.budget'] . ' : ' . $budget_params['unit_amount'];
        if ($budget_params['max_amount']) $description .= ' (' . StringVars::replace_vars($this->lang['financial.bill.max.amount'], array('max_amount' => $budget_params['max_amount'])) . ' ' . $this->lang['financial.bill'] . ')';
        if ($budget_params['use_dl'] && $budget_params['bill_needed']) $description .= $this->lang['financial.request.bill'];

        $item = $this->get_item();

        $form = new HTMLForm(__CLASS__);
        $form->set_layout_title($item->get_id() === null ? $this->lang['financial.item.add'] : $this->lang['financial.item.edit']);

        $fieldset = new FormFieldsetHTML('request', $this->lang['financial.request.form.title'] . $budget_params['domain'] .' - ' . $budget_params['name']);
        $fieldset->set_description($description);
        $form->add_fieldset($fieldset);

        $fieldset->add_field(new FormFieldSimpleSelectChoice('club_infos', $this->lang['financial.request.club'], $this->get_item()->get_lamclubs_id(), LamclubsService::get_options_list(),
            array('required' => true)
        ));

        $fieldset->add_field(new FormFieldDate('event_date', $this->lang['financial.request.event.date'], $this->get_item()->get_event_date(),
            array('required' => true)
        ));

        if ($budget_params['use_dl']){
            $fieldset->add_field($estimate_url = new FormFieldUploadFile('estimate_url', $this->lang['financial.request.estimate.url'], $this->get_item()->get_estimate_url()->relative(),
                array('description' => $this->lang['financial.request.estimate.url.clue']),
            ));

            $fieldset->add_field(new FormFieldUploadFile('invoice_url', $this->lang['financial.request.invoice.url'], $this->get_item()->get_invoice_url()->relative(),
                array('description' => $this->lang['financial.request.invoice.url.clue'])
            ));
        }

        $email_fieldset = new FormFieldsetHTML('email', $this->lang['financial.request.email']);
        $email_fieldset->set_description($this->lang['financial.request.email.clue']);
        $form->add_fieldset($email_fieldset);

        $email_fieldset->add_field(new FormFieldTextEditor('sender_name', $this->lang['financial.request.contact.user'], $item->get_sender_name(),
            array('required' => true)
        ));

        $email_fieldset->add_field(new FormFieldMailEditor('sender_email', $this->lang['financial.request.contact.email'], $item->get_sender_email(),
            array(
                'required'    => true,
                'description' => $this->lang['financial.request.contact.email.clue']
                )
        ));

        if ($this->is_new_item || $this->get_item()->get_agreement_state() == FinancialRequestItem::ONGOING)
        {
            $email_fieldset->add_field(new FormFieldMultiLineTextEditor('sender_description', $this->lang['financial.request.message'], '',
                array('description' => $this->lang['financial.request.message.clue'])
            ));
        }

        $this->build_contribution_fieldset($form);

        $this->submit_button = new FormButtonDefaultSubmit();
        $form->add_button($this->submit_button);
        $form->add_button(new FormButtonReset());

        $this->form = $form;
    }

    private function save($budget_params)
    {
        $item = $this->get_item();

        $item->set_budget_id($budget_params['id']);

        $item->set_title($budget_params['name'] . ' - ' . $budget_params['fiscal_year']);
        $item->set_rewrited_title(Url::encode_rewrite($item->get_title()));

        $item->set_lamclubs_id($this->form->get_value('club_infos')->get_raw_value());
        $item->set_event_date($this->form->get_value('event_date'));
        $item->set_sender_name($this->form->get_value('sender_name'));
        $item->set_sender_email($this->form->get_value('sender_email'));

        if ($budget_params['use_dl'])
        {
            $club = LamclubsService::get_item($item->get_lamclubs_id());
            $ffam_nb = $club->get_ffam_nb();

            if(Url::to_rel($this->form->get_value('estimate_url')) !== $item->get_estimate_url()->rel())
            {
                $filename = $this->get_filename($this->form->get_value('estimate_url'));
                $renamed_file = copy(
                    PATH_TO_ROOT . $this->form->get_value('estimate_url'),
                    PATH_TO_ROOT . '/financial/files/' . $ffam_nb . '_' . $filename
                );
                $item->set_estimate_url(new Url('/financial/files/' . $ffam_nb . '_' . $filename));
            }
            else
                $item->set_estimate_url(new Url($this->form->get_value('estimate_url')));

            if(Url::to_rel($this->form->get_value('invoice_url')) !== $item->get_invoice_url()->rel())
            {
                $filename = $this->get_filename($this->form->get_value('invoice_url'));
                $renamed_file = copy(
                    PATH_TO_ROOT . $this->form->get_value('invoice_url'),
                    PATH_TO_ROOT . '/financial/files/' . $ffam_nb . '_' . $filename
                );
                $item->set_invoice_url(new Url('/financial/files/' . $ffam_nb . '_' . $filename));
            }
            else
                $item->set_invoice_url(new Url($this->form->get_value('invoice_url')));
        }

        if ($this->is_new_item)
        {
            $item->set_agreement_state(FinancialRequestItem::PENDING);
            $item->set_creation_date(new Date());
            $item_id = FinancialRequestService::add_item($item);
            $item->set_id($item_id);
            FinancialMonitoringService::add_pending_request($item->get_id());

            if (!$this->is_contributor_member()) HooksService::execute_hook_action('add', self::$module_id, array_merge($item->get_properties(), array('item_url' => $item->get_item_url())));
        }
        else
        {
            $item_id = FinancialRequestService::update_item($item);

            if (!$this->is_contributor_member()) HooksService::execute_hook_action('edit', self::$module_id, array_merge($item->get_properties(), array('item_url' => $item->get_item_url())));
        }

        $this->contribution_actions($item);

        FinancialRequestService::clear_cache();
    }

    private function send_email()
    {
        $item = $this->get_item();
        $club = LamclubsService::get_item($item->get_lamclubs_id());

        $item_message = '';

        //msg content
        $item_message = StringVars::replace_vars($this->lang['financial.mail.msg'], array(
            'club_sender_name'   => $this->form->get_value('sender_name'),
            'club_sender_email'  => $this->form->get_value('sender_email'),
            'club_name'          => $club->get_name(),
            'club_ffam_number'   => $club->get_ffam_nb(),
            'activity'           => $item->get_title(),
            'club_activity_date' => $item->get_event_date()->format(Date::FORMAT_DAY_MONTH_YEAR),
            'club_activity_dpt'  => $club->get_department(),
            'description'        => !empty($this->form->get_value('sender_description')) ? $this->form->get_value('sender_description') : ''
        ));

        $item_email = new Mail();
        $item_email->set_sender(FinancialConfig::load()->get_recipient_mail_1(), $this->lang['financial.module.title']);
        $item_email->set_reply_to($this->form->get_value('sender_email'), $this->form->get_value('sender_name'));
        $item_email->set_subject($this->lang['financial.module.title'] . ' - ' . $club->get_name() . ' - ' . $item->get_title());
        $item_email->set_content(TextHelper::html_entity_decode($item_message));

        $item_email->add_recipient(FinancialConfig::load()->get_recipient_mail_1());
        $item_email->add_recipient(!empty(FinancialConfig::load()->get_recipient_mail_2()) ? FinancialConfig::load()->get_recipient_mail_2() : '');
        $item_email->add_recipient(!empty(FinancialConfig::load()->get_recipient_mail_3()) ? FinancialConfig::load()->get_recipient_mail_3() : '');
        $send_email = AppContext::get_mail_service();

        return $send_email->try_to_send($item_email);
    }

    private function send_invoice_email()
    {
        $item = $this->get_item();
        $club = LamclubsService::get_item($item->get_lamclubs_id());

        $item_message = '';

        //msg content
        $item_message = StringVars::replace_vars($this->lang['financial.mail.invoice.msg'], array(
            'club_sender_name'   => $this->form->get_value('sender_name'),
            'club_sender_email'  => $this->form->get_value('sender_email'),
            'club_name'          => $club->get_name(),
            'club_ffam_number'   => $club->get_ffam_nb(),
            'activity'           => $item->get_title()
        ));

        $item_email = new Mail();
        $item_email->set_sender(FinancialConfig::load()->get_recipient_mail_1(), $this->lang['financial.module.title']);
        $item_email->set_reply_to($this->form->get_value('sender_email'), $this->form->get_value('sender_name'));
        $item_email->set_subject($this->lang['financial.module.title'] . ' - ' . $club->get_name() . ' - ' . $item->get_title());
        $item_email->set_content(TextHelper::html_entity_decode($item_message));

        $item_email->add_recipient(FinancialConfig::load()->get_recipient_mail_1());
        $item_email->add_recipient(!empty(FinancialConfig::load()->get_recipient_mail_2()) ? FinancialConfig::load()->get_recipient_mail_2() : '');
        $item_email->add_recipient(!empty(FinancialConfig::load()->get_recipient_mail_3()) ? FinancialConfig::load()->get_recipient_mail_3() : '');
        $send_email = AppContext::get_mail_service();

        return $send_email->try_to_send($item_email);
    }

    private function build_contribution_fieldset($form)
    {
        if ($this->get_item()->get_id() === null && $this->is_contributor_member())
        {
            $fieldset = new FormFieldsetHTML('contribution', $this->lang['contribution.contribution']);
            $fieldset->set_description(MessageHelper::display($this->lang['contribution.extended.warning'], MessageHelper::WARNING)->render());
            $form->add_fieldset($fieldset);

            $fieldset->add_field(new FormFieldMultiLineTextEditor('contribution_description', $this->lang['contribution.description'], '', 
                array('description' => $this->lang['contribution.description.clue'])
            ));
        }
        elseif ($this->get_item()->is_authorized_to_edit() && $this->is_contributor_member())
        {
            $fieldset = new FormFieldsetHTML('member_edition', $this->lang['contribution.member.edition']);
            $fieldset->set_description(MessageHelper::display($this->lang['contribution.edition.warning'], MessageHelper::WARNING)->render());
            $form->add_fieldset($fieldset);

            $fieldset->add_field(new FormFieldMultiLineTextEditor('edition_description', $this->lang['contribution.edition.description'], '',
                array('description' => $this->lang['contribution.edition.description.clue'])
            ));
        }
    }

    private function is_contributor_member()
    {
        return (!FinancialAuthorizationsService::check_authorizations()->write() && FinancialAuthorizationsService::check_authorizations()->contribution());
    }

    private function get_item()
    {
        if ($this->item === null){
            $id = AppContext::get_request()->get_getint('id', 0);
            if (!empty($id))
            {
                try {
                    $this->item = FinancialRequestService::get_item($id);
                }catch (RowNotFoundException $e){
                    $error_controller = PHPBoostErrors::unexisting_page();
                    DispatchManager::redirect($error_controller);
                }
            }
            else
            {
                $this->is_new_item = true;
                $this->item = new FinancialRequestItem();
                $this->item->init_default_properties();
            }
        }
        return $this->item;
    }

    private function check_authorizations()
    {
        $item = $this->get_item();

        if ($item->get_id() === null)
        {
            if (!$item->is_authorized_to_add())
            {
                $error_controller = PHPBoostErrors::user_not_authorized();
                DispatchManager::redirect($error_controller);
            }
        }
        else
        {
            if (!$item->is_authorized_to_edit())
            {
                $error_controller = PHPBoostErrors::user_not_authorized();
                DispatchManager::redirect($error_controller);
            }
        }
        if (AppContext::get_current_user()->is_readonly())
        {
            $error_controller = PHPBoostErrors::user_in_read_only();
            DispatchManager::redirect($error_controller);
        }
    }

    private function get_filename($url)
    {
        $path_parts = explode('/', $url);
        return end($path_parts);
    }

    private function contribution_actions(FinancialRequestItem $item)
    {
        if ($this->is_contributor_member())
        {
            $contribution = new Contribution();
            $contribution->set_id_in_module($item->get_id());
            if ($this->is_new_item) $contribution->set_description(stripslashes($this->form->get_value('contribution_description')));
            else $contribution->set_description(stripslashes($this->form->get_value('edition_description')));

            $contribution->set_entitled($item->get_title());
            $contribution->set_fixing_url(FinancialUrlBuilder::edit_item($item->get_id(), $item->get_budget_id())->relative());
            $contribution->set_poster_id(AppContext::get_current_user()->get_id());
            $contribution->set_module('financial');
            $contribution->set_auth(
                FinancialAuthorizationsService::check_authorizations()->contribution()
            );
            ContributionService::save_contribution($contribution);
            HooksService::execute_hook_action($this->is_new_item ? 'add_contribution' : 'edit_contribution', self::$module_id, array_merge($contribution->get_properties(), $item->get_properties(), array('item_url' => $item->get_item_url())));
        }
        else
        {
            $corresponding_contributions = ContributionService::find_by_criteria('financial', $item->get_id());
            if (count($corresponding_contributions) > 0){
                foreach ($corresponding_contributions as $contribution)
                {
                    $contribution->set_status(Event::EVENT_STATUS_PROCESSED);
                    ContributionService::save_contribution($contribution);
                }
                HooksService::execute_hook_action('process_contribution', self::$module_id, array_merge($contribution->get_properties(), $item->get_properties(), array('item_url' => $item->get_item_url())));
            }
        }
    }

    private function redirect($budget_params)
    {
        $item = $this->get_item();
        if ($this->is_new_item){
            AppContext::get_response()->redirect(FinancialUrlBuilder::display_pending_items(), StringVars::replace_vars($this->lang['financial.message.success.add'], array('title' => $item->get_title())));
        }else{
            AppContext::get_response()->redirect(($this->form->get_value('referrer') ? $this->form->get_value('referrer') : FinancialUrlBuilder::display_pending_items()), StringVars::replace_vars($this->lang['financial.message.success.edit'], array('title' => $item->get_title())));
        }
    }

    private function generate_response(View $view, HTTPRequestCustom $request)
    {
        $item = $this->get_item();

        $location_id = $item->get_id() ? 'item-edit-' . $item->get_id() : '';

        $response = new SiteDisplayResponse($view, $location_id);
        $graphical_environment = $response->get_graphical_environment();

        $breadcrumb = $graphical_environment->get_breadcrumb();
        $breadcrumb->add($this->lang['financial.module.title'], FinancialUrlBuilder::home());

        if ($item->get_id() === null)
        {
            $graphical_environment->set_page_title($this->lang['financial.item.add'], $this->lang['financial.module.title']);
            $breadcrumb->add($this->lang['financial.item.add'], FinancialUrlBuilder::add_item($request->get_value('budget_id')));
            $graphical_environment->get_seo_meta_data()->set_description($this->lang['financial.item.add']);
            $graphical_environment->get_seo_meta_data()->set_canonical_url(FinancialUrlBuilder::add_item($request->get_value('budget_id')));
        }
        else
        {
            if (!AppContext::get_session()->location_id_already_exists($location_id)) $graphical_environment->set_location_id($location_id);

            $graphical_environment->set_page_title($this->lang['financial.item.edit'], $this->lang['financial.module.title']);

            $breadcrumb->add($this->lang['financial.item.edit'], FinancialUrlBuilder::edit_item($item->get_id(), $request->get_value('budget_id')));
            $graphical_environment->get_seo_meta_data()->set_description($this->lang['financial.item.edit']);
            $graphical_environment->get_seo_meta_data()->set_canonical_url(FinancialUrlBuilder::edit_item($item->get_id(), $request->get_value('budget_id')));
        }

        return $response;
    }
}
?>
