<?php
/**
 * @package     Content
 * @subpackage  Category\controllers
 * @copyright   &copy; 2005-2020 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Kevin MASSY <reidlos@phpboost.com>
 * @version     PHPBoost 5.3 - last update: 2020 02 28
 * @since       PHPBoost 4.0 - 2013 02 06
 * @contributor Julien BRISWALTER <j1.seth@phpboost.com>
 * @contributor Arnaud GENET <elenwii@phpboost.com>
 * @contributor mipel <mipel@phpboost.com>
*/

abstract class AbstractCategoriesFormController extends ModuleController
{
	/**
	 * @var HTMLForm
	 */
	protected $form;
	/**
	 * @var FormButtonSubmit
	 */
	protected $submit_button;

	protected static $lang;
	protected static $common_lang;
	protected static $categories_manager;

	/**
	 * @var Category
	 */
	private $category;
	protected $is_new_category;

	public static function __static()
	{
		self::$lang = LangLoader::get('categories-common');
		self::$common_lang = LangLoader::get('common');
	}

	public function execute(HTTPRequestCustom $request)
	{
		$class_name = get_called_class();
		self::$categories_manager = $class_name::get_categories_manager();
		
		$this->check_authorizations();
		$this->build_form($request);

		$tpl = new StringTemplate('# INCLUDE FORM #');
		$tpl->add_lang(self::$lang);

		if ($this->submit_button->has_been_submited() && $this->form->validate())
		{
			$this->set_properties();
			$this->save();
			if ($this->is_new_category)
				AppContext::get_response()->redirect($this->get_categories_management_url(), StringVars::replace_vars($this->get_success_message(), array('name' => $this->get_category()->get_name())));
			else
				AppContext::get_response()->redirect($this->form->get_value('referrer') ? $this->form->get_value('referrer') : $this->get_categories_management_url(), StringVars::replace_vars($this->get_success_message(), array('name' => $this->get_category()->get_name())));
		}

		$tpl->put('FORM', $this->form->display());

		return $this->generate_response($tpl);
	}

	protected function build_form(HTTPRequestCustom $request)
	{
		$form = new HTMLForm(__CLASS__);

		$fieldset = new FormFieldsetHTML('category', $this->get_title());
		$form->add_fieldset($fieldset);

		$fieldset->add_field(new FormFieldTextEditor('name', self::$common_lang['form.name'], $this->get_category()->get_name(), array('required' => true)));

		$fieldset->add_field(new FormFieldCheckbox('personalize_rewrited_name', self::$common_lang['form.rewrited_name.personalize'], $this->get_category()->rewrited_name_is_personalized(), array(
		'events' => array('click' => '
		if (HTMLForms.getField("personalize_rewrited_name").getValue()) {
			HTMLForms.getField("rewrited_name").enable();
		} else {
			HTMLForms.getField("rewrited_name").disable();
		}'
		))));

		$fieldset->add_field(new FormFieldTextEditor('rewrited_name', self::$common_lang['form.rewrited_name'], $this->get_category()->get_rewrited_name(), array(
			'description' => self::$common_lang['form.rewrited_name.description'],
			'hidden' => !$this->get_category()->rewrited_name_is_personalized()
		), array(new FormFieldConstraintRegex('`^[a-z0-9\-]+$`iu'))));

		if ($this->get_category()->is_allowed_to_have_childs())
		{
			$search_category_children_options = new SearchCategoryChildrensOptions();

			if ($this->get_category()->get_id())
				$search_category_children_options->add_category_in_excluded_categories($this->get_category()->get_id());

			$fieldset->add_field(self::$categories_manager->get_select_categories_form_field('id_parent', self::$common_lang['form.category'], $this->get_category()->get_id_parent(), $search_category_children_options));
		}

		$this->build_fieldset_options($form);

		$fieldset_authorizations = new FormFieldsetHTML('authorizations_fieldset', self::$common_lang['authorizations']);
		$form->add_fieldset($fieldset_authorizations);

		$root_auth = self::$categories_manager->get_categories_cache()->get_category(Category::ROOT_CATEGORY)->get_authorizations();

		$fieldset_authorizations->add_field(new FormFieldCheckbox('special_authorizations', self::$common_lang['authorizations'], !$this->get_category()->auth_is_equals($root_auth),
		array('description' => self::$lang['category.form.authorizations.description'], 'events' => array('click' => '
		if (HTMLForms.getField("special_authorizations").getValue()) {
			jQuery("#' . __CLASS__ . '_authorizations").show();
		} else {
			jQuery("#' . __CLASS__ . '_authorizations").hide();
		}')
		)));

		$auth_settings = new AuthorizationsSettings(self::get_authorizations_settings());
		$auth_settings->build_from_auth_array($this->get_category()->get_authorizations());
		$fieldset_authorizations->add_field(new FormFieldAuthorizationsSetter('authorizations', $auth_settings, array('hidden' => $this->get_category()->auth_is_equals($root_auth))));

		$fieldset->add_field(new FormFieldHidden('referrer', $request->get_url_referrer()));

		$this->submit_button = new FormButtonDefaultSubmit();
		$form->add_button($this->submit_button);
		$form->add_button(new FormButtonReset());

		$this->form = $form;
	}

	protected function set_properties()
	{
		$this->get_category()->set_name($this->form->get_value('name'));
		$rewrited_name = $this->form->get_value('rewrited_name', '');
		$rewrited_name = $this->form->get_value('personalize_rewrited_name') && !empty($rewrited_name) ? $rewrited_name : Url::encode_rewrite($this->get_category()->get_name());
		$this->get_category()->set_rewrited_name($rewrited_name);
		if ($this->get_category()->is_allowed_to_have_childs() && $this->form->get_value('id_parent'))
			$this->get_category()->set_id_parent($this->form->get_value('id_parent')->get_raw_value());
		else
			$this->get_category()->set_id_parent(Category::ROOT_CATEGORY);

		if ($this->form->get_value('special_authorizations'))
		{
			$this->get_category()->set_special_authorizations(true);
			$autorizations = $this->form->get_value('authorizations')->build_auth_array();
		}
		else
		{
			$this->get_category()->set_special_authorizations(false);
			$autorizations = array();
		}

		$this->get_category()->set_authorizations($autorizations);
		
		foreach ($this->get_category()->get_additional_attributes_list() as $id => $attribute)
		{
			$value = (isset($attribute['attribute_field_parameters']) && preg_match('/Choice/', $attribute['attribute_field_parameters']['field_class'])) ? $this->form->get_value($id)->get_raw_value() : $this->form->get_value($id);
			if ($attribute['is_url'])
				$value = new Url($value);
			
			$this->get_category()->set_additional_property($id, $value);
		}
	}

	private function build_fieldset_options(HTMLForm $form)
	{
		$fieldset = new FormFieldsetHTML('options_fieldset', LangLoader::get_message('form.options', 'common'));
		$this->get_options_fields($fieldset);
		if ($fieldset->get_fields())
		{
			$form->add_fieldset($fieldset);
		}
	}

	protected function get_options_fields(FormFieldset $fieldset)
	{
		foreach ($this->get_category()->get_additional_attributes_list() as $id => $attribute)
		{
			if (isset($attribute['attribute_field_parameters']))
			{
				$parameters = $attribute['attribute_field_parameters'];
				$field_class = $parameters['field_class'];
				$options = isset($parameters['options']) ? $parameters['options'] : array();
				
				if ($this->is_new_category)
					$value = isset($parameters['default_value']) ? $parameters['default_value'] : '';
				else
					$value = ($this->get_category()->get_additional_property($id) instanceof Url) ? $this->get_category()->get_additional_property($id)->relative() : $this->get_category()->get_additional_property($id);
				
				if ($field_class == 'FormFieldThumbnail')
					$fieldset->add_field(new $field_class($id, $parameters['label'], $value, isset($parameters['default_picture']) ? $parameters['default_picture'] : '', $options));
				else
					$fieldset->add_field(new $field_class($id, $parameters['label'], $value, $options));
			}
		}
	}

	/**
	 * Update or add category
	 */
	private function save()
	{
		$category = $this->get_category();
		if ($category->get_id())
		{
			self::$categories_manager->update($category);
		}
		else
		{
			self::$categories_manager->add($category);
		}
	}

	/**
	 * @return Category
	 */
	protected function get_category()
	{
		if ($this->category === null)
		{
			$id_category = $this->get_id_category();
			if (!empty($id_category))
			{
				$this->category = self::$categories_manager->get_categories_cache()->get_category($id_category);
			}
			else
			{
				$category_class = self::$categories_manager->get_categories_cache()->get_category_class();
				$this->is_new_category = true;
				$this->category = new $category_class();
				$this->category->set_id_parent(AppContext::get_request()->get_getint('id_parent', Category::ROOT_CATEGORY));
				$this->category->set_authorizations(self::$categories_manager->get_categories_cache()->get_root_category()->get_authorizations());
			}
		}
		return $this->category;
	}

	/**
	 * @return mixed[] Array of ActionAuthorization for AuthorizationsSettings
	 */
	public static function get_authorizations_settings()
	{
		$authorizations = array(
			new ActionAuthorization(self::$common_lang['authorizations.read'], Category::READ_AUTHORIZATIONS),
			new VisitorDisabledActionAuthorization(self::$common_lang['authorizations.write'], Category::WRITE_AUTHORIZATIONS),
			new VisitorDisabledActionAuthorization(self::$common_lang['authorizations.contribution'], Category::CONTRIBUTION_AUTHORIZATIONS),
			new MemberDisabledActionAuthorization(self::$common_lang['authorizations.moderation'], Category::MODERATION_AUTHORIZATIONS)
		);
		
		if (!self::get_module()->get_configuration()->has_contribution())
		{
			unset($authorizations[2]);
			$authorizations = array_values($authorizations);
		}
		
		return $authorizations;
	}

	/**
	 * @return string Categories management page title
	 */
	protected function get_categories_management_title()
	{
		return self::$lang['categories.management'];
	}

	/**
	 * @return string Page title
	 */
	protected function get_title()
	{
		return $this->get_id_category() == 0 ? self::$lang['category.add'] : self::$lang['category.edit'];
	}

	/**
	 * @return string the appropriate success message
	 */
	protected function get_success_message()
	{
		return $this->is_new_category ? self::$lang['category.message.success.add'] : self::$lang['category.message.success.edit'];
	}

	/**
	 * @param View $view
	 * @return Response
	 */
	protected function generate_response(View $view)
	{
		$response = new SiteDisplayResponse($view);

		$graphical_environment = $response->get_graphical_environment();
		$graphical_environment->set_page_title($this->get_title(), $this->get_module_home_page_title());
		$graphical_environment->get_seo_meta_data()->set_canonical_url($this->is_new_category ? $this->get_add_category_url() : $this->get_edit_category_url($this->get_category()));

		$breadcrumb = $graphical_environment->get_breadcrumb();
		$breadcrumb->add($this->get_module_home_page_title(), $this->get_module_home_page_url());

		$breadcrumb->add($this->get_categories_management_title(), $this->get_categories_management_url());
		$breadcrumb->add($this->get_title(), $this->is_new_category ? $this->get_add_category_url() : $this->get_edit_category_url($this->get_category()));

		return $response;
	}

	/**
	 * @return CategoriesManager
	 */
	protected static function get_categories_manager()
	{
		return CategoriesService::get_categories_manager();
	}

	/**
	 * @return string id of the category to edit / delete
	 */
	abstract protected function get_id_category();

	/**
	 * @return Url
	 */
	abstract protected function get_categories_management_url();

	/**
	 * @return Url
	 */
	abstract protected function get_add_category_url();

	/**
	 * @param int $category Category
	 * @return Url
	 */
	abstract protected function get_edit_category_url(Category $category);

	/**
	 * @return Url
	 */
	abstract protected function get_module_home_page_url();

	/**
	 * @return string module home page title
	 */
	abstract protected function get_module_home_page_title();

	/**
	 * @return boolean Authorization to manage categories
	 */
	abstract protected function check_authorizations();
}
?>
