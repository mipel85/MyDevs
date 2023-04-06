<?php
/*
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2023 03 03
 * @since       PHPBoost 6.0 - 2022 12 20
 */
class LamArchivedRequestsController extends DefaultModuleController
{

    protected function get_template_to_use()
    {
        return new FileTemplate('Lam/LamArchivedRequestsController.tpl');
    }

    public function execute(HTTPRequestCustom $request)
    {
        $this->check_authorizations();
        $this->build_archived_requests();

        return $this->generate_response();
    }

    private function check_authorizations()
    {
        if (!LamAuthorizationsService::check_authorizations()->manager()){
            $controller = PHPBoostErrors::user_not_authorized();
            DispatchManager::redirect($controller);
        }
    }

    private function build_archived_requests()
    {
        $req = LamService::get_requests('1');

        $this->view->put('C_ITEM', !empty($req));

        foreach ($req as $value)
        {
            $this->view->assign_block_vars('archived_requests', array(
                'ACTIVITY_TYPE'      => $value['activity_type'] == 'jpo' ? $this->lang['lam.jpo'] : $this->lang['lam.exam'], 'align-left',
                'CLUB_NAME'          => $value['club_name'],
                'CLUB_FFAM_NUMBER'   => $value['club_ffam_number'],
                'CLUB_ACTIVITY_DATE' => Date::to_format($value['club_activity_date'], Date::FORMAT_DAY_MONTH_YEAR),
                'CLUB_REQUEST_DATE'  => Date::to_format($value['club_request_date'], Date::FORMAT_DAY_MONTH_YEAR),
                'ARCHIVED_DATE'      => Date::to_format($value['archived_date'], Date::FORMAT_DAY_MONTH_YEAR),
                'AMOUNT_PAID'        => $value['amount_paid'],
            ));
        }
    }

    private function generate_response($page = 1)
    {
        $response = new SiteDisplayResponse($this->view);
        $graphical_environment = $response->get_graphical_environment();
        $graphical_environment->set_page_title($this->lang['lam.archived.requests'], $this->lang['lam.archived.requests'], $page);
        $graphical_environment->get_seo_meta_data()->set_canonical_url(LamUrlBuilder::archived_requests());

        $breadcrumb = $graphical_environment->get_breadcrumb();
        $breadcrumb->add($this->lang['lam.form'], LamUrlBuilder::home());
        $breadcrumb->add($this->lang['lam.archived.requests'], LamUrlBuilder::archived_requests());

        return $response;
    }
}
?>
