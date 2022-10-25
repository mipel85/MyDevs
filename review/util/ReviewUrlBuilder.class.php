<?php
/**
 * @copyright   &copy; 2022 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel <mipel@gmail.com>
 * @version     PHPBoost 6.0 - last update: 2022 01 05
 * @since       PHPBoost 6.0 - 2022 01 10
 */
class ReviewUrlBuilder
{
    private static $dispatcher = '/review';

    /**
     * @return Url
     */
    public static function home($section = '')
    {
        $section = !empty($section) ? $section . '/' : '';
        return DispatchManager::get_url(self::$dispatcher, '/' . $section);
    }

    /**
     * @return Url
     */
    public static function documentation()
    {
        return new Url(ModulesManager::get_module('review')->get_configuration()->get_documentation());
    }
}
?>

