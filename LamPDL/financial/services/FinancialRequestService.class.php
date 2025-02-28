<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 18
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
     */
    public static function add_item(FinancialRequestItem $item)
    {
        $result = self::$db_querier->insert(FinancialSetup::$financial_request_table, $item->get_properties());

        return $result->get_last_inserted_id();
    }

    /** Update an item. */
    public static function update_item(FinancialRequestItem $item)
    {
        self::$db_querier->update(FinancialSetup::$financial_request_table, $item->get_properties(), 'WHERE id = :id', array(
            'id' => $item->get_id()
        ));
        return $item->get_id();
    }

    /** Delete an item. */
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

    /** Return the content of an item. */
    public static function get_item(int $id) : FinancialRequestItem
    {
        $row = self::$db_querier->select_single_row_query('SELECT *
		FROM ' . FinancialSetup::$financial_request_table . ' fr
		LEFT JOIN ' . DB_TABLE_MEMBER . ' author ON author.user_id = fr.author_user_id
		WHERE fr.id = :id', array(
            'id' => $id
        ));

        $item = new FinancialRequestItem();
        $item->set_properties($row);

        return $item;
    }

    public static function get_requests_users() : array
    {
        $result = self::$db_querier->select('SELECT *
		FROM `budgets`');
        foreach ($result as $row)
        {
            $budgets[] = $row;
        }
        return $budgets;
    }

    public static function get_user_requests($user_id) : array
    {
        $requests = [];
        $result = self::$db_querier->select('SELECT fr.*, member.*
            FROM ' . FinancialSetup::$financial_request_table . ' fr
			LEFT JOIN ' . DB_TABLE_MEMBER . ' member ON member.user_id = fr.author_user_id
            WHERE fr.author_user_id = ' . $user_id
        );
        foreach ($result as $row)
        {
            $requests[] = $row;
        }
        return $requests;
    }

    public static function get_club_requests($ffam_nb) : array
    {
        $requests = [];
        $club_id = LamclubsService::get_club_from_ffam($ffam_nb)->get_club_id();
        $result = self::$db_querier->select('SELECT fr.*
            FROM ' . FinancialSetup::$financial_request_table . ' fr
            WHERE fr.lamclubs_id = ' . $club_id
        );
        foreach ($result as $row)
        {
            $requests[] = $row;
        }
        return $requests;
    }

    /**
     * @desc Clears all module elements in cache.
     */
    public static function clear_cache() : void
    {
        Feed::clear_cache('financial');
    }

    public static function get_menu()
    {
        $view = new FileTemplate('financial/FinancialMenu.tpl');
        $view->add_lang(LangLoader::get_all_langs('financial'));

        $current_page = Url::to_rel('/financial' . AppContext::get_request()->get_value('url', ''));
        $current_user_id = AppContext::get_current_user()->get_id();

        $user_extended_fields = PersistenceContext::get_querier()->select_single_row(DB_TABLE_MEMBER_EXTENDED_FIELDS, ['f_votre_club'], 'WHERE user_id=:user_id', ['user_id' => $current_user_id]);
        $current_user_club = !empty($user_extended_fields) && $user_extended_fields['f_votre_club'] ? $user_extended_fields['f_votre_club'] : '';
        $current_user_club = explode(' - ', $current_user_club);
        $current_user_club = $current_user_club[0];

        $view->put_all([
            'C_HOME'              => FinancialUrlBuilder::home()->rel() === $current_page,
            'C_MY_CLUB_REQUESTS'  => FinancialUrlBuilder::display_club_items($current_user_club)->rel() == $current_page,
            'C_CLUB_HAS_REQUESTS' => count(self::get_club_requests($current_user_club)) > 0,
            'C_MY_REQUESTS'       => FinancialUrlBuilder::display_member_items($current_user_id)->rel() == $current_page,
            'C_USER_HAS_REQUESTS' => count(self::get_user_requests($current_user_id)) > 0,
            'C_ALL_REQUESTS'      => FinancialUrlBuilder::display_pending_items()->rel() === $current_page,
            'U_MY_CLUB_REQUESTS'  => FinancialUrlBuilder::display_club_items($current_user_club)->rel(),
            'U_MY_REQUESTS'       => FinancialUrlBuilder::display_member_items($current_user_id)->rel(),
            'U_ALL_REQUESTS'      => FinancialUrlBuilder::display_pending_items()->rel(),
            'U_HOME'              => FinancialUrlBuilder::home()->rel(),
        ]);

        return $view;
    }
}
?>