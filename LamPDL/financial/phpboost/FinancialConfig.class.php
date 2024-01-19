<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 18
 * @since       PHPBoost 6.0 - 2024 01 18
 */
class FinancialConfig extends AbstractConfigData
{
    const RECIPIENT_MAIL_1  = 'recipient_mail_1';
    const RECIPIENT_MAIL_2  = 'recipient_mail_2';
    const RECIPIENT_MAIL_3  = 'recipient_mail_3';
    const JPO_TOTAL_AMOUNT  = 'jpo_total_amount';
    const JPO_DAY_AMOUNT    = 'jpo_day_amount';
    const EXAM_TOTAL_AMOUNT = 'exam_total_amount';
    const EXAM_DAY_AMOUNT   = 'exam_day_amount';
    const AUTHORIZATIONS    = 'authorizations';

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

// financial  

    // jpo
    public function get_jpo_total_amount()
    {
        return $this->get_property(self::JPO_TOTAL_AMOUNT);
    }

    public function set_jpo_total_amount($jpo_total_amount)
    {
        $this->set_property(self::JPO_TOTAL_AMOUNT, $jpo_total_amount);
    }

    public function get_jpo_day_amount()
    {
        return $this->get_property(self::JPO_DAY_AMOUNT);
    }

    public function set_jpo_day_amount($jpo_day_amount)
    {
        $this->set_property(self::JPO_DAY_AMOUNT, $jpo_day_amount);
    }

    // exam
    public function get_exam_total_amount()
    {
        return $this->get_property(self::EXAM_TOTAL_AMOUNT);
    }

    public function set_exam_total_amount($exam_total_amount)
    {
        $this->set_property(self::EXAM_TOTAL_AMOUNT, $exam_total_amount);
    }

    public function get_exam_day_amount()
    {
        return $this->get_property(self::EXAM_DAY_AMOUNT);
    }

    public function set_exam_day_amount($exam_day_amount)
    {
        $this->set_property(self::EXAM_DAY_AMOUNT, $exam_day_amount);
    }

    public function get_authorizations()
    {
        return $this->get_property(self::AUTHORIZATIONS);
    }

    public function set_authorizations($authorizations)
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
            self::JPO_TOTAL_AMOUNT  => 1,
            self::JPO_DAY_AMOUNT    => 1,
            self::EXAM_TOTAL_AMOUNT => 1,
            self::EXAM_DAY_AMOUNT   => 1,
            self::AUTHORIZATIONS    => array('r-1' => 0, 'r0' => 0, 'r1' => 15),
        );
    }

    public static function load()
    {
        return ConfigManager::load(__CLASS__, 'financial', 'config');
    }

    /**
     * @method Saves financial configuration in the database. It becomes persistent.
     */
    public static function save()
    {
        ConfigManager::save('financial', self::load(), 'config');
    }
}
?>
