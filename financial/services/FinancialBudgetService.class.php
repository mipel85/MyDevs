<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class FinancialBudgetService
{
	private static $db_querier;

	public static function __static()
	{
		self::$db_querier = PersistenceContext::get_querier();
	}

	/**
	 * @desc Create a new budget.
	 * @param FinancialBudgetItem $budget new FinancialBudgetItem
	 */
	public static function add_budget(FinancialBudgetItem $budget)
	{
		$result = self::$db_querier->insert(FinancialSetup::$financial_budget_table, $budget->get_properties());

		return $result->get_last_inserted_id();
	}

	/**
	 * @desc Update an budget.
	 * @param FinancialBudgetItem $budget FinancialBudgetItem to update
	 */
	public static function update_budget(FinancialBudgetItem $budget)
	{
		self::$db_querier->update(FinancialSetup::$financial_budget_table, $budget->get_properties(), 'WHERE id = :id', array(
			'id' => $budget->get_id()
		));

		return $budget->get_id();
	}

	/**
	 * @desc Delete an budget.
	 * @param int $id id of the budget
	 */
	public static function delete_budget(int $id)
	{
		if (AppContext::get_current_user()->is_readonly())
		{
			$controller = PHPBoostErrors::user_in_read_only();
			DispatchManager::redirect($controller);
		}

		self::$db_querier->delete(FinancialSetup::$financial_budget_table, 'WHERE id = :id', array('id' => $id));

		PersistenceContext::get_querier()->delete(DB_TABLE_EVENTS, 'WHERE module=:module AND id_in_module=:id', array('module' => 'financial', 'id' => $id));
    }

	/**
	 * @desc Return the content of an budget.
	 * @param int $id Item identifier
	 */
	public static function get_budget(int $id)
	{
		$row = self::$db_querier->select_single_row_query('SELECT *
		FROM ' . FinancialSetup::$financial_budget_table . ' budget
		WHERE budget.id = :id', array(
			'id' => $id
		));

		$budget = new FinancialBudgetItem();
		$budget->set_properties($row);

		return $budget;
	}

    public static function get_budget_params($id)
    {
        $req = self::$db_querier->select('SELECT *
            FROM ' . FinancialSetup::$financial_budget_table . '
            WHERE id =' . $id
        );
        while($row = $req->fetch())
        {
            return $row;
        }
        $req->dispose();
    }

    public static function reset_budgets($date)
    {
        $req = self::$db_querier->select('SELECT *
		FROM ' . FinancialSetup::$financial_budget_table);
        while($row = $req->fetch())
        {
            self::$db_querier->update(
                FinancialSetup::$financial_budget_table,
                array($row['fiscal_year'] => $date),
                'WHERE id = :id', array('id' => $row['id'])
            );
        }
    }

    public static function update_temp_quantity($budget_id)
    {

    }

    public static function update_real_quantity($budget_id)
    {

    }

	/**
	 * @desc Clears all module elements in cache.
	 */
	public static function clear_cache()
	{
		Feed::clear_cache('financial');
	}
}
?>