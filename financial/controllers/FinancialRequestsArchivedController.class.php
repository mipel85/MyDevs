<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class FinancialRequestsArchivedController extends DefaultModuleController
{
	private $items_number = 0;
	private $ids = array();

	public function execute(HTTPRequestCustom $request)
	{
		$this->check_authorizations();

		$current_page = $this->build_table();

		$this->execute_multiple_delete_if_needed($request);

		return $this->generate_response($current_page);
	}

	private function build_table()
	{
		$columns = array(
			new HTMLTableColumn($this->lang['common.title'], 'title'),
			new HTMLTableColumn($this->lang['financial.club.name'], 'club_name'),
			new HTMLTableColumn($this->lang['financial.club.dpt'], 'club_department'),
			new HTMLTableColumn($this->lang['financial.request.event.date'], 'event_date'),
			new HTMLTableColumn($this->lang['financial.request.creation.date'], 'creation_date'),
			new HTMLTableColumn($this->lang['common.actions'], '', array('sr-only' => true))
		);

		$table_model = new SQLHTMLTableModel(FinancialSetup::$financial_request_table, 'items-manager', $columns, new HTMLTableSortingRule('event_date', HTMLTableSortingRule::DESC));

		$table_model->set_layout_title($this->lang['financial.archived.items']);

		// $table_model->set_filters_menu_title($this->lang['financial.filter.items']);
		// $table_model->add_filter(new HTMLTableDateComparatorSQLFilter('event_date', 'filter0', $this->lang['financial.request.event.date'] . ' ' . TextHelper::lcfirst($this->lang['common.minimum'])));
		// $table_model->add_filter(new HTMLTableDateGreaterThanOrEqualsToSQLFilter('event_date', 'filter1', $this->lang['financial.request.event.date'] . ' ' . TextHelper::lcfirst($this->lang['common.minimum'])));
		// $table_model->add_filter(new HTMLTableDateLessThanOrEqualsToSQLFilter('event_date', 'filter2', $this->lang['financial.request.event.date'] . ' ' . TextHelper::lcfirst($this->lang['common.maximum'])));
		// $table_model->add_filter(new HTMLTableLikeTextSQLFilter('department', 'filter3', $this->lang['financial.club.department']));

        $table_model->add_permanent_filter('agreement = ' . FinancialRequestItem::ACCEPTED . ' OR agreement = ' . FinancialRequestItem::REJECTED);

		$table = new HTMLTable($table_model);
		$table->set_filters_fieldset_class_HTML();

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

			$user_group_color = User::get_group_color($user->get_groups(), $user->get_level(), true);
			$author = $user->get_id() !== User::VISITOR_LEVEL ? new LinkHTMLElement(UserUrlBuilder::profile($user->get_id()), $user->get_display_name(), (!empty($user_group_color) ? array('style' => 'color: ' . $user_group_color) : array()), UserService::get_level_class($user->get_level())) : $user->get_display_name();

			$br = new BrHTMLElement();

            $club = LamclubsService::get_item($item->get_lamclubs_id());
            if($item->is_authorized_to_delete() || $item->is_authorized_to_edit())
                $club_name = '<a href="mailto:'.$item->get_email().'">' . $club->get_name() . '</a>';
            else
                $club_name = $club->get_name();

			$row = array(
				new HTMLTableRowCell($item->get_title(), 'align-left'),
				new HTMLTableRowCell($club_name),
                new HTMLTableRowCell($club->get_department()),
                new HTMLTableRowCell($item->get_event_date()->format(Date::FORMAT_DAY_MONTH_YEAR)),
                new HTMLTableRowCell($item->get_creation_date()->format(Date::FORMAT_DAY_MONTH_YEAR)),
                new HTMLTableRowCell($edit_link . $delete_link, 'controls')
			);

			$results[] = new HTMLTableRow($row);
		}
		$table->set_rows($table_model->get_number_of_matching_rows(), $results);

		$this->view->put('CONTENT', $table->display());

		return $table->get_page_number();
	}

	private function execute_multiple_delete_if_needed(HTTPRequestCustom $request)
	{
		if ($request->get_string('delete-selected-elements', false))
		{
			for ($i = 1 ; $i <= $this->items_number ; $i++)
			{
				if ($request->get_value('delete-checkbox-' . $i, 'off') == 'on')
				{
					if (isset($this->ids[$i]))
					{
						$item = '';
						try {
							$item = FinancialRequestService::get_item($this->ids[$i]);
						} catch (RowNotFoundException $e) {}

						if ($item)
						{
							//Delete item
							FinancialRequestService::delete_item($item->get_id());

							HooksService::execute_hook_action('delete', self::$module_id, $item->get_properties());
						}
					}
				}
			}

			FinancialRequestService::clear_cache();

			AppContext::get_response()->redirect(FinancialUrlBuilder::manage_items(), $this->lang['warning.process.success']);
		}
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
		$graphical_environment->set_page_title($this->lang['financial.items.management'], $this->lang['financial.module.title'], $page);
		$graphical_environment->get_seo_meta_data()->set_canonical_url(FinancialUrlBuilder::manage_items());

		$breadcrumb = $graphical_environment->get_breadcrumb();
		$breadcrumb->add($this->lang['financial.module.title'], FinancialUrlBuilder::home());

		$breadcrumb->add($this->lang['financial.archived.items'], FinancialUrlBuilder::manage_items());

		return $response;
	}
}
?>
