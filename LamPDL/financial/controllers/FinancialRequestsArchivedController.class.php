<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 08 30
 * @since       PHPBoost 6.0 - 2024 02 09
 * @contributor Mipel <mipel@phpboost.com>
*/

class FinancialRequestsArchivedController extends DefaultModuleController
{
	private $items_number = 0;
	private $ids = array();

	public function execute(HTTPRequestCustom $request)
	{
		$this->check_authorizations();

		$current_page = $this->build_table();

		return $this->generate_response($current_page);
	}

	private function build_table()
	{
		$columns = array(
			new HTMLTableColumn(TextHelper::ucfirst($this->lang['financial.item']), 'title'),
			new HTMLTableColumn($this->lang['financial.club.nb'], 'club_name'),
			new HTMLTableColumn($this->lang['financial.club.dpt'], 'club_department'),
			new HTMLTableColumn($this->lang['financial.request.creation.date'], 'creation_date'),
			new HTMLTableColumn($this->lang['financial.request.validation.date'], 'agreement_date'),
			new HTMLTableColumn($this->lang['common.status'], 'agreement'),
			new HTMLTableColumn($this->lang['financial.amount.paid'], 'amount_paid'),
			new HTMLTableColumn($this->lang['financial.request.files.url'], '')
		);

		$table_model = new SQLHTMLTableModel(FinancialSetup::$financial_request_table, 'items-manager', $columns, new HTMLTableSortingRule('event_date', HTMLTableSortingRule::DESC));

		$table_model->set_layout_title($this->lang['financial.archived.items']);

        $table_model->set_filters_menu_title($this->lang['financial.filter.items']);
		$table_model->add_filter(new HTMLTableEqualsFromListSQLFilter('department', 'filter1', $this->lang['financial.club.dpt.filter'], array(44 => 44, 49 => 49, 53 => 53, 72 => 72, 85 => 85)));

        /* filtre par type de demande */
        $result = PersistenceContext::get_querier()->select('SELECT title, rewrited_title FROM ' . FinancialSetup::$financial_request_table);
		$request_type = array();
		while ($row = $result->fetch())
		{
            $request_type[$row['rewrited_title']] = $row['title'];
		}
		$result->dispose();
		asort($request_type);
        $table_model->add_filter(new HTMLTableEqualsFromListSQLFilter('rewrited_title', 'filter2', $this->lang['financial.request.type'], $request_type, true));
        
        /* filtre permanent, on n'affiche pas les demandes acceptées ou rejetées */
        $table_model->add_permanent_filter('agreement = ' . FinancialRequestItem::ACCEPTED . ' OR agreement = ' . FinancialRequestItem::REJECTED);

		$table = new HTMLTable($table_model);
		$table->set_filters_fieldset_class_HTML();
        $table->hide_multiple_delete();

		$results = array();
		$result = $table_model->get_sql_results('request
			LEFT JOIN ' . DB_TABLE_MEMBER . ' member ON member.user_id = request.author_user_id
			LEFT JOIN ' . LamclubsSetup::$lamclubs_table . ' club ON club.club_id = request.lamclubs_id'
		);
        
		foreach ($result as $row)
		{
            $item = new FinancialRequestItem();
			$item->set_properties($row);

			$this->items_number++;
			$this->ids[$this->items_number] = $item->get_id();

			$delete_link = new DeleteLinkHTMLElement(FinancialUrlBuilder::delete_item($item->get_id()), '', array('data-confirmation' => 'delete-element'));
			$delete_link = FinancialAuthorizationsService::check_authorizations()->write() ? $delete_link->display() : '';

			$club = LamclubsService::get_item($item->get_lamclubs_id());
            $club_infos = '<span aria-label="'.$club->get_name().'">'.$club->get_ffam_nb().'</span>';

            $estimate_file = new LinkHTMLElement(FinancialUrlBuilder::dl_estimate($item->get_id()), '<i class="far fa-lg fa-file-lines"></i>', array('aria-label' => $this->lang['financial.request.estimate.url']));
            $estimate_file = !empty($item->get_estimate_url()->rel()) ? $estimate_file->display() : '';
            $invoice_file = new LinkHTMLElement(FinancialUrlBuilder::dl_invoice($item->get_id()), '<i class="fa fa-lg fa-file-contract"></i>', array('aria-label' => $this->lang['financial.request.invoice.url']));
            $invoice_file = !empty($item->get_invoice_url()->rel()) ? $invoice_file->display() : '';
            
			$row = array(
				new HTMLTableRowCell($item->get_title(), 'align-left'),
				new HTMLTableRowCell($club_infos),
                new HTMLTableRowCell($club->get_department()),
                new HTMLTableRowCell($item->get_creation_date()->format(Date::FORMAT_DAY_MONTH_YEAR)),
                new HTMLTableRowCell($item->get_agreement_date()->format(Date::FORMAT_DAY_MONTH_YEAR)),
                new HTMLTableRowCell($item->get_status()),
                new HTMLTableRowCell($item->get_amount_paid()),
				new HTMLTableRowCell($estimate_file . $invoice_file, 'controls'),
			);

			$results[] = new HTMLTableRow($row);
		}
		
        $table->set_rows($table_model->get_number_of_matching_rows(), $results);

		$this->view->put('CONTENT', $table->display());

		return $table->get_page_number();
	}

	private function check_authorizations()
	{
		if (!FinancialAuthorizationsService::check_authorizations()->moderation())
		{
			$error_controller = PHPBoostErrors::user_not_authorized();
			DispatchManager::redirect($error_controller);
		}
	}

	private function generate_response($page = 1)
	{
		$response = new SiteDisplayResponse($this->view);

		$graphical_environment = $response->get_graphical_environment();
		$graphical_environment->set_page_title($this->lang['financial.archived.items'], $this->lang['financial.module.title'], $page);
		$graphical_environment->get_seo_meta_data()->set_canonical_url(FinancialUrlBuilder::archived_items());

		$breadcrumb = $graphical_environment->get_breadcrumb();
		$breadcrumb->add($this->lang['financial.module.title'], FinancialUrlBuilder::home());
		$breadcrumb->add($this->lang['financial.archived.items'], FinancialUrlBuilder::archived_items());

		return $response;
	}
}
?>
