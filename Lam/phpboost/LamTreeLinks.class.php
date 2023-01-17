<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2023 01 23
 * @since       PHPBoost 6.0 - 2022 12 20
 */

class LamTreeLinks extends DefaultTreeLinks
{

    protected function get_module_additional_actions_tree_links(&$tree)
    {
        $module_id = 'Lam';
        $lang = LangLoader::get_all_langs($module_id);
        $tree->add_link(new ModuleLink($lang['lam.activity.requests'], LamUrlBuilder::activity_manager(), AppContext::get_current_user()->check_level(User::ADMINISTRATOR_LEVEL) || !AppContext::get_current_user()->check_level(User::VISITOR_LEVEL) || AppContext::get_current_user()->get_groups()[1] == 1));
    }
}
?>
