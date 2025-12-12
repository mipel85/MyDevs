<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2025 01 29
 * @since       PHPBoost 6.0 - 2020 01 18
 */

class AdminFinancialConfigController extends DefaultAdminModuleController
{
    private $reset_form;
    private $reset_button;

    protected function get_template_string_content()
    {
        return '# INCLUDE MESSAGE_HELPER # # INCLUDE CONTENT # # INCLUDE RESET #';
    }

    public function execute(HTTPRequestCustom $request)
    {
        $this->build_form();
        $this->build_reset_form();

        if ($this->submit_button->has_been_submited() && $this->form->validate())
        {
            $this->save();
        }

        if ($this->reset_button->has_been_submited() && $this->reset_form->validate())
        {
            FinancialMonitoringService::change_fiscal_year($this->reset_form->get_value('reset_date'));
        }

        $this->view->put_all(array(
            'CONTENT' => $this->form->display(),
            'RESET'   => $this->reset_form->display(),
        ));

        return new DefaultAdminDisplayResponse($this->view);
    }

    private function build_form()
    {
        $form = new HTMLForm(__CLASS__);

        $fieldset = new FormFieldsetHTML('configuration', StringVars::replace_vars($this->lang['form.module.title'], array('module_name' => self::get_module()->get_configuration()->get_name())));
        $form->add_fieldset($fieldset);

        $fieldset->add_field(new FormFieldCheckbox('winter_break', $this->lang['financial.winter.break'], $this->config->get_winter_break(),
            array('class' => 'custom-checkbox')
        ));

        $fieldset_authorizations = new FormFieldsetHTML('authorizations_fieldset', $this->lang['form.authorizations']);
        $form->add_fieldset($fieldset_authorizations);

        $auth_settings = new AuthorizationsSettings(array(
            new VisitorDisabledActionAuthorization($this->lang['form.authorizations.read'], FinancialAuthorizationsService::READ_AUTHORIZATIONS),
            new VisitorDisabledActionAuthorization($this->lang['form.authorizations.write'], FinancialAuthorizationsService::WRITE_AUTHORIZATIONS),
            new VisitorDisabledActionAuthorization($this->lang['form.authorizations.contribution'], FinancialAuthorizationsService::CONTRIBUTION_AUTHORIZATIONS),
            new MemberDisabledActionAuthorization($this->lang['form.authorizations.moderation'], FinancialAuthorizationsService::MODERATION_AUTHORIZATIONS)
        ));
        $auth_setter = new FormFieldAuthorizationsSetter('authorizations', $auth_settings);
        $auth_settings->build_from_auth_array($this->config->get_authorizations());
        $fieldset_authorizations->add_field($auth_setter);

        $this->submit_button = new FormButtonDefaultSubmit();
        $form->add_button($this->submit_button);
        $form->add_button(new FormButtonReset());

        $this->form = $form;
    }

    private function build_reset_form()
    {
        $reset_form = new HTMLForm(__CLASS__ . '_reset');
        $reset_form->set_css_class('bgc notice');

        $fieldset = new FormFieldsetHTML('reset_configuration', $this->lang['financial.reset']);
        $fieldset->set_css_class('txt-main');
        $fieldset->set_description($this->lang['financial.reset.clue']);
        $reset_form->add_fieldset($fieldset);

        $fieldset->add_field(new FormFieldTextEditor('reset_date', $this->lang['financial.reset.date'], '',
            array(
                    'required'    => true,
                    'description' => $this->lang['financial.reset.date.clue'],
                    'pattern'     => '[0-9]{4}'
            )
        ));

        $this->reset_button = new FormButtonDefaultSubmit($this->lang['financial.reset.button.name']);
        $this->reset_button->set_css_class('bgc-full warning');
        $reset_form->add_button($this->reset_button);

        $this->reset_form = $reset_form;
    }

    private function save()
    {
        $this->config->set_winter_break($this->form->get_value('winter_break'));
        $this->config->set_authorizations($this->form->get_value('authorizations')->build_auth_array());

        FinancialConfig::save();
        FinancialRequestService::clear_cache();

        HooksService::execute_hook_action('edit_config', self::$module_id, array('title' => StringVars::replace_vars($this->lang['form.module.title'], array('module_name' => self::get_module_configuration()->get_name())), 'url' => ModulesUrlBuilder::configuration()->rel()));
    }
}
?>
