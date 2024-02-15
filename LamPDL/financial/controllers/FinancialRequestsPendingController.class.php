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
			new HTMLTableColumn($this->lang['financial.monitoring'], '', array('css_class' => 'col-xlarge')),
			new HTMLTableColumn(TextHelper::ucfirst($this->lang['financial.item']), 'title'),
			new HTMLTableColumn($this->lang['financial.club.nb'], 'ffam_nb'),
			new HTMLTableColumn($this->lang['financial.club.dpt'], 'department'),
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

		$table_model->set_filters_menu_title($this->lang['financial.filter.items']);
        $table_model->add_filter(new HTMLTableEqualsFromListSQLFilter('department', 'filter1', $this->lang['financial.club.dpt.filter'], array(44 => 44, 49 => 49, 53 => 53, 72 => 72, 85 => 85)));

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
            $budget = FinancialBudgetService::get_budget($item->get_budget_id());

			$this->items_number++;
			$this->ids[$this->items_number] = $item->get_id();

			$edit_link = new EditLinkHTMLElement(FinancialUrlBuilder::edit_item($item->get_id(), $item->get_budget_id()));
			$edit_link = $item->is_authorized_to_edit() ? $edit_link->display() : '';

			$delete_link = new DeleteLinkHTMLElement(FinancialUrlBuilder::delete_item($item->get_id()), '', array('data-confirmation' => 'delete-element'));
			$delete_link = $item->is_authorized_to_delete() ? $delete_link->display() : '';

            $club = LamclubsService::get_item($item->get_lamclubs_id());
            if($item->is_authorized_to_delete() || $item->is_authorized_to_edit())
            {
                $estimate_file = new LinkHTMLElement(FinancialUrlBuilder::dl_estimate($item->get_id()), '<i class="far fa-lg fa-file-lines"></i>', array('aria-label' => $this->lang['financial.request.estimate.url']));
                $estimate_file = !empty($item->get_estimate_url()->rel()) ? $estimate_file->display() : '';
                $invoice_file = new LinkHTMLElement(FinancialUrlBuilder::dl_invoice($item->get_id()), '<i class="fa fa-lg fa-file-contract"></i>', array('aria-label' => $this->lang['financial.request.invoice.url']));
                $invoice_file = !empty($item->get_invoice_url()->rel()) ? $invoice_file->display() : '';
                $no_files = $budget->get_bill_needed() && empty($item->get_estimate_url()->rel()) && empty($item->get_invoice_url()->rel()) ? 
                    '<span aria-label="' . $this->lang['financial.request.no.files'] . '"><i class="fa fa-lg fa-circle-question"></i></span>' : '';
                $ongoing_status = $item->get_agreement_state() == FinancialRequestItem::ONGOING && $budget->get_use_dl() && empty($item->get_invoice_url()->rel()) ?
                    '<span aria-label="' . $this->lang['financial.request.no.invoice'] . '"><i class="fa fa-lg fa-triangle-exclamation"></i></span>' : '';
            }
            else
            {
                $estimate_file = $invoice_file = $ongoing_status = $no_files = '';
            }

            $ongoing_link = new LinkHTMLElement(
                FinancialUrlBuilder::ongoing_request($item->get_id()), 
                $this->lang['financial.monitoring.ongoing'], 
                array('aria-label' => $this->lang['financial.monitoring.ongoing.clue']), 
                'small pinned visitor'
            );
            if ($budget->get_use_dl() && $budget->get_bill_needed() && empty($item->get_estimate_url()->rel()) && empty($item->get_invoice_url()->rel()))
            {
                $ongoing_class = ' bgc error';
                $ongoing_link = '';
            }
            elseif ($item->get_agreement_state() == FinancialRequestItem::ONGOING && $budget->get_use_dl())
            {
                $ongoing_class = ' bgc warning';
                $ongoing_link = '';
            }
            elseif ($item->get_agreement_state() == FinancialRequestItem::PENDING && $budget->get_use_dl())
            {
                $ongoing_class = '';
                $ongoing_link = $ongoing_link->display();
            }
            else
            {
                $ongoing_class = '';
                $ongoing_link = '';
            }

            $reject_link = new LinkHTMLElement(
                FinancialUrlBuilder::reject_request($item->get_id()), 
                $this->lang['financial.monitoring.reject'], 
                array('aria-label' => $this->lang['financial.monitoring.reject.clue']), 
                'small pinned error'
            );
            $reject_link = $reject_link->display();

            $amount_label = $budget->get_max_amount() ? 
                $this->lang['financial.request.allocated.budget'] . ': ' . $budget->get_unit_amount() . '<br />max: ' . $budget->get_max_amount() . '€' : 
                $this->lang['financial.request.allocated.budget'] . ': ' . $budget->get_unit_amount();
            $amount_number = TextHelper::mb_substr($budget->get_unit_amount(), 0, -1);
            $amount_max = $budget->get_max_amount() ? $budget->get_max_amount() : $amount_number;

            if (!$budget->get_use_dl() && ($budget->get_unit_amount() == '0€' || $budget->get_unit_amount() == '0%'))
            {
                $real_amount = '';
                $readonly = '';
                $type = 'type="number"';
            }
            elseif (!$budget->get_use_dl())
            {
                $real_amount = TextHelper::mb_substr($budget->get_unit_amount(), 0, -1);
                $readonly = 'readonly';
                $type = 'type="text"';
            }
            elseif ($budget->get_use_dl() && TextHelper::mb_substr($budget->get_unit_amount(), -1) !== '%')
            {
                $real_amount = TextHelper::mb_substr($budget->get_unit_amount(), 0, -1);
                $readonly = '';
                $type = 'type="number"';
            }
            else 
            {
                $real_amount = $readonly = '';
                $type = 'type="number"';
            }

            $id = $item->get_id();
            $amount = '<input 
                class="monitoring-input"
                ' . $type . '
                min="0" max="' . $amount_max . '"
                id="amount_' . $id . '"
                value="' . $real_amount . '"
                ' . $readonly . '
                aria-label="' . $amount_label . '" />';

            $accept_link = new LinkHTMLElement(
                FinancialUrlBuilder::accept_request($item->get_id(), ''), 
                $this->lang['financial.monitoring.accept'], 
                array('id' => 'accept_'.$item->get_id(), 'aria-label' => $this->lang['financial.monitoring.accept.clue']), 
                'payment-button small pinned bgc-full success'
            );
            $accept_link = $accept_link->display();

            if ($budget->get_use_dl() && empty($item->get_invoice_url()->rel()))
            {
                $amount = $accept_link = '';
            }

            $club_infos = '<span aria-label="'.$club->get_name().'">'.$club->get_ffam_nb().'</span>';

			$row = array(
				new HTMLTableRowCell($amount . $accept_link . $ongoing_link . $reject_link, $ongoing_class),
				new HTMLTableRowCell($item->get_title(), 'align-left' . $ongoing_class),
				new HTMLTableRowCell($club_infos, $ongoing_class),
                new HTMLTableRowCell($club->get_department() , $ongoing_class),
                new HTMLTableRowCell($item->get_event_date()->format(Date::FORMAT_DAY_MONTH_YEAR) , $ongoing_class),
                new HTMLTableRowCell($item->get_creation_date()->format(Date::FORMAT_DAY_MONTH_YEAR) , $ongoing_class),
				new HTMLTableRowCell($estimate_file . $invoice_file . $no_files . $ongoing_status, 'controls' . $ongoing_class),
                new HTMLTableRowCell($edit_link . $delete_link, 'controls' . $ongoing_class)
			);

            if (!FinancialAuthorizationsService::check_authorizations()->write())
                unset($row[0]);

			$results[] = new HTMLTableRow($row);
		}
		$table->set_rows($table_model->get_number_of_matching_rows(), $results);

        $this->view->put_all(array(
            'CONTENT' => $table->display(),
			'LEGEND'  => self::build_legend(),
        ));

		return $table->get_page_number();
	}

	protected function get_template_string_content()
	{
		return '
            # INCLUDE MESSAGE_HELPER #
            # INCLUDE CONTENT #
            # INCLUDE LEGEND #
        ';
	}

	private function build_legend()
	{
		$view = new FileTemplate('financial/FinancialPendingLegend.tpl');
		$view->add_lang($this->lang);

		$view->put_all(array(
            'C_MONITORING' => FinancialAuthorizationsService::check_authorizations()->write()
		));

		return $view;
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
