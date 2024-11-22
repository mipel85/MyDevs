<?php

/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 11 22
 * @since       PHPBoost 6.0 - 2024 02 09
 * @contributor Mipel <mipel@phpboost.com>
 */

class FinancialRequestsExpensesListController extends DefaultModuleController
{
	private $items_number = 0;
	private $ids		  = array();

	public function execute(HTTPRequestCustom $request)
	{
		$this->check_authorizations();

		$current_page = $this->build_table();

		return $this->generate_response($current_page);
	}

	private function build_table()
	{
		$columns = array(
			new HTMLTableColumn(TextHelper::ucfirst($this->lang['financial.budget.domain']), 'budget_domain'),
			new HTMLTableColumn(TextHelper::ucfirst($this->lang['financial.item']), 'request_type'),
			new HTMLTableColumn($this->lang['financial.club.dpt'], 'department'),
			new HTMLTableColumn('N° FFAM', 'ffam_nb'),
			new HTMLTableColumn($this->lang['financial.club.nb'], 'name'),
			new HTMLTableColumn($this->lang['financial.amount.paid'], 'amount_paid'),
			new HTMLTableColumn('Détails')
		);

		$table_model = new SQLHTMLTableModel(FinancialSetup::$financial_request_table, 'items-manager', $columns, new HTMLTableSortingRule('budget_domain', HTMLTableSortingRule::DESC));

		$table_model->set_filters_menu_title($this->lang['financial.filter.items']);

		/* filtre par département */
		$table_model->add_filter(new HTMLTableEqualsFromListSQLFilter('department', 'filter1', $this->lang['financial.club.dpt.filter'], array(44 => 44, 49 => 49, 53 => 53, 72 => 72, 85 => 85)));

		/* filtre par type de demande */
		$result		  = PersistenceContext::get_querier()->select('SELECT request_type, rewrited_type FROM ' . FinancialSetup::$financial_request_table);
		$request_type = array();
		while ($row = $result->fetch()) {
			$request_type[$row['rewrited_type']] = $row['request_type'];
		}
		$result->dispose();
		asort($request_type);
		$table_model->add_filter(new HTMLTableEqualsFromListSQLFilter('rewrited_type', 'filter2', $this->lang['financial.request.type'], $request_type, true));

		/* filtre permanent, on affiche uniquement les demandes acceptées */
		$table_model->add_permanent_filter('agreement = ' . FinancialRequestItem::ACCEPTED);

		$table = new HTMLTable($table_model);
		$table->set_css_class('modal-container');
		$table->set_filters_fieldset_class_HTML();
		$table->hide_multiple_delete();

		$results = array();
		$result	 = $table_model->get_sql_results(
			'fr
			       LEFT JOIN ' . DB_TABLE_MEMBER . ' member ON member.user_id = fr.author_user_id
			       LEFT JOIN ' . LamclubsSetup::$lamclubs_table . ' lc ON lc.club_id = fr.lamclubs_id
			       LEFT JOIN ' . FinancialSetup::$financial_budget_table . ' fb ON fr.budget_id = fb.id',
			array('*')
		);
		$total_expenses = 0;

		foreach ($result as $row) {
			$total_expenses += $row['amount_paid'];
			$total_expenses = number_format($total_expenses, 2, '.', '');
			$item = new FinancialRequestItem();
			$item->set_properties($row);
			$this->items_number++;
			$this->ids[$this->items_number] = $item->get_id();

			$delete_link = new DeleteLinkHTMLElement(FinancialUrlBuilder::delete_item($item->get_id()), '', array('data-confirmation' => 'delete-element'));
			$delete_link = FinancialAuthorizationsService::check_authorizations()->write() ? $delete_link->display() : '';

			$club			  = LamclubsService::get_item($item->get_lamclubs_id());
			$club_ffam_number = '<span aria-label="' . $club->get_name() . '">' . $club->get_ffam_nb() . '</span>';

			$estimate_url	  = new LinkHTMLElement($item->get_estimate_url(), '<i class="far fa-lg fa-file-lines"></i>', array('aria-label' => $this->lang['financial.request.estimate.url']));
			$estimate_url	  = !empty($item->get_estimate_url()->rel()) ? $estimate_url->display() : '';

			$invoice_url = new LinkHTMLElement($item->get_invoice_url(), '<i class="fa fa-lg fa-file-contract"></i>', array('aria-label' => $this->lang['financial.request.invoice.url']));
			$invoice_url = !empty($item->get_invoice_url()->rel()) ? $invoice_url->display() : '';

			$values = array(
				new HTMLTableRowCell($row['budget_domain'], 'align-left'),
				new HTMLTableRowCell($item->get_request_type(), 'align-left'),
				new HTMLTableRowCell($club->get_department()),
				new HTMLTableRowCell($club_ffam_number),
				new HTMLTableRowCell($club->get_name(), 'align-left'),
				new HTMLTableRowCell($item->get_amount_paid() . '€'),
				new HTMLTableRowCell(
					'<span data-modal="" data-target="target-panel-' . $row['id'] . '"><i class="fa fa-square-plus"></i></i></span>
                    <div id="target-panel-' . $row['id'] . '"class="modal modal-animation">
                        <div class="close-modal" aria-label="' . $this->lang['common.close'] . '"></div>
                        <div class="content-panel">
                            <div class="align-right"><a href="#" class="error big hide-modal" aria-label="' . $this->lang['common.close'] . '"><i class="far fa-circle-xmark" aria-hidden="true"></i></a></div>
                            <table>
                                <thead>
                                    <tr>
                                        <span class="span-modal-title">' . $club->get_name() . '</span> --- ' . $row['budget_domain'] . ' / ' . $item->get_request_type() . '
                                    </tr>
                                    <tr>
                                        <th>Suivi par</th>
                                        <th>Demandé</th>
                                        <th>Réalisé</th>
                                        <th>Payé</th>
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
		$table_model->set_caption($this->lang['financial.budgets.statement'] . ' --- ' . $total_expenses . '€');

		$table->set_rows($table_model->get_number_of_matching_rows(), $results);

		$this->view->put('CONTENT', $table->display());

		return $table->get_page_number();
	}

	private function check_authorizations()
	{
		if (!FinancialAuthorizationsService::check_authorizations()->moderation()) {
			$error_controller = PHPBoostErrors::user_not_authorized();
			DispatchManager::redirect($error_controller);
		}
	}

	private function generate_response($page = 1)
	{
		$response = new SiteDisplayResponse($this->view);

		$graphical_environment = $response->get_graphical_environment();
		$graphical_environment->set_page_title($this->lang['financial.budgets.statement'], $this->lang['financial.module.title'], $page);
		$graphical_environment->get_seo_meta_data()->set_canonical_url(FinancialUrlBuilder::expenses_list());

		$breadcrumb = $graphical_environment->get_breadcrumb();
		$breadcrumb->add($this->lang['financial.module.title'], FinancialUrlBuilder::home());
		$breadcrumb->add($this->lang['financial.budgets.statement'], FinancialUrlBuilder::expenses_list());

		return $response;
	}
}
