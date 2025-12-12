<?php
/*
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2025 01 29
 * @since       PHPBoost 6.0 - 2024 02 09
 */

class FinancialRequestRejectController extends DefaultModuleController
{
    public function execute(HTTPRequestCustom $request)
    {
        $item = $this->get_item($request);

        if (!$item->is_authorized_to_delete() || AppContext::get_current_user()->is_readonly())
        {
            $error_controller = PHPBoostErrors::user_not_authorized();
            DispatchManager::redirect($error_controller);
        }

        FinancialMonitoringService::request_rejection($item->get_id());
        $this->send_email($request);

        if (!FinancialAuthorizationsService::check_authorizations()->write() && FinancialAuthorizationsService::check_authorizations()->contribution()) ContributionService::generate_cache();

        FinancialRequestService::clear_cache();
        HooksService::execute_hook_action('delete', self::$module_id, $item->get_properties());

        AppContext::get_response()->redirect(
          ($request->get_url_referrer() && !TextHelper::strstr($request->get_url_referrer(), FinancialUrlBuilder::home()->rel()) ? $request->get_url_referrer() : FinancialUrlBuilder::display_pending_items()),
          StringVars::replace_vars($this->lang['financial.message.success.reject'], array('request_type' => $item->get_request_type())));
    }

    private function send_email(HTTPRequestCustom $request)
    {
        $id = $request->get_getint('id', 0);
        $item = $this->get_item($request);
        $club = LamclubsService::get_item($item->get_lamclubs_id());

        $item_message = '';

        //msg content
        $item_message = StringVars::replace_vars($this->lang['financial.rejected.mail.msg'], array(
            'club_sender_name'   => $item->get_sender_name(),
            'club_sender_email'  => $item->get_sender_email(),
            'activity'           => $item->get_request_type(),
            'club_activity_date' => $item->get_event_date()->format(Date::FORMAT_DAY_MONTH_YEAR),
            'club_ffam_number'   => $club->get_ffam_nb(),
            'club_name'          => $club->get_name(),
            'signature'          => $this->lang['financial.mail.signature']
        ));

        $item_email = new Mail();
        $item_email->set_sender(MailServiceConfig::load()->get_default_mail_sender(), $this->lang['financial.module.title']);
        $item_email->set_reply_to(MailServiceConfig::load()->get_default_mail_sender(), $this->lang['financial.module.title']);
        $item_email->set_subject($this->lang['financial.module.title'] . ' - ' . $club->get_name() . ' - ' . $item->get_request_type());
        $item_email->set_content(TextHelper::html_entity_decode($item_message));

        $item_email->add_recipient($item->get_sender_email());
        $send_email = AppContext::get_mail_service();

        return $send_email->try_to_send($item_email);
    }

    private function get_item(HTTPRequestCustom $request)
    {
        $id = $request->get_getint('id', 0);
        if (!empty($id))
        {
            try
                {
                    return FinancialRequestService::get_item($id);
                }
            catch (RowNotFoundException $e)
                {
                    $error_controller = PHPBoostErrors::unexisting_page();
                    DispatchManager::redirect($error_controller);
                }
        }
    }
}
?>