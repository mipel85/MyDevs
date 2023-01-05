<?php
/**
 * @copyright   &copy; 2005-2022 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Julien BRISWALTER <j1.seth@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2021 12 11
 * @since       PHPBoost 3.0 - 2012 11 20
 * @contributor Arnaud GENET <elenwii@phpboost.com>
 * @contributor Mipel <mipel@phpboost.com>
 * @contributor Sebastien LARTIGUE <babsolune@phpboost.com>
 * @contributor xela <xela@phpboost.com>
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

        $fieldset = new FormFieldsetHTML('configuration', StringVars::replace_vars($this->lang['form.module.title'], array('module_name' => self::get_module()->get_configuration()->get_name())));
        $form->add_fieldset($fieldset);

        $fieldset->add_field(new FormFieldMailEditor('recipient_mail_1', $this->lang['lam.recipient.mail_1'], $this->config->get_recipient_mail_1(), array('required' => true, 'class' => 'top-field')
        ));
        $fieldset->add_field(new FormFieldMailEditor('recipient_mail_2', $this->lang['lam.recipient.mail_2'], $this->config->get_recipient_mail_2(), array('class' => 'top-field')
        ));
        $fieldset->add_field(new FormFieldMailEditor('recipient_mail_3', $this->lang['lam.recipient.mail_3'], $this->config->get_recipient_mail_3(), array('class' => 'top-field')
        ));

        $fieldset->add_field(new FormFieldSpacer('display', ''));

//        $fieldset->add_field(new FormFieldRichTextEditor('default_content', $this->lang['form.item.default.content'], $this->config->get_default_content(),
//			array('rows' => 8, 'cols' => 47)
//		));

//        $fieldset = new FormFieldsetHTML('authorizations_fieldset', $this->lang['form.authorizations'], array('description' => $this->lang['form.authorizations.clue'])
//        );
//        $form->add_fieldset($fieldset);
//
//        $auth_settings = new AuthorizationsSettings(RootCategory::get_authorizations_settings());
//        $auth_settings->build_from_auth_array($this->config->get_authorizations());
//        $fieldset->add_field(new FormFieldAuthorizationsSetter('authorizations', $auth_settings));

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

//        $this->config->set_default_content($this->form->get_value('default_content'));
//        $this->config->set_authorizations($this->form->get_value('authorizations')->build_auth_array());

        LamConfig::save();

        HooksService::execute_hook_action('edit_config', self::$module_id, array('title' => StringVars::replace_vars($this->lang['form.module.title'], array('module_name' => self::get_module_configuration()->get_name())), 'url' => ModulesUrlBuilder::configuration()->rel()));
    }
}
?>
