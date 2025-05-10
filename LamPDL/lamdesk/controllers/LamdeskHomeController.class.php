<?php
/**
 * @copyright   &copy; 2005-2024 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      mipel <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 22
 * @since       PHPBoost 6.0 - 2024 12 22
 */

class LamdeskHomeController extends DefaultModuleController
{
    protected function get_template_to_use()
    {
        return new FileTemplate('lamdesk/LamdeskHomeController.tpl');
    }

    public function execute(HTTPRequestCustom $request)
    {
        $this->build_view($request);

        return $this->generate_response();
    }

    public function build_view(HTTPRequestCustom $request)
    {
        $this->view->put('MENU', LamdeskMenu::get_menu());
        return $this->view;
    }

    private function generate_response()
    {
        $response = new SiteDisplayResponse($this->view);
        $graphical_environment = $response->get_graphical_environment();
        $graphical_environment->set_page_title($this->lang['lamdesk.tdb'], $this->lang['common.home']);
        $graphical_environment->get_seo_meta_data()->set_canonical_url(LamdeskUrlBuilder::home());

        $breadcrumb = $graphical_environment->get_breadcrumb();
        $breadcrumb->add($this->lang['lamdesk.tdb'], LamdeskUrlBuilder::home());

        return $response;
    }

    public static function get_view()
    {
        $object = new self('lamdesk');
	$object->check_authorizations();
        $object->build_view(AppContext::get_request());
        return $object->view;
    }
}
?>
