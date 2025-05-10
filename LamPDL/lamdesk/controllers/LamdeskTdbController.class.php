<?php
/**
 * @copyright   &copy; 2005-2024 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      mipel <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 22
 * @since       PHPBoost 6.0 - 2024 12 22
 */
class LamdeskTdbController extends DefaultModuleController
{
    protected function get_template_to_use()
    {
        return new FileTemplate('lamdesk/LamdeskTdbController.tpl');
    }

    public function execute(HTTPRequestCustom $request)
    {

        $this->build_view($request);

        return $this->generate_response();
    }

    public function build_view(HTTPRequestCustom $request)
    {
        $this->view->put('MENU', LamdeskMenu::get_menu());

        /* clubs de la Ligue source FFAM */
        $clubs_ffam = LamdeskService::get_count_clubs_ffam();
        $this->view->assign_block_vars('tdb_ffam', array(
            'FFAM_TOTAL' => $clubs_ffam[0],
            'FFAM_44'    => $clubs_ffam[1],
            'FFAM_49'    => $clubs_ffam[2],
            'FFAM_53'    => $clubs_ffam[3],
            'FFAM_72'    => $clubs_ffam[4],
            'FFAM_85'    => $clubs_ffam[5],
        ));

        /* clubs inscrits sur le site */
        $clubs_site = LamdeskService::get_count_clubs_site();
        $this->view->assign_block_vars('tdb_site', array(
            'SITE_TOTAL' => $clubs_site[0],
            'SITE_44'    => $clubs_site[1],
            'SITE_49'    => $clubs_site[2],
            'SITE_53'    => $clubs_site[3],
            'SITE_72'    => $clubs_site[4],
            'SITE_85'    => $clubs_site[5],
        ));

        /* clubs ayant inscrit des activités */
        
        
        
        
        
        
        
        /* clubs ayant effectué des demandes financières */
        $requests = LamdeskService::get_count_clubs_requests();
        $this->view->assign_block_vars('tdb_request', array(
            'REQUEST_TOTAL' => $requests[0]['request_count'],
            'REQUEST_44'    => $requests[1]['request_count'],
            'REQUEST_49'    => $requests[2]['request_count'],
            'REQUEST_53'    => $requests[3]['request_count'],
            'REQUEST_72'    => $requests[4]['request_count'],
            'REQUEST_85'    => $requests[5]['request_count'],
        ));

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
