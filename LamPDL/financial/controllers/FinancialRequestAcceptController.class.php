<?php
/*
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 02 09
 * @since       PHPBoost 6.0 - 2024 02 09
 */

class FinancialRequestAcceptController extends DefaultModuleController
{
    /**
     * executed script when clicking on the "pay" button :
     *      - archives the item
     *      - updates the budget monitoring
     *      - sends email to the applicant
     *
     * @param  HTTPRequestCustom $request
     * @return void
     */
    public function execute(HTTPRequestCustom $request)
	{
		$item = $this->get_item($request);

		if (!$item->is_authorized_to_delete() || AppContext::get_current_user()->is_readonly())
		{
			$error_controller = PHPBoostErrors::user_not_authorized();
			DispatchManager::redirect($error_controller);
		}
        $budget = FinancialBudgetService::get_budget($item->get_budget_id());

        if ($request->get_value('amount_paid', '') !== '')
        {
            if(($budget->get_annual_amount() - $request->get_value('amount_paid', '')) >= 0)
            {
                FinancialMonitoringService::request_payment($item->get_id(), $request->get_value('amount_paid', ''));
                $this->send_email($request);
                AppContext::get_response()->redirect(
                    ($request->get_url_referrer() && !TextHelper::strstr($request->get_url_referrer(), FinancialUrlBuilder::home()->rel()) ? $request->get_url_referrer() : FinancialUrlBuilder::display_pending_items()), 
                    StringVars::replace_vars($this->lang['financial.message.success.accept'], array('title' => $item->get_title())));
            }
            else
                AppContext::get_response()->redirect(
                    ($request->get_url_referrer() && !TextHelper::strstr($request->get_url_referrer(), FinancialUrlBuilder::home()->rel()) ? $request->get_url_referrer() : FinancialUrlBuilder::display_pending_items()), 
                    StringVars::replace_vars($this->lang['financial.message.error.accept'], array('title' => $item->get_title())), MessageHelper::ERROR);
        }
        else
            AppContext::get_response()->redirect(
                ($request->get_url_referrer() && !TextHelper::strstr($request->get_url_referrer(), FinancialUrlBuilder::home()->rel()) ? $request->get_url_referrer() : FinancialUrlBuilder::display_pending_items()), 
                StringVars::replace_vars($this->lang['financial.message.empty.accept'], array('title' => $item->get_title())), MessageHelper::ERROR);

		FinancialRequestService::clear_cache();
	}

    private function send_email(HTTPRequestCustom $request)
    {
		$id = $request->get_getint('id', 0);
        $item = $this->get_item($request);
        $club = LamclubsService::get_item($item->get_lamclubs_id());

        $item_message = '';

        //msg content
        $item_message = StringVars::replace_vars($this->lang['financial.paid.mail.msg'], array(
            'club_sender_name'   => $item->get_sender_name(),
            'club_sender_email'  => $item->get_sender_email(),
            'club_name'          => $club->get_name(),
            'club_ffam_number'   => $club->get_ffam_nb(),
            'activity'           => $item->get_title(),
            'club_activity_date' => $item->get_event_date()->format(Date::FORMAT_DAY_MONTH_YEAR),
        ));

        $item_email = new Mail();
        $item_email->set_sender(FinancialConfig::load()->get_recipient_mail_1(), $this->lang['financial.module.title']);
        $item_email->set_reply_to(FinancialConfig::load()->get_recipient_mail_1(), $this->lang['financial.module.title']);
        $item_email->set_subject($this->lang['financial.module.title'] . ' - ' . $club->get_name() . ' - ' . $item->get_title());
        $item_email->set_content(TextHelper::html_entity_decode($item_message));

        $item_email->add_recipient($item->get_sender_email());
        $send_email = AppContext::get_mail_service();

        return $send_email->try_to_send($item_email);
    }

	/**
	 * get_item
	 *
	 * @param  HTTPRequestCustom $request id of the item from the _get request
	 * @return FinancialRequestItem $item
	 */
	private function get_item(HTTPRequestCustom $request)
	{
		$id = $request->get_getint('id', 0);
		if (!empty($id))
		{
			try {
				return FinancialRequestService::get_item($id);
			} catch (RowNotFoundException $e) {
				$error_controller = PHPBoostErrors::unexisting_page();
				DispatchManager::redirect($error_controller);
			}
		}
	}
}
?>