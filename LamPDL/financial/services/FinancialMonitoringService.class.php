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
            'WHERE id=:id', array('id' => $budget->get_id())
        );
        if ($budget->get_real_quantity())
        {
            $new_real_quant = $budget->get_real_quantity() - 1;
            self::$db_querier->update(
                FinancialSetup::$financial_budget_table,
                array('real_quantity' => $new_real_quant),
                'WHERE id=:id', array('id' => $budget->get_id())
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
            $unit_amount = $budget->get_unit_amount() !== '0€' && $budget->get_unit_amount() !== '0%' ? TextHelper::mb_substr($budget->get_unit_amount(), 0, -1) : 0;
            $new_temp_amount = $budget->get_temp_amount() + $unit_amount;
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
            $unit_amount = $budget->get_unit_amount() !== '0€' && $budget->get_unit_amount() !== '0%' ? TextHelper::mb_substr($budget->get_unit_amount(), 0, -1) : 0;
            $new_temp_amount = $budget->get_temp_amount() - $unit_amount;
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
            $unit_amount = $budget->get_unit_amount() !== '0€' && $budget->get_unit_amount() !== '0%' ? TextHelper::mb_substr($budget->get_unit_amount(), 0, -1) : 0;
            $new_temp_amount = $budget->get_temp_amount() + $unit_amount;
            self::$db_querier->update(
                FinancialSetup::$financial_budget_table,
                array('temp_amount' => $new_temp_amount),
                'WHERE id=:id', array('id' => $budget->get_id())
            );
        }
    }

    public static function change_fiscal_year($date)
    {
        // unset pending request in budget table
        $result_pending = self::$db_querier->select('SELECT *
            FROM ' . FinancialSetup::$financial_request_table . '
            WHERE agreement = 1 OR agreement = 2
        ');
        while ($row = $result_pending->fetch())
        {
            $item = new FinancialRequestItem();
            $item->set_properties($row);
            self::delete_pending_request($row['id']);
        }

        // Clone budget table to budget_($date - 1) table
        $new_table = PREFIX . 'financial_budget_' . FinancialBudgetService::get_current_fiscal_year();
        PersistenceContext::get_dbms_utils()->copy_table(FinancialSetup::$financial_budget_table, $new_table);

        // Reset budget table
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

        $result_pending = self::$db_querier->select('SELECT *
            FROM ' . FinancialSetup::$financial_request_table . '
            WHERE agreement = 1 OR agreement = 2
        ');
        // set old pending request to new budget table and rename title
        while ($row = $result_pending->fetch())
        {
            $item = new FinancialRequestItem();
            $item->set_properties($row);
            // add pending item to budget
            self::add_pending_request($item->get_id());
            // rename
            $budget = FinancialBudgetService::get_budget(self::get_item($item->get_id())->get_budget_id());
            $new_title = $budget->get_name() . ' - ' . $date;
            self::$db_querier->update(FinancialSetup::$financial_request_table, array('title' => $new_title, 'rewrited_title' => Url::encode_rewrite($new_title)), 'WHERE id = :id', array(
                'id' => $item->get_id()
            ));
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