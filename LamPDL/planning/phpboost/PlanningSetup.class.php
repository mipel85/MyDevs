<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 02 27
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class PlanningSetup extends DefaultModuleSetup
{
	public static $planning_table;
	public static $planning_cats_table;

	public static function __static()
	{
		self::$planning_table = PREFIX . 'planning';
		self::$planning_cats_table = PREFIX . 'planning_cats';
	}

	public function install()
	{
		$this->drop_tables();
		$this->create_tables();
		$this->insert_cats_data();
	}

	public function uninstall()
	{
		$this->drop_tables();
		ConfigManager::delete('planning', 'config');
	}

	private function drop_tables()
	{
		PersistenceContext::get_dbms_utils()->drop(array(self::$planning_table, self::$planning_cats_table));
	}

	private function create_tables()
	{
		$this->create_planning_table();
		$this->create_planning_cats_table();
	}

	private function create_planning_table()
	{
		$fields = array(
			'id' => array('type' => 'integer', 'length' => 11, 'autoincrement' => true, 'notnull' => 1),
			'lamclubs_id' => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
			'id_category' => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
			'activity_other' => array('type' => 'string', 'length' => 150, 'notnull' => 0, 'default' => "''"),
			'rewrited_link' => array('type' => 'string', 'length' => 250, 'default' => "''"),
			'start_date' => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
			'end_date_enabled' => array('type' => 'boolean', 'notnull' => 1, 'default' => 0),
			'end_date' => array('type' => 'integer', 'length' => 11, 'notnull' => 0, 'default' => 0),
			'author_user_id' => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
			'email' => array('type' => 'string', 'length' => 50, 'notnull' => 1, 'default' => "''"),
			'creation_date' => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
			'update_date' => array('type' => 'integer', 'length' => 11, 'notnull' => 1, 'default' => 0),
			'cancelled' => array('type' => 'boolean', 'notnull' => 1, 'default' => 0),
			'approved' => array('type' => 'boolean', 'notnull' => 1, 'default' => 0),

            'more_infos' => array('type' => 'string', 'length' => 255, 'notnull' => 1, 'default' => "''"),
			'phone' => array('type' => 'string', 'length' => 10, 'notnull' => 0, 'default' => "''"),
			'website_url' => array('type' => 'string', 'length' => 255, 'notnull' => 0, 'default' => "''"),
			'thumbnail_url' => array('type' => 'string', 'length' => 255, 'notnull' => 0, 'default' => "''"),
			'content' => array('type' => 'text', 'length' => 65000, 'notnull' => 0),
			'location' => array('type' => 'text', 'length' => 65000, 'notnull' => 0),
			'map_displayed' => array('type' => 'boolean', 'notnull' => 0, 'default' => 0)
		);
		$options = array(
			'primary' => array('id'),
			'indexes' => array(
				'id_category' => array('type' => 'key', 'fields' => 'id_category')
			)
		);
		PersistenceContext::get_dbms_utils()->create_table(self::$planning_table, $fields, $options);
	}

	private function create_planning_cats_table()
	{
		Category::create_categories_table(self::$planning_cats_table);
	}

	private function insert_cats_data()
	{
        $lang = LangLoader::get('install', 'planning');
		PersistenceContext::get_querier()->insert(self::$planning_cats_table, array(
			'id'            => 1,
			'id_parent'     => 0,
			'c_order'       => 1,
			'auth'          => '',
			'special_authorizations' => 0,
			'rewrited_name' => Url::encode_rewrite($lang['planning.category.1']),
			'name'          => $lang['planning.category.1'],
			'auth'          => '',
			'special_authorizations' => 0
		));
		PersistenceContext::get_querier()->insert(self::$planning_cats_table, array(
			'id'            => 2,
			'id_parent'     => 0,
			'c_order'       => 2,
			'auth'          => '',
			'special_authorizations' => 0,
			'rewrited_name' => Url::encode_rewrite($lang['planning.category.2']),
			'name'          => $lang['planning.category.2'],
			'auth'          => '',
			'special_authorizations' => 0
		));
		PersistenceContext::get_querier()->insert(self::$planning_cats_table, array(
			'id'            => 3,
			'id_parent'     => 0,
			'c_order'       => 3,
			'auth'          => '',
			'special_authorizations' => 0,
			'rewrited_name' => Url::encode_rewrite($lang['planning.category.3']),
			'name'          => $lang['planning.category.3'],
			'auth'          => '',
			'special_authorizations' => 0
		));
		PersistenceContext::get_querier()->insert(self::$planning_cats_table, array(
			'id'            => 4,
			'id_parent'     => 0,
			'c_order'       => 4,
			'auth'          => '',
			'special_authorizations' => 0,
			'rewrited_name' => Url::encode_rewrite($lang['planning.category.4']),
			'name'          => $lang['planning.category.4'],
			'auth'          => '',
			'special_authorizations' => 0
		));
		PersistenceContext::get_querier()->insert(self::$planning_cats_table, array(
			'id'            => 5,
			'id_parent'     => 0,
			'c_order'       => 5,
			'auth'          => '',
			'special_authorizations' => 0,
			'rewrited_name' => Url::encode_rewrite($lang['planning.category.5']),
			'name'          => $lang['planning.category.5'],
			'auth'          => '',
			'special_authorizations' => 0
		));
	}
}
?>
