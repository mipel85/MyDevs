<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class FinancialRequestService
{
	private static $db_querier;

	public static function __static()
	{
		self::$db_querier = PersistenceContext::get_querier();
	}

	/**
	 * @desc Create a new item.
	 * @param FinancialRequestItem $item new FinancialRequestItem
	 */
	public static function add_item(FinancialRequestItem $item)
	{
		$result = self::$db_querier->insert(FinancialSetup::$financial_request_table, $item->get_properties());

		return $result->get_last_inserted_id();
	}

	/**
	 * @desc Update an item.
	 * @param FinancialRequestItem $item FinancialRequestItem to update
	 */
	public static function update_item(FinancialRequestItem $item)
	{
		self::$db_querier->update(FinancialSetup::$financial_request_table, $item->get_properties(), 'WHERE id = :id', array(
			'id' => $item->get_id()
		));

		return $item->get_id();
	}

	/**
	 * @desc Delete an item.
	 * @param int $id id of the item
	 */
	public static function delete_item(int $id)
	{
		if (AppContext::get_current_user()->is_readonly())
		{
			$controller = PHPBoostErrors::user_in_read_only();
			DispatchManager::redirect($controller);
		}

		self::$db_querier->delete(FinancialSetup::$financial_request_table, 'WHERE id = :id', array('id' => $id));

		PersistenceContext::get_querier()->delete(DB_TABLE_EVENTS, 'WHERE module=:module AND id_in_module=:id', array('module' => 'financial', 'id' => $id));
    }

	/**
	 * @desc Return the content of an item.
	 * @param int $id Item identifier
	 */
	public static function get_item(int $id)
	{
		$row = self::$db_querier->select_single_row_query('SELECT *
		FROM ' . FinancialSetup::$financial_request_table . ' event
		LEFT JOIN ' . DB_TABLE_MEMBER . ' author ON author.user_id = event.author_user_id
		WHERE event.id = :id', array(
			'id' => $id
		));

		$item = new FinancialRequestItem();
		$item->set_properties($row);

		return $item;
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

    public static function accept_request($id, $amount_paid)
    {
        $now = new Date();
        self::$db_querier->update(
            FinancialSetup::$financial_request_table,
            array('agreement' => '4', 'agreement_date' => $now->get_timestamp()),
            'WHERE id=:id', array('id' => $id)
        );

        $budget = FinancialBudgetService::get_budget(self::get_item($id)->get_budget_id());
        $new_amount = $budget->get_annual_amount() - $amount_paid;
        $new_real_quant = $budget->get_real_quantity() - 1;
        self::$db_querier->update(
            FinancialSetup::$financial_budget_table,
            array('annual_amount' => $new_amount, 'real_quantity' => $new_real_quant),
            'WHERE id=:id', array('id' => $id)
        );
    }

    public static function reject_request($id)
    {
        $now = new Date();
        self::$db_querier->update(FinancialSetup::$financial_request_table, array('agreement' => '3', 'agreement_date' => $now->get_timestamp()), 'WHERE id=:id', array(
            'id' => $id
        ));

        $budget = FinancialBudgetService::get_budget(self::get_item($id)->get_budget_id());
        $new_temp_quant = $budget->get_temp_quantity() + 1;
        self::$db_querier->update(
            FinancialSetup::$financial_budget_table,
            array('temp_quantity' => $new_temp_quant),
            'WHERE id=:id', array('id' => $budget->get_id())
        );
    }

    public static function add_pending_request($id)
    {
        $budget = FinancialBudgetService::get_budget(self::get_item($id)->get_budget_id());
        $new_temp_quant = $budget->get_temp_quantity() - 1;
        self::$db_querier->update(
            FinancialSetup::$financial_budget_table,
            array('temp_quantity' => $new_temp_quant),
            'WHERE id=:id', array('id' => $budget->get_id())
        );
    }

    public static function delete_pending_request($id)
    {
        $budget = FinancialBudgetService::get_budget(self::get_item($id)->get_budget_id());
        $new_temp_quant = $budget->get_temp_quantity() + 1;
        self::$db_querier->update(
            FinancialSetup::$financial_budget_table,
            array('temp_quantity' => $new_temp_quant),
            'WHERE id=:id', array('id' => $budget->get_id())
        );
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