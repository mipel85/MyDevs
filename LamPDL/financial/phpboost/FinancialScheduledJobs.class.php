<?php
/**
 * @copyright   &copy; 2005-2024 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 11
 * @since       PHPBoost 6.0 - 2024 05 04
*/

class FinancialScheduledJobs extends AbstractScheduledJobExtensionPoint
{
    public function on_changeday(Date $yesterday, Date $today)
    {
        $result = PersistenceContext::get_querier()->select(
            'SELECT financial.*
            FROM ' . FinancialSetup::$financial_request_table . ' financial
            WHERE financial.agreement = ' . FinancialRequestItem::PENDING . '
            OR financial.agreement = ' . FinancialRequestItem::ONGOING
        );

        $finished_date = $yesterday->format(Date::FORMAT_DAY_MONTH_YEAR);

        while ($row = $result->fetch()) {
            $event_date = Date::to_format($row['event_date'], Date::FORMAT_DAY_MONTH_YEAR);
            $lang = LangLoader::get_module_langs('financial');
            $club = LamclubsService::get_item($row['lamclubs_id']);

            $item_message = '';

            //msg content
            $item_message = StringVars::replace_vars($lang['financial.mail.finished.event'], array(
                'club_name'   => $club->get_name(),
                'event_title' => $row['request_type'],
                'event_date'  => $event_date
            ));

            if ($event_date == $finished_date) {
                $item_email = new Mail();
                $item_email->set_sender(FinancialConfig::load()->get_recipient_mail_1(), $lang['financial.module.title']);
                $item_email->set_reply_to(FinancialConfig::load()->get_recipient_mail_1());
                $item_email->set_subject($lang['financial.module.title'] . ' - ' . $club->get_name() . ' - ' . $row['request_type']);
                $item_email->set_content(TextHelper::html_entity_decode($item_message));

                $item_email->add_recipient(FinancialConfig::load()->get_recipient_mail_1());
                $item_email->add_recipient(!empty(FinancialConfig::load()->get_recipient_mail_2()) ? FinancialConfig::load()->get_recipient_mail_2() : '');
                $item_email->add_recipient(!empty(FinancialConfig::load()->get_recipient_mail_3()) ? FinancialConfig::load()->get_recipient_mail_3() : '');
                $send_email = AppContext::get_mail_service();

                return $send_email->try_to_send($item_email);
            }
        }
    }
}
