<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2023 03 03
 * @since       PHPBoost 6.0 - 2022 12 20
 */
class LamToolsEmailController
{

    public static function send_email($properties)
    {
        $item_message = '';
        $item_subject = 'Alerte nouvel inscrit !';
        $item_sender_name = 'LamPdl';
        $item_sender_email = 'mipel85@gmail.com';

        $item_message = 'Alerte nouvel inscrit !<br><br>'
            . 'Utilisateur à valider : <a href="' . $_SERVER['HTTP_ORIGIN'] . $properties['url'] . '"><b>' . $properties['display_name'] . '</b></a>';

        $item_email = new Mail();
        $item_email->set_sender(MailServiceConfig::load()->get_default_mail_sender(), 'envoi des alertes');
        $item_email->set_reply_to($item_sender_email, $item_sender_name);
        $item_email->set_subject($item_subject);
        $item_email->set_content(TextHelper::html_entity_decode($item_message));

        $item_email->add_recipient('mipel@aeromodelisme-paysdeloire.fr');
        $send_email = AppContext::get_mail_service();

        return $send_email->try_to_send($item_email);
    }
}
?>

