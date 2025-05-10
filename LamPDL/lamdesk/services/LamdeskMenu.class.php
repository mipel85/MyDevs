<?php
/**
 * @copyright   &copy; 2005-2024 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      mipel <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 22
 * @since       PHPBoost 6.0 - 2024 12 22
 */

class LamdeskMenu
{
    public static function get_menu()
    {
        $view = new FileTemplate('lamdesk/LamdeskMenu.tpl');
        $view->add_lang(LangLoader::get_all_langs('lamdesk'));
        $view->put_all(array(
            'U_HOME' => LamdeskUrlBuilder::tdb()->rel(),
        ));
        return $view;
    }
}
?>