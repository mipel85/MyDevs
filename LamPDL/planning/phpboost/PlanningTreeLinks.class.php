<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 01 20
 * @since       PHPBoost 6.0 - 2020 01 18
*/

class PlanningTreeLinks extends DefaultTreeLinks
{
	public function __construct()
	{
		parent::__construct('planning');
	}

	protected function get_module_additional_items_actions_tree_links(&$tree)
	{
		$current_user = AppContext::get_current_user()->get_id();
		$module_id = 'planning';
		$lang = LangLoader::get_all_langs($module_id);

		$tree->add_link(new ModuleLink($lang['planning.my.items'], PlanningUrlBuilder::display_member_items($current_user), CategoriesAuthorizationsService::check_authorizations(Category::ROOT_CATEGORY, $module_id)->write() || CategoriesAuthorizationsService::check_authorizations(Category::ROOT_CATEGORY, $module_id)->contribution() || CategoriesAuthorizationsService::check_authorizations(Category::ROOT_CATEGORY, $module_id)->moderation()));
	}
}
?>
