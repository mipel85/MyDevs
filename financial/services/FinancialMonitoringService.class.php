<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class FinancialMonitoringService
{
	private static $db_querier;

	public static function __static()
	{
		self::$db_querier = PersistenceContext::get_querier();
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

    public static function request_payment($id, $amount_paid)
    {
        $now = new Date();
        self::$db_querier->update(
            FinancialSetup::$financial_request_table,
            array('amount_paid' => $amount_paid, 'agreement' => FinancialRequestItem::ACCEPTED, 'agreement_date' => $now->get_timestamp()),
            'WHERE id=:id', array('id' => $id)
        );

        $budget = FinancialBudgetService::get_budget(self::get_item($id)->get_budget_id());
        $new_amount = $budget->get_real_amount() - $amount_paid;
        self::$db_querier->update(
            FinancialSetup::$financial_budget_table,
            array('real_amount' => $new_amount),
            'WHERE id=:id', array('id' => $id)
        );
        if ($budget->get_real_quantity())
        {
            $new_real_quant = $budget->get_real_quantity() - 1;
            self::$db_querier->update(
                FinancialSetup::$financial_budget_table,
                array('real_quantity' => $new_real_quant),
                'WHERE id=:id', array('id' => $id)
            );
        }
    }

    public static function request_rejection($id)
    {
        $now = new Date();
        self::$db_querier->update(
            FinancialSetup::$financial_request_table,
            array('agreement' => FinancialRequestItem::REJECTED, 'agreement_date' => $now->get_timestamp()),
            'WHERE id=:id', array('id' => $id)
        );

        $budget = FinancialBudgetService::get_budget(self::get_item($id)->get_budget_id());
        if ($budget->get_temp_quantity())
        {
            $new_temp_quant = $budget->get_temp_quantity() + 1;
            self::$db_querier->update(
                FinancialSetup::$financial_budget_table,
                array('temp_quantity' => $new_temp_quant),
                'WHERE id=:id', array('id' => $budget->get_id())
            );
        }
        if (!$budget->get_use_dl())
        {
            $new_temp_amount = $budget->get_temp_amount() + $budget->get_unit_amount();
            self::$db_querier->update(
                FinancialSetup::$financial_budget_table,
                array('temp_amount' => $new_temp_amount),
                'WHERE id=:id', array('id' => $budget->get_id())
            );
        }
    }

    public static function set_request_ongoing($id)
    {
        self::$db_querier->update(
            FinancialSetup::$financial_request_table,
            array('agreement' => FinancialRequestItem::ONGOING),
            'WHERE id=:id', array('id' => $id)
        );
    }

    public static function add_pending_request($id)
    {
        $budget = FinancialBudgetService::get_budget(self::get_item($id)->get_budget_id());
        if ($budget->get_temp_quantity())
        {
            $new_temp_quant = $budget->get_temp_quantity() - 1;
            self::$db_querier->update(
                FinancialSetup::$financial_budget_table,
                array('temp_quantity' => $new_temp_quant),
                'WHERE id=:id', array('id' => $budget->get_id())
            );
        }
        if (!$budget->get_use_dl())
        {
            $new_temp_amount = $budget->get_temp_amount() - $budget->get_unit_amount();
            self::$db_querier->update(
                FinancialSetup::$financial_budget_table,
                array('temp_amount' => $new_temp_amount),
                'WHERE id=:id', array('id' => $budget->get_id())
            );
        }
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
        if (!$budget->get_use_dl())
        {
            $new_temp_amount = $budget->get_temp_amount() + $budget->get_unit_amount();
            self::$db_querier->update(
                FinancialSetup::$financial_budget_table,
                array('temp_amount' => $new_temp_amount),
                'WHERE id=:id', array('id' => $budget->get_id())
            );
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