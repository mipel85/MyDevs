<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class PlanningCategoriesManager extends CategoriesManager
{
	/**
	 * Deletes a category and items.
	 * @param int $id Id of the category to delete.
	 */
	public function delete($id)
	{
		if (!$this->get_categories_cache()->category_exists($id) || $id == Category::ROOT_CATEGORY)
		{
			throw new CategoryNotFoundException($id);
		}

		$result = PersistenceContext::get_querier()->select('SELECT id
		FROM ' . PlanningSetup::$planning_table . ' event
		WHERE id_category = :id_category', array('id_category' => $id));
		while ($row = $result->fetch())
		{
			PlanningService::delete_item($row['id']);
		}
		$result->dispose();

		parent::delete($id);
	}
}
?>
