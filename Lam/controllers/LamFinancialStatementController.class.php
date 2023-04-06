<?php
/*
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2023 03 03
 * @since       PHPBoost 6.0 - 2022 12 20
 */
class LamFinancialStatementController extends DefaultModuleController
{
    private $activity;
    private $items_number = 0;
    private $ids = array();

    protected function get_template_to_use()
    {
        return new FileTemplate('Lam/LamFinancialStatementController.tpl');
    }

    public function execute(HTTPRequestCustom $request)
    {
        $this->check_authorizations();
        $this->build_financial_statement();

        return $this->generate_response();
    }

    private function check_authorizations()
    {
        if (!LamAuthorizationsService::check_authorizations()->manager()){
            $controller = PHPBoostErrors::user_not_authorized();
            DispatchManager::redirect($controller);
        }
    }

    private function build_financial_statement()
    {
        $nb_jpo_requests = LamService::get_requests_number('jpo');
        $jpo_estimated_remaining_amount = $this->config->get_jpo_total_amount() - $this->config->get_jpo_day_amount() * $nb_jpo_requests['jpo'];
//        $jpo_real_remaining_amount = $this->config->get_jpo_total_amount() - $this->config->get_jpo_day_amount() * $nb_jpo_requests['jpo'];

        $nb_exam_requests = LamService::get_requests_number('exam');
        $exam_estimated_remaining_amount = $this->config->get_exam_total_amount() - $this->config->get_exam_day_amount() * $nb_exam_requests['exam'];

        $this->view->put_all(array(
            'C_IS_AUTHORIZED'                 => AppContext::get_current_user()->get_groups()[1] == 1 || AppContext::get_current_user()->get_level(user::ADMINISTRATOR_LEVEL),
            'JPO'                             => $this->lang['lam.jpo'],
            'JPO_TOTAL_AMOUNT'                => $this->config->get_jpo_total_amount(),
            'JPO_DAY_AMOUNT'                  => $this->config->get_jpo_day_amount(),
            'JPO_NB_REQUESTS'                 => $nb_jpo_requests['jpo'],
            'JPO_ESTIMATED_REMAINING_AMOUNT'  => $jpo_estimated_remaining_amount,
            'EXAM'                            => $this->lang['lam.exam'],
            'EXAM_TOTAL_AMOUNT'               => $this->config->get_exam_total_amount(),
            'EXAM_DAY_AMOUNT'                 => $this->config->get_exam_day_amount(),
            'EXAM_NB_REQUESTS'                => $nb_exam_requests['exam'],
            'EXAM_ESTIMATED_REMAINING_AMOUNT' => $exam_estimated_remaining_amount
        ));
    }

    private function generate_response($page = 1)
    {
        $response = new SiteDisplayResponse($this->view);

        $graphical_environment = $response->get_graphical_environment();
        $graphical_environment->set_page_title($this->lang['lam.jpo'], $this->lang['lam.jpo'], $page);
        $graphical_environment->get_seo_meta_data()->set_canonical_url(LamUrlBuilder::financial_statement());

        $breadcrumb = $graphical_environment->get_breadcrumb();
        $breadcrumb->add($this->lang['lam.form'], LamUrlBuilder::home());
        $breadcrumb->add($this->lang['lam.financial.statement'], LamUrlBuilder::financial_statement());

        return $response;
    }
}
?>
