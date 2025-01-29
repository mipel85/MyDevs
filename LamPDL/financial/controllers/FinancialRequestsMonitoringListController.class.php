<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 18
 * @since       PHPBoost 6.0 - 2024 02 09
 * @contributor Mipel <mipel@phpboost.com>
 */
     
class FinancialRequestsMonitoringListController extends DefaultModuleController
{
    private $items_number = 0;
    private $ids = array();
        
    public function execute(HTTPRequestCustom $request)
    {
        $this->check_authorizations();
            
        $current_page = $this->build_select_year($request);
        $current_page = $this->build_table($request);
            
        return $this->generate_response($current_page);
    }
        
    private function build_table($request)
    {
        $columns = array(
            new HTMLTableColumn(TextHelper::ucfirst($this->lang['financial.budget.domain']), 'budget_domain'),
            new HTMLTableColumn(TextHelper::ucfirst($this->lang['financial.item']), 'request_type'),
            new HTMLTableColumn($this->lang['financial.club.dpt'], 'department'),
            new HTMLTableColumn('N° FFAM', 'ffam_nb'),
            new HTMLTableColumn($this->lang['financial.club.nb'], 'name'),
            new HTMLTableColumn($this->lang['financial.amount.paid'], 'amount_paid'),
            new HTMLTableColumn($this->lang['common.status'], 'agreement'),
            new HTMLTableColumn('Détails')
        );
            
        $request_fiscal_year = $request->get_value('year', '');
        $request_archive_tables = PersistenceContext::get_dbms_utils()->list_module_tables('financial_request_');
        if (in_array(PREFIX . 'financial_request_' . $request_fiscal_year, $request_archive_tables)) $current_year = '_' . $request_fiscal_year;
        else $current_year = '';
            
        $table_model = new SQLHTMLTableModel(FinancialSetup::$financial_request_table . $current_year, 'items-manager', $columns, new HTMLTableSortingRule('budget_domain', HTMLTableSortingRule::DESC));
        $table_model->set_filters_menu_title($this->lang['financial.filter.items']);
            
        /* filtre par département */
        $table_model->add_filter(new HTMLTableEqualsFromListSQLFilter('department', 'filter1', $this->lang['financial.club.dpt.filter'], array(44 => 44, 49 => 49, 53 => 53, 72 => 72, 85 => 85)));
            
        /* filtre par type de demande */
        $result = PersistenceContext::get_querier()->select('SELECT request_type, rewrited_type FROM ' . FinancialSetup::$financial_request_table . $current_year);
        $request_type = array();
        while($row = $result->fetch())
        {
            $request_type[$row['rewrited_type']] = $row['request_type'];
        }
        $result->dispose();
        asort($request_type);
        $table_model->add_filter(new HTMLTableEqualsFromListSQLFilter('rewrited_type', 'filter2', $this->lang['financial.request.type'], $request_type, true));
            
        /* filtre par clubs */
        $result_club = PersistenceContext::get_querier()->select('SELECT lamclubs_id FROM ' . FinancialSetup::$financial_request_table . $current_year);
        $clubs = [];
        while($row = $result_club->fetch())
        {
            $clubs[$row['lamclubs_id']] = LamclubsService::get_item($row['lamclubs_id'])->get_name();
        }
        $table_model->add_filter(new HTMLTableEqualsFromListSQLFilter('lamclubs_id', 'filter3', 'Club', $clubs));
            
        $table = new HTMLTable($table_model);
        $table->set_css_class('modal-container');
        $table->set_filters_fieldset_class_HTML();
        $table->hide_multiple_delete();
            
        $results = array();
        $result = $table_model->get_sql_results('fr
            LEFT JOIN ' . DB_TABLE_MEMBER . ' member ON member.user_id = fr.author_user_id
            LEFT JOIN ' . LamclubsSetup::$lamclubs_table . ' lc ON lc.club_id = fr.lamclubs_id
            LEFT JOIN ' . FinancialSetup::$financial_budget_table . ' fb ON fr.budget_id = fb.id',
                                                array('*')
        );
        $total_expenses = 0;
            
        foreach ($result as $row)
        {
            $total_expenses += $row['amount_paid'];
            $total_expenses = number_format($total_expenses, 2, '.', '');
            $item = new FinancialRequestItem();
            $item->set_properties($row);
            $this->items_number++;
            $this->ids[$this->items_number] = $item->get_id();
                
            $delete_link = new DeleteLinkHTMLElement(FinancialUrlBuilder::delete_item($item->get_id()), '', array('data-confirmation' => 'delete-element'));
            $delete_link = FinancialAuthorizationsService::check_authorizations()->write() ? $delete_link->display() : '';
                
            $club = LamclubsService::get_item($item->get_lamclubs_id());
            $club_ffam_number = '<span aria-label="' . $club->get_name() . '">' . $club->get_ffam_nb() . '</span>';
                
            $estimate_url = new LinkHTMLElement($item->get_estimate_url(), '<i class="far fa-lg fa-file-lines"></i>', array('aria-label' => $this->lang['financial.request.estimate.url']));
            $estimate_url = !empty($item->get_estimate_url()->rel()) ? $estimate_url->display() : '';
                
            $invoice_url = new LinkHTMLElement($item->get_invoice_url(), '<i class="fa fa-lg fa-file-contract"></i>', array('aria-label' => $this->lang['financial.request.invoice.url']));
            $invoice_url = !empty($item->get_invoice_url()->rel()) ? $invoice_url->display() : '';
                
            $values = array(
                new HTMLTableRowCell($row['budget_domain'], 'align-left'),
                new HTMLTableRowCell($item->get_request_type(), 'align-left'),
                new HTMLTableRowCell($club->get_department()),
                new HTMLTableRowCell($club_ffam_number),
                new HTMLTableRowCell($club->get_name(), 'align-left'),
                new HTMLTableRowCell($item->get_amount_paid() <> '' ? $item->get_amount_paid() . ' € ' : 0),
                new HTMLTableRowCell($item->get_status()),
                new HTMLTableRowCell(
                    '<span data-modal="" data-target="target-panel-' . $row['id'] . '"><i class="fa fa-square-plus"></i></i></span>
                    <div id="target-panel-' . $row['id'] . '"class="modal modal-animation">
                        <div class="close-modal" aria-label="' . $this->lang['common.close'] . '"></div>
                        <div class="content-panel">
                            <div class="align-right"><a href="#" class="error big hide-modal" aria-label="' . $this->lang['common.close'] . '"><i class="far fa-circle-xmark" aria-hidden="true"></i></a></div>
                            <table>
                                <thead>
                                    <tr>
                                        <span class="span-modal-title">' . '[' . $item->get_status() . '] .... ' . $club->get_name() . '</span> .... ' . $row['budget_domain'] . ' / ' . $item->get_request_type() . '
                                    </tr>
                                    <tr>
                                        <th>Suivi par</th>
                                        <th>Demandé</th>
                                        <th>Réalisé</th>
                                        <th>Traité</th>
                                        <th>Description</th>
                                        <th>Budget prévu</th>
                                        <th>Budget dépensé</th>
                                        <th>Budget restant</th>
                                        <th>Devis</th>
                                        <th>Facture</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>' . $row['sender_name'] . '</td>
                                        <td>' . Date::to_format($row['creation_date'], Date::FORMAT_DAY_MONTH_YEAR) . '</td>
                                        <td>' . Date::to_format($row['event_date'], Date::FORMAT_DAY_MONTH_YEAR) . '</td>
                                        <td>' . $item->get_agreement_date()->format(Date::FORMAT_DAY_MONTH_YEAR) . '</td>
                                        <td class="description-width">' . $row['request_description'] . '</td>
                                        <td>' . $row['annual_amount'] . '€</td>
                                        <td>' . number_format($row['annual_amount'] - $row['real_amount'], 2, '.') . '€</td>
                                        <td>' . $row['real_amount'] . '€</td>
                                        <td>' . $estimate_url . '</td>
                                        <td>' . $invoice_url . '</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>'
                )
            );
            $results[] = new HTMLTableRow($values);
        }
            
        /* affiche le total des dépenses par type de demande */
        $request_fiscal_year = $request->get_value('year', 'exercice en cours');
        $table_model->set_caption($this->lang['financial.budgets.statement'] . ' - ' . $request_fiscal_year . ' ... ' . $total_expenses . '€');
        $table->set_rows($table_model->get_number_of_matching_rows(), $results);
            
        $this->view->put('CONTENT', $table->display());
            
        return $table->get_page_number();
    }
        
    private function build_select_year(HTTPRequestCustom $request)
    {
        /* construction du sélecteur de dates */
        $request_fiscal_year = $request->get_value('year', '');
        $select_year = new HTMLForm(__CLASS__, '', false);
        $select_year->set_css_class('bgc visitor');
            
        $fieldset = new FormFieldsetHorizontal('select_years', array('description' => $this->lang ['financial.display.year']));
        $select_year->add_fieldset($fieldset);
            
        $request_archive_tables = PersistenceContext::get_dbms_utils()->list_module_tables('financial_request_');
        if (in_array(PREFIX . 'financial_request_' . $request_fiscal_year, $request_archive_tables)) $current_year = $request_fiscal_year;
        else $current_year = '';
            
        $years = [];
        $years[] = new FormFieldSelectChoiceOption('en cours', ''); /* valeur par défaut du sélect */
        foreach ($request_archive_tables as $request_table)
        {
            $table_year = explode('_', $request_table);
            $year = end($table_year);
            $years[] = new FormFieldSelectChoiceOption($year, $year);
        }
            
        $fieldset->add_field(new FormFieldSimpleSelectChoice('year', '', $current_year, $years,
            array(
                'events' => array('change' => '
                    if (HTMLForms.getField("year").getValue())
                        year = HTMLForms.getField("year").getValue() + "/"
                    else
                        year = ""
                    document.location = "' . TPL_PATH_TO_ROOT . '/financial/requests_monitoring_list/" + year
                ')
                )
        ));
            
        $this->view->put('SELECT_YEAR', $select_year->display());
    }
        
    private function check_authorizations()
    {
        if (!FinancialAuthorizationsService::check_authorizations()->moderation()){
            $error_controller = PHPBoostErrors::user_not_authorized();
            DispatchManager::redirect($error_controller);
        }
    }
        
    private function generate_response($page = 1)
    {
        $response = new SiteDisplayResponse($this->view);
            
        $graphical_environment = $response->get_graphical_environment();
        $graphical_environment->set_page_title($this->lang['financial.budgets.statement'], $this->lang['financial.module.title'], $page);
        $graphical_environment->get_seo_meta_data()->set_canonical_url(FinancialUrlBuilder::requests_monitoring_list(2024));
            
        $breadcrumb = $graphical_environment->get_breadcrumb();
        $breadcrumb->add($this->lang['financial.module.title'], FinancialUrlBuilder::home());
        $breadcrumb->add($this->lang['financial.budgets.statement'], FinancialUrlBuilder::requests_monitoring_list(2024));
            
        return $response;
    }
        
    protected function get_template_string_content()
    {
        return '# INCLUDE MESSAGE_HELPER # # INCLUDE SELECT_YEAR # # INCLUDE CONTENT #';
    }
}