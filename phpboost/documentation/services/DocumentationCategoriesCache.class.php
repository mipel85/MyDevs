<?php
/**
 * @copyright   &copy; 2005-2022 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2022 11 18
 * @since       PHPBoost 6.0 - 2022 11 18
 */

class DocumentationCategoriesCache extends DefaultRichCategoriesCache
{
	public function get_module_identifier()
	{
		return 'documentation';
	}

	protected function get_category_elements_number($id_category)
	{
		$now = new Date();
		return DocumentationService::count('WHERE id_category = :id_category AND (published = 1 OR (published = 2 AND publishing_start_date < :timestamp_now AND (publishing_end_date > :timestamp_now OR publishing_end_date = 0)))',
			array(
				'timestamp_now' => $now->get_timestamp(),
				'id_category' => $id_category
			)
		);
	}

	protected function get_root_category_authorizations()
	{
		return DocumentationConfig::load()->get_authorizations();
	}
	
	protected function get_root_category_description()
	{
		$description = DocumentationConfig::load()->get_root_category_description();
		if (empty($description))
			$description = StringVars::replace_vars(LangLoader::get_message('documentation.seo.description.root', 'common', 'documentation'), array('site' => GeneralConfig::load()->get_site_name()));
		return $description;
	}
}
?>
