<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2023 03 03
 * @since       PHPBoost 6.0 - 2022 12 20
 */
class PlanningHomeController extends DefaultModuleController
{

    protected function get_template_to_use()
    {
        return new FileTemplate('LamTools/FinancialHomeController.tpl');
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
            'TITLE'          => $this->lang['lamfinancial.form'],
            'C_CHECK_CONFIG' => FinancialService::check_config()
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
        $response->get_graphical_environment()->set_page_title($this->lang['lamfinancial.form']);
        $graphical_environment = $response->get_graphical_environment();
        $graphical_environment->set_page_title($this->lang['lamfinancial.form']);
        $graphical_environment->get_seo_meta_data()->set_canonical_url(ToolsUrlBuilder::home());

        $breadcrumb = $graphical_environment->get_breadcrumb();
        $breadcrumb->add($this->lang['lamfinancial.form'], ToolsUrlBuilder::home());

        return $response;
    }

    public static function get_view()
    {
        $object = new self('LamTools');
        $object->build_view(AppContext::get_request());
        return $object->view;
    }

}
?>

