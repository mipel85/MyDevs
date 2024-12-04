<?php
/**
 * @copyright   &copy; 2005-2024 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 02
 * @since       PHPBoost 6.0 - 2024 12 02
*/

class FinancialSearchable extends DefaultSearchable
{
	public function __construct()
	{
		$module_id = 'financial';
		parent::__construct($module_id);

		$this->table_name = FinancialSetup::$financial_request_table;

        $this->read_authorization = FinancialAuthorizationsService::check_authorizations()->read();

		$this->field_title = 'request_type';
		$this->field_rewrited_title = 'rewrited_type';
	}
}
?>
