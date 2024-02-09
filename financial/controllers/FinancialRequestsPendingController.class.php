<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class FinancialRequestsPendingController extends DefaultModuleController
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
			new HTMLTableColumn($this->lang['financial.tracking'], '', array('css_class' => 'col-large')),
			new HTMLTableColumn($this->lang['common.title'], 'title'),
			new HTMLTableColumn($this->lang['financial.club.name'], 'club_name'),
			new HTMLTableColumn($this->lang['financial.club.dpt'], 'club_department'),
			new HTMLTableColumn($this->lang['financial.request.event.date'], 'event_date'),
			new HTMLTableColumn($this->lang['financial.request.creation.date'], 'creation_date'),
			new HTMLTableColumn($this->lang['financial.request.files.url'], ''),
			new HTMLTableColumn($this->lang['common.actions'], '', array('sr-only' => true))
		);

        if (!FinancialAuthorizationsService::check_authorizations()->write())
            unset($columns[0]);

		$table_model = new SQLHTMLTableModel(
            FinancialSetup::$financial_request_table, 'items-pending', 
            $columns, new HTMLTableSortingRule('event_date', HTMLTableSortingRule::DESC)
        );

		$table_model->set_layout_title($this->lang['financial.pending.items']);

		// $table_model->set_filters_menu_title($this->lang['financial.filter.items']);
		// $table_model->add_filter(new HTMLTableDateComparatorSQLFilter('event_date', 'filter0', $this->lang['financial.request.event.date'] . ' ' . TextHelper::lcfirst($this->lang['common.minimum'])));
		// $table_model->add_filter(new HTMLTableDateGreaterThanOrEqualsToSQLFilter('event_date', 'filter1', $this->lang['financial.request.event.date'] . ' ' . TextHelper::lcfirst($this->lang['common.minimum'])));
		// $table_model->add_filter(new HTMLTableDateLessThanOrEqualsToSQLFilter('event_date', 'filter2', $this->lang['financial.request.event.date'] . ' ' . TextHelper::lcfirst($this->lang['common.maximum'])));
		// $table_model->add_filter(new HTMLTableLikeTextSQLFilter('department', 'filter3', $this->lang['financial.club.department']));

        $table_model->add_permanent_filter('agreement = ' . FinancialRequestItem::PENDING . ' OR agreement = ' . FinancialRequestItem::ONGOING);

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
			$user = $item->get_author_user();

			$this->items_number++;
			$this->ids[$this->items_number] = $item->get_id();

			$edit_link = new EditLinkHTMLElement(FinancialUrlBuilder::edit_item($item->get_id(), $item->get_budget_id()));
			$edit_link = $item->is_authorized_to_edit() ? $edit_link->display() : '';

			$delete_link = new DeleteLinkHTMLElement(FinancialUrlBuilder::delete_item($item->get_id()), '', array('data-confirmation' => 'delete-element'));
			$delete_link = $item->is_authorized_to_delete() ? $delete_link->display() : '';

            $club = LamclubsService::get_item($item->get_lamclubs_id());
            if($item->is_authorized_to_delete() || $item->is_authorized_to_edit())
            {
                $club_name = '<a href="mailto:'.$item->get_email().'">' . $club->get_name() . '</a>';
                $estimate_file = new LinkHTMLElement(FinancialUrlBuilder::dl_estimate($item->get_id()), '<i class="far fa-fw fa-file-lines"></i>', array('aria-label' => $this->lang['financial.request.estimate.url']));
                $estimate_file = !empty($item->get_estimate_url()->rel()) ? $estimate_file->display() : '';
                $invoice_file = new LinkHTMLElement(FinancialUrlBuilder::dl_invoice($item->get_id()), '<i class="fa fa-fw fa-file-contract"></i>', array('aria-label' => $this->lang['financial.request.invoice.url']));
                $invoice_file = !empty($item->get_invoice_url()->rel()) ? $invoice_file->display() : '';
            }
            else
            {
                $club_name = $club->get_name();
                $estimate_file = $invoice_file = '';
            }

            $ongoing = new LinkHTMLElement('#', '<i class="fa fa-arrows-rotate link-color"></i>', array('aria-label' => $this->lang['financial.tracking.ongoing']));
            $ongoing = $item->get_agreement_state() == FinancialRequestItem::PENDING ? $ongoing->display() : '';

            $reject = new LinkHTMLElement('#', '<i class="fa fa-rectangle-xmark error"></i>', array('aria-label' => $this->lang['financial.tracking.reject']));
            $reject = $reject->display();

            $budget = FinancialBudgetService::get_budget($item->get_budget_id());
            $amount_label = $budget->get_max_amount() ? ' aria-label="max: ' . $budget->get_max_amount() .'€"' : '';
            $amount = '<input class="tracking-input" type="text" width="80" id="amount_' . $item->get_id() . '" value="' . $budget->get_amount() . '"' . $amount_label . ' />';
            $accept = new LinkHTMLElement('#', '<i class="fa fa-square-check success"></i>', array('aria-label' => $this->lang['financial.tracking.accept']));
            $accept = $accept->display();

			$row = array(
				new HTMLTableRowCell($amount . $accept . $ongoing . $reject, 'controls'),
				new HTMLTableRowCell($item->get_title(), 'align-left'),
				new HTMLTableRowCell($club_name),
                new HTMLTableRowCell($club->get_department()),
                new HTMLTableRowCell($item->get_event_date()->format(Date::FORMAT_DAY_MONTH_YEAR)),
                new HTMLTableRowCell($item->get_creation_date()->format(Date::FORMAT_DAY_MONTH_YEAR)),
				new HTMLTableRowCell($estimate_file . $invoice_file, 'controls'),
                new HTMLTableRowCell($edit_link . $delete_link, 'controls')
			);

            if (!FinancialAuthorizationsService::check_authorizations()->write())
                unset($row[0]);

			$results[] = new HTMLTableRow($row);
		}
		$table->set_rows($table_model->get_number_of_matching_rows(), $results);

		$this->view->put('CONTENT', $table->display());

		return $table->get_page_number();
	}

	private function check_authorizations()
	{
		if (!FinancialAuthorizationsService::check_authorizations()->contribution())
		{
			$error_controller = PHPBoostErrors::user_not_authorized();
			DispatchManager::redirect($error_controller);
		}
	}

	private function generate_response($page = 1)
	{
		$response = new SiteDisplayResponse($this->view);

		$graphical_environment = $response->get_graphical_environment();
		$graphical_environment->set_page_title($this->lang['financial.items.management'], $this->lang['financial.module.title'], $page);
		$graphical_environment->get_seo_meta_data()->set_canonical_url(FinancialUrlBuilder::manage_items());

		$breadcrumb = $graphical_environment->get_breadcrumb();
		$breadcrumb->add($this->lang['financial.module.title'], FinancialUrlBuilder::home());

		$breadcrumb->add($this->lang['financial.pending.items'], FinancialUrlBuilder::display_pending_items());

		return $response;
	}
}
?>
