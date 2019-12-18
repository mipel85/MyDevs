<?php
/**
 * @copyright   &copy; 2005-2020 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Kevin MASSY <reidlos@phpboost.com>
 * @version     PHPBoost 5.3 - last update: 2018 11 16
 * @since       PHPBoost 3.0 - 2011 10 07
 * @contributor Julien BRISWALTER <j1.seth@phpboost.com>
*/

class UserRegistrationService
{
	public static function send_email_confirmation($user_id, $email, $pseudo, $login, $password, $registration_pass, $admin_creation = false)
	{
		$lang = LangLoader::get('user-common');
		$user_accounts_config = UserAccountsConfig::load();
		$general_config = GeneralConfig::load();
		$site_name = $general_config->get_site_name();
		$subject = StringVars::replace_vars($lang['registration.subject-mail'], array('site_name' => $site_name));
		if ($admin_creation)
			$lost_password_link = StringVars::replace_vars($lang['registration.password'], array('password' => $password));
		else
			$lost_password_link = StringVars::replace_vars($lang['registration.lost-password-link'], array('lost_password_link' => UserUrlBuilder::forget_password()->absolute()));

		switch ($user_accounts_config->get_member_accounts_validation_method())
		{
			case UserAccountsConfig::AUTOMATIC_USER_ACCOUNTS_VALIDATION:
				$parameters = array(
					'pseudo' => $pseudo,
					'site_name' => $site_name,
					'host' => $general_config->get_complete_site_url(),
					'login' => $login,
					'lost_password_link' => $lost_password_link,
					'accounts_validation_explain' => $lang['registration.email.automatic-validation'],
					'signature' => MailServiceConfig::load()->get_mail_signature()
				);
				$content = StringVars::replace_vars($lang['registration.content-mail' . ($admin_creation ? '.admin' : '')], $parameters);
				AppContext::get_mail_service()->send_from_properties($email, $subject, $content);
				break;
			case UserAccountsConfig::MAIL_USER_ACCOUNTS_VALIDATION:
				$parameters = array(
					'pseudo' => $pseudo,
					'site_name' => $site_name,
					'host' => $general_config->get_complete_site_url(),
					'login' => $login,
					'lost_password_link' => $lost_password_link,
					'accounts_validation_explain' =>
				StringVars::replace_vars(
				$lang['registration.email.mail-validation'],
				array('validation_link' => UserUrlBuilder::confirm_registration($registration_pass)->absolute())
				),
					'signature' => MailServiceConfig::load()->get_mail_signature()
				);
				$content = StringVars::replace_vars($lang['registration.content-mail' . ($admin_creation ? '.admin' : '')], $parameters);
				AppContext::get_mail_service()->send_from_properties($email, $subject, $content);
				break;
			case UserAccountsConfig::ADMINISTRATOR_USER_ACCOUNTS_VALIDATION:

				$alert = new AdministratorAlert();
				$alert->set_entitled($lang['registration.pending-approval']);
				$alert->set_fixing_url(UserUrlBuilder::edit_profile($user_id)->relative());
				$alert->set_priority(AdministratorAlert::ADMIN_ALERT_MEDIUM_PRIORITY);
				$alert->set_id_in_module($user_id);
				$alert->set_type('member_account_to_approbate');
				AdministratorAlertService::save_alert($alert);

				$parameters = array(
					'pseudo' => $pseudo,
					'site_name' => $site_name,
					'host' => $general_config->get_complete_site_url(),
					'login' => $login,
					'lost_password_link' => $lost_password_link,
					'accounts_validation_explain' => $lang['registration.email.administrator-validation'],
					'signature' => MailServiceConfig::load()->get_mail_signature()
				);
				$content = StringVars::replace_vars($lang['registration.content-mail' . ($admin_creation ? '.admin' : '')], $parameters);
				AppContext::get_mail_service()->send_from_properties($email, $subject, $content);
				break;
		}
	}
}
?>
