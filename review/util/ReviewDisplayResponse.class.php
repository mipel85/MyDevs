<?php
/**
 * @copyright   &copy; 2022 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel <mipel@gmail.com>
 * @version     PHPBoost 6.0 - last update: 2022 01 05
 * @since       PHPBoost 6.0 - 2022 01 10
 */
class ReviewDisplayResponse extends AdminMenuDisplayResponse
{

    public function __construct($view, $title_page)
    {
        parent::__construct($view);

        $lang = LangLoader::get_all_langs('review');
        $this->set_title($lang['review.module.title']);

        $env = $this->get_graphical_environment();
        $env->set_page_title($title_page);
    }

}

?>
