<?php
/*
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2023 03 03
 * @since       PHPBoost 6.0 - 2022 12 20
 */
class AdminLamConfigController extends DefaultAdminModuleController
{

    public function execute(HTTPRequestCustom $request)
    {
        $this->build_form();

        if ($this->submit_button->has_been_submited() && $this->form->validate()){
            $this->save();
            $this->view->put('MESSAGE_HELPER', MessageHelper::display($this->lang['warning.success.config'], MessageHelper::SUCCESS, 5));
        }

        $this->view->put('CONTENT', $this->form->display());
        return new DefaultAdminDisplayResponse($this->view);
    }

    private function init()
    {
        
    }

    private function build_form()
    {
        $form = new HTMLForm(__CLASS__);

// configuration fieldset
        $fieldset = new FormFieldsetHTML('configuration', $this->lang['lam.email.configuration']);
        $form->add_fieldset($fieldset);
        $fieldset->add_field(new FormFieldMailEditor('recipient_mail_1', $this->lang['lam.recipient.mail_1'], $this->config->get_recipient_mail_1(), array(
            'description' => StringVars::replace_vars($this->lang['lam.email.configuration.default'], array('default_mail' => LamConfig::load()->get_recipient_mail_1())),
            'required'    => true,
            'class'       => 'top-field third-field'
            )
        ));
        $fieldset->add_field(new FormFieldMailEditor('recipient_mail_2', $this->lang['lam.recipient.mail_2'], $this->config->get_recipient_mail_2(), array(
            'description' => $this->lang['lam.email.configuration.optional'],
            'class'       => 'top-field third-field'
            )
        ));
        $fieldset->add_field(new FormFieldMailEditor('recipient_mail_3', $this->lang['lam.recipient.mail_3'], $this->config->get_recipient_mail_3(), array(
            'description' => $this->lang['lam.email.configuration.optional'],
            'class'       => 'top-field third-field'
            )
        ));

// financial jpo fieldset
        $financial_jpo_fieldset = new FormFieldsetHTML('financial_jpo', $this->lang['lam.financial.jpo.part']);
        $form->add_fieldset($financial_jpo_fieldset);

        $financial_jpo_fieldset->add_field($jpo_total_amount = new FormFieldDecimalNumberEditor('jpo_total_amount', $this->lang['lam.jpo.total.amount'], (int)$this->config->get_jpo_total_amount(), array(
            'description' => $this->lang['lam.financial.maximum'],
            'required'    => true,
            'min'         => 1, 'max'         => 10000
            )
        ));
        $financial_jpo_fieldset->add_field($jpo_day_amount = new FormFieldDecimalNumberEditor('jpo_day_amount', $this->lang['lam.jpo.day.amount'], (int)$this->config->get_jpo_day_amount(), array(
            'description' => $this->lang['lam.financial.maximum'],
            'required'    => true,
            'min'         => 1, 'max'         => 10000
            )
        ));
        
        $form->add_constraint(new FormConstraintFieldsDifferenceInferior($jpo_total_amount, $jpo_day_amount));

// financial exam fieldset
        $financial_exam_fieldset = new FormFieldsetHTML('financial_qpdd', $this->lang['lam.financial.exam.part']);
        $form->add_fieldset($financial_exam_fieldset);
         
        $financial_exam_fieldset->add_field($exam_total_amount = new FormFieldDecimalNumberEditor('exam_total_amount', $this->lang['lam.exam.total.amount'], (int)$this->config->get_exam_total_amount(), array(
            'description' => $this->lang['lam.financial.maximum'],
            'required'    => true,
            'min'         => 1, 'max'         => 10000,
            )
        ));
        $financial_exam_fieldset->add_field($exam_day_amount = new FormFieldDecimalNumberEditor('exam_day_amount', $this->lang['lam.exam.day.amount'], (int)$this->config->get_exam_day_amount(), array(
            'description' => $this->lang['lam.financial.maximum'],
            'required'    => true,
            'min'         => 1, 'max'         => 10000,
            )
        ));

        $form->add_constraint(new FormConstraintFieldsDifferenceInferior($exam_total_amount, $exam_day_amount));

// validation
        $this->submit_button = new FormButtonDefaultSubmit();
        $form->add_button($this->submit_button);
        $form->add_button(new FormButtonReset());

        $this->form = $form;
    }

    private function save()
    {

        $this->config->set_recipient_mail_1($this->form->get_value('recipient_mail_1'));
        $this->config->set_recipient_mail_2($this->form->get_value('recipient_mail_2'));
        $this->config->set_recipient_mail_3($this->form->get_value('recipient_mail_3'));

        $this->config->set_jpo_total_amount((int)$this->form->get_value('jpo_total_amount'));
        $this->config->set_jpo_day_amount((int)$this->form->get_value('jpo_day_amount'));

        $this->config->set_exam_total_amount((int)$this->form->get_value('exam_total_amount'));
        $this->config->set_exam_day_amount((int)$this->form->get_value('exam_day_amount'));

        LamConfig::save();

        HooksService::execute_hook_action('edit_config', self::$module_id, array('title' => StringVars::replace_vars($this->lang['form.module.title'], array('module_name' => self::get_module_configuration()->get_name())), 'url' => ModulesUrlBuilder::configuration()->rel()));
    }
}
?>
