<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2022 12 27
 * @since       PHPBoost 6.0 - 2022 12 20
 */
class LamTreeLinks extends DefaultTreeLinks
{
    protected function get_module_additional_actions_tree_links(&$tree)
    {
        $module_id = 'Lam';
        $lang = LangLoader::get_all_langs($module_id);
//		$current_user = AppContext::get_current_user()->get_id();
        $tree->add_link(new ModuleLink($lang['lam.stats'], LamUrlBuilder::stats()));
    }
}
?>
