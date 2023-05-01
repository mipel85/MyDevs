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
        return new FileTemplate('LamFinancial/LamFinancialStatementController.tpl');
    }

    public function execute(HTTPRequestCustom $request)
    {
        $this->check_authorizations();
        $this->build_financial_statement();

        return $this->generate_response();
    }

    private function check_authorizations()
    {
        if (!LamFinancialAuthorizationsService::check_authorizations()->manager()){
            $controller = PHPBoostErrors::user_not_authorized();
            DispatchManager::redirect($controller);
        }
    }

    private function build_financial_statement()
    {
        $nb_jpo_requests = LamFinancialService::get_pending_requests_number('jpo');
        $jpo_real_remaining_amount = $this->config->get_jpo_total_amount() - LamFinancialService::get_archived_amount_paid('jpo')['amount_paid'];
        $jpo_estimated_remaining_amount = $this->config->get_jpo_total_amount() - $this->config->get_jpo_day_amount() * $nb_jpo_requests['jpo'] - LamFinancialService::get_archived_amount_paid('jpo')['amount_paid'];

        $nb_exam_requests = LamFinancialService::get_pending_requests_number('exam');
        $exam_real_remaining_amount = $this->config->get_exam_total_amount() - LamFinancialService::get_archived_amount_paid('exam')['amount_paid'];
        $exam_estimated_remaining_amount = $this->config->get_exam_total_amount() - $this->config->get_exam_day_amount() * $nb_exam_requests['exam'] - LamFinancialService::get_archived_amount_paid('exam')['amount_paid'];;

        $this->view->put_all(array(
            'C_IS_AUTHORIZED'                 => AppContext::get_current_user()->get_groups()[1] == 1 || AppContext::get_current_user()->get_level(user::ADMINISTRATOR_LEVEL),
            'JPO'                             => $this->lang['lamfinancial.jpo'],
            'JPO_TOTAL_AMOUNT'                => $this->config->get_jpo_total_amount(),
            'JPO_DAY_AMOUNT'                  => $this->config->get_jpo_day_amount(),
            'JPO_NB_REQUESTS'                 => $nb_jpo_requests['jpo'],
            'JPO_ESTIMATED_REMAINING_AMOUNT'  => $jpo_estimated_remaining_amount,
            'JPO_REAL_REMAINING_AMOUNT'       => $jpo_real_remaining_amount,
            'EXAM'                            => $this->lang['lamfinancial.exam'],
            'EXAM_TOTAL_AMOUNT'               => $this->config->get_exam_total_amount(),
            'EXAM_DAY_AMOUNT'                 => $this->config->get_exam_day_amount(),
            'EXAM_NB_REQUESTS'                => $nb_exam_requests['exam'],
            'EXAM_ESTIMATED_REMAINING_AMOUNT' => $exam_estimated_remaining_amount,
            'EXAM_REAL_REMAINING_AMOUNT'      => $exam_real_remaining_amount
        ));
    }

    private function generate_response($page = 1)
    {
        $response = new SiteDisplayResponse($this->view);

        $graphical_environment = $response->get_graphical_environment();
        $graphical_environment->set_page_title($this->lang['lamfinancial.jpo'], $this->lang['lamfinancial.jpo'], $page);
        $graphical_environment->get_seo_meta_data()->set_canonical_url(LamFinancialUrlBuilder::financial_statement());

        $breadcrumb = $graphical_environment->get_breadcrumb();
        $breadcrumb->add($this->lang['lamfinancial.form'], LamFinancialUrlBuilder::home());
        $breadcrumb->add($this->lang['lamfinancial.financial.statement'], LamFinancialUrlBuilder::financial_statement());

        return $response;
    }
}
?>
