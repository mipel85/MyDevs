<?php
/*
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 18
 * @since       PHPBoost 6.0 - 2024 01 18
 */
class FinancialPendingRequestsController extends DefaultModuleController
{

    protected function get_template_to_use()
    {
        return new FileTemplate('financial/FinancialPendingRequestsController.tpl');
    }

    public function execute(HTTPRequestCustom $request)
    {
        $this->check_authorizations();
        $this->build_pending_requests();

        return $this->generate_response();
    }

    private function check_authorizations()
    {
        if (!FinancialAuthorizationsService::check_authorizations()->officer()){
            $controller = PHPBoostErrors::user_not_authorized();
            DispatchManager::redirect($controller);
        }
    }

    private function build_pending_requests()
    {
        $req = FinancialService::get_requests('0');
        $this->view->put_all(array(
            'C_CONTROLS' => FinancialAuthorizationsService::check_authorizations()->manager(),
            'C_ITEMS'    => !empty($req),
        ));

        foreach ($req as $value)
        {
            $this->view->assign_block_vars('pending_requests', array(
                'ACTIVITY_TYPE'      => $value['activity_type'] != '' ? ($value['activity_type'] == 'jpo' ? $this->lang['financial.jpo'] : $this->lang['financial.exam']) : $value['dedicated_object'],
                'CLUB_FFAM_NUMBER'   => $value['club_ffam_number'],
                'CLUB_DEPT'          => $value['club_dept'],
                'CLUB_NAME'          => $value['club_name'],
                'CLUB_ACTIVITY_DATE' => Date::to_format($value['club_activity_date'], Date::FORMAT_DAY_MONTH_YEAR),
                'CLUB_REQUEST_DATE'  => Date::to_format($value['club_request_date'], Date::FORMAT_DAY_MONTH_YEAR),
                'AMOUNT_PAID'        => $value['activity_type'] != '' ? ($value['activity_type'] == 'jpo' ? $this->config->get_jpo_day_amount() : $this->config->get_exam_day_amount()) : '--',
                'CHECKBOX_ID'        => $value['id'],
            ));
        }
    }

    private function generate_response($page = 1)
    {
        $response = new SiteDisplayResponse($this->view);

        $graphical_environment = $response->get_graphical_environment();
        $graphical_environment->set_page_title($this->lang['financial.pending.requests'], $this->lang['financial.pending.requests'], $page);
        $graphical_environment->get_seo_meta_data()->set_canonical_url(FinancialUrlBuilder::pending_requests());

        $breadcrumb = $graphical_environment->get_breadcrumb();
        $breadcrumb->add($this->lang['financial.home'], FinancialUrlBuilder::home());
        $breadcrumb->add($this->lang['financial.pending.requests'], FinancialUrlBuilder::pending_requests());

        return $response;
    }
}
?>
