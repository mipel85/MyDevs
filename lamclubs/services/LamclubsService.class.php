<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2024 01 18
*/

class LamclubsService
{
	private static $db_querier;
	protected static $module_id = 'lamclubs';

	public static function __static()
	{
		self::$db_querier = PersistenceContext::get_querier();
	}

    /**
	 * @desc Count items number.
	 * @param string $condition (optional) : Restriction to apply to the list of items
	 */
	public static function count($condition = '', $parameters = array())
	{
		return self::$db_querier->count(LamclubsSetup::$lamclubs_table, $condition, $parameters);
	}

    /**
	 * @desc Create a new entry in the database table.
	 * @param LamclubsItem $item : new LamclubsItem
	 */
	public static function add(LamclubsItem $item)
	{
		$result = self::$db_querier->insert(LamclubsSetup::$lamclubs_table, $item->get_properties());

		return $result->get_last_inserted_id();
	}

    /**
	 * @desc Update an entry.
	 * @param LamclubsItem $item : Item to update
	 */
	public static function update(LamclubsItem $item)
	{
		self::$db_querier->update(LamclubsSetup::$lamclubs_table, $item->get_properties(), 'WHERE club_id = :club_id', array('club_id' => $item->get_club_id()));
	}

    /**
	 * @desc Delete an entry.
	 * @param string $condition : Restriction to apply to the list
	 * @param string[] $parameters : Parameters of the condition
	 */
	public static function delete(int $club_id)
	{
		if (AppContext::get_current_user()->is_readonly())
        {
            $controller = PHPBoostErrors::user_in_read_only();
            DispatchManager::redirect($controller);
        }
			self::$db_querier->delete(LamclubsSetup::$lamclubs_table, 'WHERE club_id = :club_id', array('club_id' => $club_id));

			self::$db_querier->delete(DB_TABLE_EVENTS, 'WHERE module=:module AND id_in_module = :club_id', array('module' => 'lamclubs', 'club_id' => $club_id));
	}

    /**
	 * @desc Return the properties of an item.
	 * @param string $condition : Restriction to apply to the list
	 * @param string[] $parameters : Parameters of the condition
	 */
	public static function get_item(int $club_id)
	{
		$row = self::$db_querier->select_single_row_query('SELECT ' . self::$module_id . '.*
		FROM ' . LamclubsSetup::$lamclubs_table . ' ' . self::$module_id . '
		WHERE ' . self::$module_id . '.club_id = :club_id', array(
			'club_id'              => $club_id,
			'current_user_id' => AppContext::get_current_user()->get_id()
		));

		$item = new LamclubsItem();
		$item->set_properties($row);
		return $item;
	}

    public static function get_items_list()
    {
        $req = self::$db_querier->select('SELECT *
		FROM ' . LamclubsSetup::$lamclubs_table);
        while($row = $req->fetch())
        {
            $items[] = $row;
        }
        return $items;
        $req->dispose();
    }

    public static function get_options_list()
	{
		$options = array();
		$clubs_list = self::get_items_list();
		// laisser un vide en début de liste
		$options[] = new FormFieldSelectChoiceOption('', '');

		$i = 1;
		foreach($clubs_list as $values)
		{
			$options[] = new FormFieldSelectChoiceOption($values['ffam_nb'] . ' - ' . $values['department'] . ' - ' . $values['name'], $values['club_id']);
			$i++;
		}

		return $options;
	}

    /**
	 * @desc Return the properties of an item.
	 * @param string $condition : Restriction to apply to the list
	 * @param string[] $parameters : Parameters of the condition
	 */
	public static function get_user_club(int $user_id)
	{
		$result_ext = self::$db_querier->select_single_row_query('SELECT ext.*
            FROM ' . DB_TABLE_MEMBER_EXTENDED_FIELDS . ' ext
            WHERE ext.user_id = ' . $user_id
        );
        $club = $result_ext['f_votre_club'];
        $user_club = explode(' - ', $club);
        $user_ffam_nb = $user_club[0];

        $result_club = self::$db_querier->select_single_row_query('SELECT club.*
            FROM ' . LamclubsSetup::$lamclubs_table . ' club
            WHERE club.ffam_nb = ' . $user_ffam_nb
        );
        return $result_club['club_id'];
	}
}
?>
