<?php
/**
 * @copyright   &copy; 2005-2024 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2025 01 29
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

        while ($row = $result->fetch())
        {
            $event_date = Date::to_format($row['event_date'], Date::FORMAT_DAY_MONTH_YEAR);
            $lang = LangLoader::get_module_langs('financial');
            $club = LamclubsService::get_item($row['lamclubs_id']);

            $item_message = '';

            //msg content
            $item_message = StringVars::replace_vars($lang['financial.mail.finished.event'], array(
                'event_title' => $row['request_type'],
                'club_name'   => $club->get_name()
            ));

            if ($event_date == $finished_date)
            {
                $item_email = new Mail();
                $item_email->set_sender(MailServiceConfig::load()->get_default_mail_sender(), $lang['financial.module.title']);
                $item_email->set_reply_to(MailServiceConfig::load()->get_default_mail_sender());
                $item_email->set_subject($lang['financial.module.title'] . ' - ' . $club->get_name() . ' - ' . $row['request_type']);
                $item_email->set_content(TextHelper::html_entity_decode($item_message));

                /* envoi mail de nouvelle contribution aux destinataires hors délégués départementaux */
                $default_liste_email = LamclubsService::get_recipient_email(0);

                foreach ($default_liste_email as $default_recipient)
                {
                    $item_email->add_recipient($default_recipient['recipient_email']);
                }

                /* envoi mail de nouvelle contribution aux délégués départementaux et suppléants si adresse mail existante */
                $delegates_liste_email = LamclubsService::get_recipient_email($infos[1] ?? ''); /* teste si adresse mail non vide */

                foreach ($delegates_liste_email as $delegates_recipient)
                {
                    $item_email->add_recipient($delegates_recipient['recipient_email']);
                }

                $send_email = AppContext::get_mail_service();

                return $send_email->try_to_send($item_email);
            }
        }
    }
}