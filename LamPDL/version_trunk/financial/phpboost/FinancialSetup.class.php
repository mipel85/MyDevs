<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 11
 * @since       PHPBoost 6.0 - 2020 01 18
 */

class FinancialSetup extends DefaultModuleSetup
{
    public static $financial_request_table;
    public static $financial_budget_table;

    public static function __static()
    {
        self::$financial_request_table = PREFIX . 'financial_request';
        self::$financial_budget_table = PREFIX . 'financial_budget';
    }

    public function install()
    {
        $this->drop_tables();
        $this->create_tables();
        $this->insert_data();
    }

    public function uninstall()
    {
        $this->drop_tables();
        ConfigManager::delete('financial', 'config');
    }

    private function drop_tables()
    {
        $financial_tables = PersistenceContext::get_dbms_utils()->list_module_tables('financial_');
        if ($financial_tables)
        { 
            PersistenceContext::get_dbms_utils()->drop($financial_tables);
        }
    }

    private function create_tables()
    {
        $this->create_financial_request_table();
        $this->create_financial_budget_table();
    }

    private function create_financial_request_table()
    {
        $fields = array(
            'id'                  => array('type' => 'integer', 'length' => 11, 'autoincrement' => true, 'notnull' => 1),
            'budget_id'           => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
            'request_type'        => array('type' => 'string', 'length' => 255, 'default' => "''"),
            'rewrited_type'       => array('type' => 'string', 'length' => 255, 'default' => "''"),
            'author_user_id'      => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
            'sender_name'         => array('type' => 'string', 'length' => 255, 'notnull' => 1, 'default' => 0),
            'sender_email'        => array('type' => 'string', 'length' => 255, 'notnull' => 1, 'default' => 0),
            'request_description' => array('type' => 'text', 'length' => 16777215, 'notnull' => 0),
            'lamclubs_id'         => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
            'event_date'          => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
            'creation_date'       => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
            'estimate_url'        => array('type' => 'text', 'length' => 16777215, 'notnull' => 0),
            'invoice_url'         => array('type' => 'text', 'length' => 16777215, 'notnull' => 0),
            'amount_paid'         => array('type' => 'decimal', 'length' => 10, 'scale' => 2, 'notnull' => 0, 'default' => 0),
            'agreement'           => array('type' => 'integer', 'length' => 1, 'notnull' => 1, 'default' => 0),
            'agreement_date'      => array('type' => 'integer', 'length' => 11, 'notnull' => 0, 'default' => 0)
        );
        $options = array(
            'primary' => array('id'),
            'indexes' => array(
                'budget_id' => array('type' => 'key', 'fields' => 'budget_id')
            )
        );
        PersistenceContext::get_dbms_utils()->create_table(self::$financial_request_table, $fields, $options);
    }

    private function create_financial_budget_table()
    {
        $fields = array(
            'id'                 => array('type' => 'integer', 'length' => 11, 'autoincrement' => true, 'notnull' => 1),
            'budget_domain'      => array('type' => 'text', 'length' => 255),
            'budget_type'        => array('type' => 'text', 'length' => 255),
            'budget_description' => array('type' => 'text', 'length' => 255),
            'fiscal_year'        => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
            'annual_amount'      => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
            'real_amount'        => array('type' => 'decimal', 'length' => 10, 'scale' => 2, 'notnull' => 1, 'default' => 0),
            'temp_amount'        => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
            'unit_amount'        => array('type' => 'string', 'length' => 11, 'default' => "''"),
            'max_amount'         => array('type' => 'string', 'length' => 11, 'default' => "''"),
            'quantity'           => array('type' => 'integer', 'length' => 11, 'notnull' => 0, 'default' => 0),
            'real_quantity'      => array('type' => 'integer', 'length' => 11, 'notnull' => 0, 'default' => 0),
            'temp_quantity'      => array('type' => 'integer', 'length' => 11, 'notnull' => 0, 'default' => 0),
            'use_dl'             => array('type' => 'boolean', 'notnull' => 0, 'default' => 0),
            'bill_needed'        => array('type' => 'boolean', 'notnull' => 0, 'default' => 0),
        );
        $options = array(
            'primary' => array('id'),
            'indexes' => array(
                'name' => array('type' => 'fulltext', 'fields' => 'budget_type')
            )
        );
        PersistenceContext::get_dbms_utils()->create_table(self::$financial_budget_table, $fields, $options);
    }

    private function insert_data()
    {
        $now = new Date();
        $file = PATH_TO_ROOT . '/financial/data/budgets.csv';
        if (($handle = fopen($file, 'r')) !== false) {
            fgetcsv($handle); // ignore first row
            while (($data = fgetcsv($handle, 1000, ';')) !== false) {
                PersistenceContext::get_querier()->insert(self::$financial_budget_table, array(
                    'id'                 => $data[0],
                    'budget_domain'      => $data[1],
                    'budget_type'        => $data[2],
                    'budget_description' => $data[3],
                    'fiscal_year'        => $now->get_year(),
                    'annual_amount'      => $data[4],
                    'real_amount'        => $data[4],
                    'temp_amount'        => $data[4],
                    'unit_amount'        => $data[5],
                    'max_amount'         => $data[6],
                    'quantity'           => $data[7],
                    'temp_quantity'      => $data[7],
                    'real_quantity'      => $data[7],
                    'use_dl'             => $data[8],
                    'bill_needed'        => $data[9]
                ));
            }
            fclose($handle);
        } else {
            echo '<div class="message-helper bgc-full error">Erreur lors de l\'ouverture du fichier CSV.</div>';
        }
    }
}
