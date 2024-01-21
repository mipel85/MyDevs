<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class PlanningSearchable extends DefaultSearchable
{
	public function __construct()
	{
		parent::__construct('planning');

		$this->table_name = PlanningSetup::$planning_table;

		$this->field_id = 'id';
		$this->field_rewrited_link = 'rewrited_link';
		$this->field_content = 'content';

		$this->field_published = 'approved';
	}
}
?>
