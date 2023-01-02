<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Mipel85 <mipel85@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2022 12 27
 * @since       PHPBoost 6.0 - 2022 12 20
*/

class LamDisplayResponse extends AdminMenuDisplayResponse
{
	public function __construct($view, $title_page)
	{
		parent::__construct($view);
		
		$lang = LangLoader::get('common', 'Lam');
		$this->set_title($lang['Lam']);
		
		$env = $this->get_graphical_environment();
		$env->set_page_title($title_page, $lang['Lam']);
//        $this->add_link('add', LamUrlBuilder::add_item());
	}
}
?>
