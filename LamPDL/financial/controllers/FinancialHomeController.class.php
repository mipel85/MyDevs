<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 18
 * @since       PHPBoost 6.0 - 2024 01 18
 */
class FinancialHomeController extends DefaultModuleController
{

    protected function get_template_to_use()
    {
        return new FileTemplate('financial/FinancialHomeController.tpl');
    }

    public function execute(HTTPRequestCustom $request)
    {
        $this->check_authorizations();
        $this->build_view();
        return $this->generate_response();
    }

    private function build_view()
    {
        $this->view->put_all(array(
            'C_CLUBS' => ModulesManager::is_module_installed('LamClubs') && ModulesManager::is_module_activated('LamClubs'),
            'TITLE'   => $this->lang['financial.home'],
        ));
    }

    private function check_authorizations()
    {
        if (!FinancialAuthorizationsService::check_authorizations()->officer()){
            $controller = PHPBoostErrors::user_not_authorized();
            DispatchManager::redirect($controller);
        }
    }

    private function generate_response()
    {
        $response = new SiteDisplayResponse($this->view);
        $response->get_graphical_environment()->set_page_title($this->lang['financial.home']);
        $graphical_environment = $response->get_graphical_environment();
        $graphical_environment->set_page_title($this->lang['financial.home']);
        $graphical_environment->get_seo_meta_data()->set_canonical_url(FinancialUrlBuilder::home());

        $breadcrumb = $graphical_environment->get_breadcrumb();
        $breadcrumb->add($this->lang['financial.home'], FinancialUrlBuilder::home());

        return $response;
    }

    public static function get_view()
    {
        $object = new self('Financial');
        $object->build_view(AppContext::get_request());
        return $object->view;
    }

}
?>

