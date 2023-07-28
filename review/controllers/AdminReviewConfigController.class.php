<?php
/**
 * @copyright   &copy; 2005-2022 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2022 11 26
 * @since       PHPBoost 6.0 - 2022 11 26
*/

class AdminReviewConfigController extends DefaultAdminModuleController
{
	public function execute(HTTPRequestCustom $request)
	{
        $this->view = new FileTemplate('review/AdminReviewConfigController.tpl');

		$this->build_form();

		if ($this->submit_button->has_been_submited() && $this->form->validate())
		{
			$this->save();
		}

		$this->view->put('CONTENT', $this->form->display());

		return new ReviewDisplayResponse($this->view, $this->lang['form.configuration']);
	}

	private function build_form()
	{
		$form = new HTMLForm(__CLASS__);

		$fieldset = new FormFieldsetHTML('configuration', StringVars::replace_vars($this->lang['form.module.title'], array('module_name' => self::get_module()->get_configuration()->get_name())));
		$form->add_fieldset($fieldset);

		$fieldset->add_field(new FormFieldFree('clue', '', $this->lang['review.set.folders.list.clue'],
			array('class' => 'full-field')
		));
		$fieldset->add_field(new FormFieldMultipleCheckbox('folders_list', $this->lang['review.set.folders.list'],
			TextHelper::deserialize($this->config->get_folders()),
			$this->get_recursive_content(),
			array(
				'required' => true,
				'class' => 'mini-checkbox full-field'
			)
		));

		$this->submit_button = new FormButtonDefaultSubmit();
		$form->add_button($this->submit_button);
		$form->add_button(new FormButtonReset());

		$this->form = $form;
	}

	private function get_recursive_content()
	{
		$upload_config = FileUploadConfig::load();
		$root = new Folder(PATH_TO_ROOT);

		$folders_list = array();
		foreach($root->get_folders() as $object)
		{
			$content_list = array();
			$dir = new RecursiveDirectoryIterator($object->get_path(), RecursiveDirectoryIterator::SKIP_DOTS);
			$files = new RecursiveIteratorIterator($dir);
			$f = 0;
			foreach ($files as $file)
			{
				$file = new File($file->getPath() . '/' . $file->getFileName());
				if (in_array($file->get_extension(), (array)$upload_config->get_authorized_extensions()))
				{
					$path = explode('/', $file->get_path());
					$content_list[] = $path[1];
					$f++;
				}
			}
			$folders = array_unique($content_list);
			foreach($folders as $folder)
			{
				if (!is_null($folder) && !in_array($folder, array('install', 'kernel', 'update')))
				{
					$folders_list[] = new FormFieldMultipleCheckboxOption($folder, $folder . ' (' . $f . ')');
				}
			}
		}
		return $folders_list;
	}

	private function save()
	{
		$folders_list = array();
		foreach($this->form->get_value('folders_list') as $id => $value)
		{
			$folders_list[] = $value;
		}
		$this->config->set_folders(TextHelper::serialize($folders_list));

		ReviewConfig::save();

		HooksService::execute_hook_action('edit_config', self::$module_id, array('title' => StringVars::replace_vars($this->lang['form.module.title'], array('module_name' => self::get_module_configuration()->get_name())), 'url' => ModulesUrlBuilder::configuration()->rel()));
	}
}
?>
