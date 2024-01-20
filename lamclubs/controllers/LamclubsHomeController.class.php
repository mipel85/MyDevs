<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 18
 * @since       PHPBoost 6.0 - 2024 01 18
*/

class LamclubsHomeController extends DefaultModuleController
{
	private $display_multiple_delete = false;

	public function execute(HTTPRequestCustom $request)
	{
		$this->check_authorizations();

		$this->build_table();

		return $this->generate_response();
	}

	private function build_table()
	{
        $controls = LamclubsAuthorizationsService::check_authorizations()->moderation();
		$table_model = new SQLHTMLTableModel(LamclubsSetup::$lamclubs_table, 'table', array(
			new HTMLTableColumn($this->lang['lamclubs.ffam.number'], 'ffam_nb'),
			new HTMLTableColumn($this->lang['lamclubs.department'], 'department'),
			new HTMLTableColumn($this->lang['common.name'], 'name'),
			$controls ? new HTMLTableColumn($this->lang['common.moderation'], '', array('sr-only' => true)) : ''
		), new HTMLTableSortingRule('ffam_nb', HTMLTableSortingRule::ASC));

		$table_model->set_filters_menu_title($this->lang['lamclubs.filter.items']);
        $table_model->add_filter(new HTMLTableLikeFromListSQLFilter('department', 'filter2', $this->lang['lamclubs.department'],
            array(
                '44' => $this->lang['lamclubs.44'],
                '49' => $this->lang['lamclubs.49'],
                '53' => $this->lang['lamclubs.53'],
                '72' => $this->lang['lamclubs.72'],
                '85' => $this->lang['lamclubs.85'],
            )
        ));

		$table = new HTMLTable($table_model);
		$table->set_filters_fieldset_class_HTML();

		$table_model->set_layout_title($this->lang['lamclubs.module.title']);

		$results = array();
		$result = $table_model->get_sql_results('lamclubs',
			array('*', 'lamclubs.id')
		);

        $table->hide_multiple_delete();
        $this->display_multiple_delete = false;

		foreach ($result as $row)
		{
			$item = new LamclubsItem();
			$item->set_properties($row);

			$edit_item = new LinkHTMLElement(LamclubsUrlBuilder::edit($item->get_id()), '', array('title' => $this->lang['common.edit']), 'fa fa-edit');
			$delete_item = new LinkHTMLElement(LamclubsUrlBuilder::delete($item->get_id()), '', array('title' => $this->lang['common.delete'], 'data-confirmation' => 'delete-element'), 'far fa-trash-alt');

            // $draf_class = $item->get_published() ? '' : 'text-strike error';
			$row = array(
				new HTMLTableRowCell($item->get_ffam_nb()),
				new HTMLTableRowCell($this->lang['lamclubs.' . $item->get_department()]),
				new HTMLTableRowCell($item->get_name()),
				$controls ? new HTMLTableRowCell($edit_item->display() . $delete_item->display()) : ''
			);

			$results[] = new HTMLTableRow($row);
		}
		$table->set_rows($table_model->get_number_of_matching_rows(), $results);

		$this->view->put('CONTENT', $table->display());
	}

	private function check_authorizations()
	{
		if (!LamclubsAuthorizationsService::check_authorizations()->read())
		{
			$error_controller = PHPBoostErrors::user_not_authorized();
			DispatchManager::redirect($error_controller);
		}
	}

	private function generate_response()
	{
		$response = new SiteDisplayResponse($this->view);

		$graphical_environment = $response->get_graphical_environment();
		$graphical_environment->set_page_title($this->lang['lamclubs.module.title']);
		$graphical_environment->get_seo_meta_data()->set_canonical_url(LamclubsUrlBuilder::home());
        $description = StringVars::replace_vars($this->lang['lamclubs.seo.description.root'], array('site' => GeneralConfig::load()->get_site_name()));
		$graphical_environment->get_seo_meta_data()->set_description($description);
		
		$breadcrumb = $graphical_environment->get_breadcrumb();
		$breadcrumb->add($this->lang['lamclubs.module.title'], LamclubsUrlBuilder::home());

		return $response;
	}

	public static function get_view()
	{
		$object = new self('lamclubs');
		$object->check_authorizations();
		$object->build_table();
		return $object->view;
	}
}
?>
