<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 11
 * @since       PHPBoost 6.0 - 2020 01 18
 */

class AdminPlanningConfigController extends DefaultAdminModuleController
{
    public function execute(HTTPRequestCustom $request)
    {
        $this->build_form();

        if ($this->submit_button->has_been_submited() && $this->form->validate())
        {
            $this->save();
        }

        $this->view->put('CONTENT', $this->form->display());

        return new DefaultAdminDisplayResponse($this->view);
    }

    private function build_form()
    {
        $form = new HTMLForm(__CLASS__);

        $fieldset = new FormFieldsetHTML('configuration', StringVars::replace_vars($this->lang['form.module.title'], array('module_name' => self::get_module()->get_configuration()->get_name())));
        $form->add_fieldset($fieldset);

        $fieldset = new FormFieldsetHTML('authorizations_fieldset', $this->lang['form.authorizations'],
            array('description' => $this->lang['form.authorizations.clue'])
        );
        $form->add_fieldset($fieldset);

        $auth_settings = new AuthorizationsSettings(RootCategory::get_authorizations_settings());
        $auth_settings->build_from_auth_array($this->config->get_authorizations());
        $fieldset->add_field(new FormFieldAuthorizationsSetter('authorizations', $auth_settings));

        $this->submit_button = new FormButtonDefaultSubmit();
        $form->add_button($this->submit_button);
        $form->add_button(new FormButtonReset());

        $this->form = $form;
    }

    private function save()
    {
        $this->config->set_authorizations($this->form->get_value('authorizations')->build_auth_array());

        PlanningConfig::save();
        CategoriesService::get_categories_manager()->regenerate_cache();

        HooksService::execute_hook_action('edit_config', self::$module_id, array('title' => StringVars::replace_vars($this->lang['form.module.title'], array('module_name' => self::get_module_configuration()->get_name())), 'url' => ModulesUrlBuilder::configuration()->rel()));
    }
}
?>
