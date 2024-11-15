<?php
/*
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 08 14
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
        $amount_paid = $request->get_value('amount_paid', '');
        $amount_paid = floatval(str_replace('_', '.', $amount_paid)); /* underscore passé dans url transformé en point */

		if (!$item->is_authorized_to_delete() || AppContext::get_current_user()->is_readonly())
		{
			$error_controller = PHPBoostErrors::user_not_authorized();
			DispatchManager::redirect($error_controller);
		}
        $budget = FinancialBudgetService::get_budget($item->get_budget_id());

        if ($request->get_value('amount_paid', '') !== '')
        {
            /* on teste si le montant saisi est conforme - 4 chiffres max et 2 décimales */ 
            if (strlen($request->get_value('amount_paid', '')) > 7)
            {
              AppContext::get_response()->redirect(
                    ($request->get_url_referrer() && !TextHelper::strstr($request->get_url_referrer(), FinancialUrlBuilder::home()->rel()) ? $request->get_url_referrer() : FinancialUrlBuilder::display_pending_items()), 
                    $this->lang['financial.input.number.length'], MessageHelper::ERROR);  
            }

            /* on teste si le montant à payer est bien inférieur au montant maximum */ 
            if ($amount_paid > $budget->get_max_amount()) 
          {
              AppContext::get_response()->redirect(
                    ($request->get_url_referrer() && !TextHelper::strstr($request->get_url_referrer(), FinancialUrlBuilder::home()->rel()) ? $request->get_url_referrer() : FinancialUrlBuilder::display_pending_items()), 
                    StringVars::replace_vars($this->lang['financial.message.error.maximum.budget'], array('request_type' => $item->get_request_type(), 'max_budget' => $budget->get_max_amount())), MessageHelper::ERROR);
          }
          else
          /* on teste si le budget restant est suffisant */ 
            if ($amount_paid > $budget->get_real_amount()) 
          {
              AppContext::get_response()->redirect(
                    ($request->get_url_referrer() && !TextHelper::strstr($request->get_url_referrer(), FinancialUrlBuilder::home()->rel()) ? $request->get_url_referrer() : FinancialUrlBuilder::display_pending_items()), 
                    StringVars::replace_vars($this->lang['financial.message.error.remaining.budget'], array('request_type' => $item->get_request_type(), 'remaining_budget' => $budget->get_real_amount())), MessageHelper::ERROR);
          }
           else   
          /* on teste si le budget annuel n'est pas dépassé */ 
            if(($budget->get_annual_amount() - $amount_paid) >= 0 )
            {
                FinancialMonitoringService::request_payment($item->get_id(), $amount_paid, '');
                $this->send_email($request);
                AppContext::get_response()->redirect(
                    ($request->get_url_referrer() && !TextHelper::strstr($request->get_url_referrer(), FinancialUrlBuilder::home()->rel()) ? $request->get_url_referrer() : FinancialUrlBuilder::display_pending_items()), 
                    StringVars::replace_vars($this->lang['financial.message.success.accept'], array('request_type' => $item->get_request_type())));
            }
        }
        else
            AppContext::get_response()->redirect(
                ($request->get_url_referrer() && !TextHelper::strstr($request->get_url_referrer(), FinancialUrlBuilder::home()->rel()) ? $request->get_url_referrer() : FinancialUrlBuilder::display_pending_items()), 
                StringVars::replace_vars($this->lang['financial.message.empty.accept'], array('request_type' => $item->get_request_type())), MessageHelper::ERROR);
    
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
            'activity'           => $item->get_request_type(),
            'club_activity_date' => $item->get_event_date()->format(Date::FORMAT_DAY_MONTH_YEAR),
        ));

        $item_email = new Mail();
        $item_email->set_sender(FinancialConfig::load()->get_recipient_mail_1(), $this->lang['financial.module.title']);
        $item_email->set_reply_to(FinancialConfig::load()->get_recipient_mail_1(), $this->lang['financial.module.title']);
        $item_email->set_subject($this->lang['financial.module.title'] . ' - ' . $club->get_name() . ' - ' . $item->get_request_type());
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