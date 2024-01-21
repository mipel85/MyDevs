<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class PlanningService
{
	private static $db_querier;

	public static function __static()
	{
		self::$db_querier = PersistenceContext::get_querier();
	}

	/**
	 * @desc Create a new item.
	 * @param PlanningItem $item new PlanningItem
	 */
	public static function add_item(PlanningItem $item)
	{
		$result = self::$db_querier->insert(PlanningSetup::$planning_table, $item->get_properties());

		return $result->get_last_inserted_id();
	}

	/**
	 * @desc Update an item.
	 * @param PlanningItem $item PlanningItem to update
	 */
	public static function update_item(PlanningItem $item)
	{
		self::$db_querier->update(PlanningSetup::$planning_table, $item->get_properties(), 'WHERE id = :id', array(
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

		self::$db_querier->delete(PlanningSetup::$planning_table, 'WHERE id = :id', array('id' => $id));

		PersistenceContext::get_querier()->delete(DB_TABLE_EVENTS, 'WHERE module=:module AND id_in_module=:id', array('module' => 'planning', 'id' => $id));
    }

	/**
	 * @desc Return the content of an item.
	 * @param int $id Item identifier
	 */
	public static function get_item(int $id)
	{
		$row = self::$db_querier->select_single_row_query('SELECT *
		FROM ' . PlanningSetup::$planning_table . ' event
		LEFT JOIN ' . DB_TABLE_MEMBER . ' author ON author.user_id = event.author_user_id
		WHERE event.id = :id', array(
			'id' => $id
		));

		$item = new PlanningItem();
		$item->set_properties($row);

		return $item;
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

	/**
	 * @desc Clears all module elements in cache.
	 */
	public static function clear_cache()
	{
		Feed::clear_cache('planning');
		PlanningCache::invalidate();
	}

	/**
	 * @desc Return all the items of the requested month.
	 * @param int $month Month of the request
	 * @param int $year Year of the request
	 * @param int $month_days Number of days in the requested month
	 */
	public static function get_all_current_month_items($month, $year, $month_days, $id_category = Category::ROOT_CATEGORY)
	{
		$items = array();
		$authorized_categories = $id_category == Category::ROOT_CATEGORY ? CategoriesService::get_authorized_categories($id_category) : array($id_category);

		$first_month_day = DateTime::createFromFormat('Y-m-d H:i:s', $year . '-' . $month . '-' . 1 . ' 00:00:00', Timezone::get_timezone(Timezone::USER_TIMEZONE));
		$last_month_day = DateTime::createFromFormat('Y-m-d H:i:s', $year . '-' . $month . '-' . $month_days . ' 23:59:59', Timezone::get_timezone(Timezone::USER_TIMEZONE));
		$result = self::$db_querier->select((PlanningConfig::load()->is_members_birthday_enabled() ? "
		(SELECT member_extended_fields.user_born AS start_date, member_extended_fields.user_born AS end_date, display_name AS title, 'BIRTHDAY' AS type, 0 AS id_category
		FROM " . DB_TABLE_MEMBER . " member
		LEFT JOIN " . DB_TABLE_MEMBER_EXTENDED_FIELDS . " member_extended_fields ON member_extended_fields.user_id = member.user_id
		WHERE member_extended_fields.user_born <> '' AND IF(member_extended_fields.user_born < 0, MONTH(DATE_ADD(FROM_UNIXTIME(0), INTERVAL member_extended_fields.user_born second)), MONTH(FROM_UNIXTIME(member_extended_fields.user_born))) = :month AND :year > IF(member_extended_fields.user_born < 0, YEAR(DATE_ADD(FROM_UNIXTIME(0), INTERVAL member_extended_fields.user_born second)), YEAR(FROM_UNIXTIME(member_extended_fields.user_born))))
		UNION
		" : "") . "(SELECT start_date, end_date, title, 'EVENT' AS type, id_category
		FROM " . PlanningSetup::$planning_table . " event
		WHERE approved = 1
		AND ((start_date BETWEEN :first_month_day AND :last_month_day) OR (end_date BETWEEN :first_month_day AND :last_month_day) OR (:first_month_day BETWEEN start_date AND end_date))
		AND id_category IN :authorized_categories)
		ORDER BY type ASC, start_date ASC", array(
			'month' => $month,
			'year' => $year,
			'first_month_day' => $first_month_day->getTimestamp(),
			'last_month_day' => $last_month_day->getTimestamp(),
			'authorized_categories' => $authorized_categories
		));

		while ($row = $result->fetch())
		{
			$items[] = $row;
		}
		$result->dispose();

		return $items;
	}
}
?>
