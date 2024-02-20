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
	 * @desc Return the content of one budget.
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
        self::$db_querier->truncate(FinancialSetup::$financial_budget_table);
        $file = PATH_TO_ROOT . '/financial/data/budgets.csv';
        if (($handle = fopen($file, 'r')) !== false)
        {
            fgetcsv($handle); // ignore first row
            while(($data = fgetcsv($handle, 1000, ';')) !== false)
            {
                self::$db_querier->insert(FinancialSetup::$financial_budget_table, array(
                    'id'            => $data[0],
                    'domain'        => $data[1],
                    'name'          => $data[2],
                    'description'   => $data[3],
                    'fiscal_year'   => $date,
                    'annual_amount' => $data[4],
                    'real_amount'   => $data[4],
                    'temp_amount'   => $data[4],
                    'unit_amount'   => $data[5],
                    'max_amount'    => $data[6],
                    'quantity'      => $data[7],
                    'temp_quantity' => $data[7],
                    'real_quantity' => $data[7],
                    'use_dl'        => $data[8],
                    'bill_needed'   => $data[9]
                ));
            }
            fclose($handle);
        }
        else
        {
            echo '<div class="message-helper bgc-full error">Erreur lors de l\'ouverture du fichier CSV.</div>';
        }
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