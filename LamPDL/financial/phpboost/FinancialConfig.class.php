<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class FinancialConfig extends AbstractConfigData
{
    const RECIPIENT_MAIL_1 = 'recipient_mail_1';
    const RECIPIENT_MAIL_2 = 'recipient_mail_2';
    const RECIPIENT_MAIL_3 = 'recipient_mail_3';
    const RESET_DATE       = 'reset_date';
    const WINTER_BREAK     = 'winter_break';
	const AUTHORIZATIONS   = 'authorizations';

    public function get_recipient_mail_1()
    {
        return $this->get_property(self::RECIPIENT_MAIL_1);
    }

    public function set_recipient_mail_1($recipient_mail_1)
    {
        $this->set_property(self::RECIPIENT_MAIL_1, $recipient_mail_1);
    }

    public function get_recipient_mail_2()
    {
        return $this->get_property(self::RECIPIENT_MAIL_2);
    }

    public function set_recipient_mail_2($recipient_mail_2)
    {
        $this->set_property(self::RECIPIENT_MAIL_2, $recipient_mail_2);
    }

    public function get_recipient_mail_3()
    {
        return $this->get_property(self::RECIPIENT_MAIL_3);
    }

    public function set_recipient_mail_3($recipient_mail_3)
    {
        $this->set_property(self::RECIPIENT_MAIL_3, $recipient_mail_3);
    }

    public function get_winter_break()
    {
        return $this->get_property(self::WINTER_BREAK);
    }

    public function set_winter_break($winter_break)
    {
        $this->set_property(self::WINTER_BREAK, $winter_break);
    }

    public function get_reset_date()
    {
        return $this->get_property(self::RESET_DATE);
    }

    public function set_reset_date($reset_date)
    {
        $this->set_property(self::RESET_DATE, $reset_date);
    }

	/**
	 * @method Get authorizations
	 * @return array
	 */
	public function get_authorizations()
	{
		return $this->get_property(self::AUTHORIZATIONS);
	}

	/**
	 * @method Set authorizations
	 * @param array Array of authorizations
	 */
	public function set_authorizations(Array $authorizations)
	{
		$this->set_property(self::AUTHORIZATIONS, $authorizations);
	}

	/**
	 * @method Get default values.
	 */
	public function get_default_values()
	{
		return array(
            self::RECIPIENT_MAIL_1  => 'mipel@aeromodelisme-paysdeloire.fr',
            self::RECIPIENT_MAIL_2  => '',
            self::RECIPIENT_MAIL_3  => '',
            self::WINTER_BREAK      => false,
            self::RESET_DATE        => '',
			self::AUTHORIZATIONS => array('r-1' => 1, 'r0' => 5, 'r1' => 13)
		);
	}

	/**
	 * @method Load the financial configuration.
	 * @return FinancialConfig
	 */
	public static function load()
	{
		return ConfigManager::load(__CLASS__, 'financial', 'config');
	}

	/**
	 * @method Saves the financial configuration in the database. It becomes persistent.
	 */
	public static function save()
	{
		ConfigManager::save('financial', self::load(), 'config');
	}
}
?>
