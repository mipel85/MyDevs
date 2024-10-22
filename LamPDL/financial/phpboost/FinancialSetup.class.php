<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 10 17
 * @since       PHPBoost 6.0 - 2020 01 18
 */

class FinancialSetup extends DefaultModuleSetup
{
		public static $financial_request_table;
		public static $financial_budget_table;
		public static $financial_statement_view;

		public static function __static()
		{
				self::$financial_request_table = PREFIX . 'financial_request';
				self::$financial_budget_table = PREFIX . 'financial_budget';
				self::$financial_statement_view = 'statement_view';
		}

		public function install()
		{
				$this->drop_view();
				$this->drop_tables();
				$this->create_tables();
				$this->insert_data();
		}

		public function uninstall()
		{
				$this->drop_view();
				$this->drop_tables();
				ConfigManager::delete('financial', 'config');
		}

		private function drop_tables()
		{
				PersistenceContext::get_dbms_utils()->drop(array(self::$financial_request_table, self::$financial_budget_table));
		}

		private function drop_view()
		{
				PersistenceContext::get_querier()->select("DROP VIEW IF EXISTS " . self::$financial_statement_view);
		}

		private function create_tables()
		{
				$this->create_financial_request_table();
				$this->create_financial_budget_table();
				$this->create_financial_statement_view();
		}

		private function create_financial_request_table()
		{
				$fields = array(
						'id'								 => array('type' => 'integer', 'length' => 11, 'autoincrement' => true, 'notnull' => 1),
						'budget_id'					 => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
						'title'							 => array('type' => 'string', 'length' => 255, 'default' => "''"),
						'rewrited_title'		 => array('type' => 'string', 'length' => 255, 'default' => "''"),
						'author_user_id'		 => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
						'sender_name'				 => array('type' => 'string', 'length' => 255, 'notnull' => 1, 'default' => 0),
						'sender_email'			 => array('type' => 'string', 'length' => 255, 'notnull' => 1, 'default' => 0),
						'sender_description' => array('type' => 'text', 'length' => 16777215, 'notnull' => 0),
						'lamclubs_id'				 => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
						'event_date'				 => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
						'creation_date'			 => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
						'estimate_url'			 => array('type' => 'text', 'length' => 16777215, 'notnull' => 0),
						'invoice_url'				 => array('type' => 'text', 'length' => 16777215, 'notnull' => 0),
						'amount_paid'				 => array('type' => 'decimal', 'length' => 10, 'scale' => 2, 'notnull' => 0, 'default' => 0),
						'agreement'					 => array('type' => 'integer', 'length' => 1, 'notnull' => 1, 'default' => 0),
						'agreement_date'		 => array('type' => 'integer', 'length' => 11, 'notnull' => 0, 'default' => 0)
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
						'id'						=> array('type' => 'integer', 'length' => 11, 'autoincrement' => true, 'notnull' => 1),
						'domain'				=> array('type' => 'text', 'length' => 255),
						'name'					=> array('type' => 'text', 'length' => 255),
						'description'		=> array('type' => 'text', 'length' => 255),
						'fiscal_year'		=> array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
						'annual_amount' => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
						'real_amount'		=> array('type' => 'decimal', 'length' => 10, 'scale' => 2, 'notnull' => 1, 'default' => 0),
						'temp_amount'		=> array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
						'unit_amount'		=> array('type' => 'string', 'length' => 11, 'default' => "''"),
						'max_amount'		=> array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
						'quantity'			=> array('type' => 'integer', 'length' => 11, 'notnull' => 0, 'default' => 0),
						'real_quantity' => array('type' => 'integer', 'length' => 11, 'notnull' => 0, 'default' => 0),
						'temp_quantity' => array('type' => 'integer', 'length' => 11, 'notnull' => 0, 'default' => 0),
						'use_dl'				=> array('type' => 'boolean', 'notnull' => 0, 'default' => 0),
						'bill_needed'		=> array('type' => 'boolean', 'notnull' => 0, 'default' => 0),
				);
				$options = array(
						'primary' => array('id'),
						'indexes' => array(
								'name' => array('type' => 'fulltext', 'fields' => 'name')
						)
				);
				PersistenceContext::get_dbms_utils()->create_table(self::$financial_budget_table, $fields, $options);
		}

		public static function create_financial_statement_view()
		{

				$statement_view = '
        CREATE VIEW statement_view AS 
        SELECT fr.id, fb.domain AS Domaine, fr.title as `Type de demande`, lc.ffam_nb as `N° FFAM`, lc.name as Club, mem.display_name as Demandeur, fr.sender_description,
        FROM_UNIXTIME(fr.creation_date, "%d-%m-%Y") as Date_création,
        FROM_UNIXTIME(fr.event_date, "%d-%m-%Y") as Date_événement, fr.amount_paid as `Montant versé`, fb.annual_amount as `Budget prévu`, fb.annual_amount-fb.real_amount as `Budget dépensé`, fb.real_amount as `Budget restant`, fr.estimate_url as `lien devis`, fr.invoice_url as `lien facture`
        FROM `phpboost_financial_request` fr
        LEFT JOIN `phpboost_lamclubs` lc ON fr.lamclubs_id = lc.club_id
        LEFT JOIN `phpboost_member` mem ON fr.author_user_id = mem.user_id
        LEFT JOIN `phpboost_financial_budget` fb ON fr.budget_id = fb.id
        WHERE fr.amount_paid <> ""
        ORDER BY fb.domain, fr.title';

				PersistenceContext::get_querier()->select($statement_view);
		}

		private function insert_data()
		{
				$now = new Date();
				$file = PATH_TO_ROOT . '/financial/data/budgets.csv';
				if (($handle = fopen($file, 'r')) !== false)
				{
						fgetcsv($handle); // ignore first row
						while(($data = fgetcsv($handle, 1000, ';')) !== false)
						{
								PersistenceContext::get_querier()->insert(self::$financial_budget_table, array(
										'id'						=> $data[0],
										'domain'				=> $data[1],
										'name'					=> $data[2],
										'description'		=> $data[3],
										'fiscal_year'		=> $now->get_year(),
										'annual_amount' => $data[4],
										'real_amount'		=> $data[4],
										'temp_amount'		=> $data[4],
										'unit_amount'		=> $data[5],
										'max_amount'		=> $data[6],
										'quantity'			=> $data[7],
										'temp_quantity' => $data[7],
										'real_quantity' => $data[7],
										'use_dl'				=> $data[8],
										'bill_needed'		=> $data[9]
								));
						}
						fclose($handle);
				}else
				{
						echo '<div class="message-helper bgc-full error">Erreur lors de l\'ouverture du fichier CSV.</div>';
				}
		}
}
?>
