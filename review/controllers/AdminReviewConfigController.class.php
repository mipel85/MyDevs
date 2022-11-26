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
        $this->view->add_lang($this->lang);

		$this->build_form();
		$this->get_folders_list();

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
		
		$fieldset->add_field(new FormFieldMultipleCheckbox('multiple_check_box', 'checkbox',
			array('root-images', 'root-upload', 'root-gallery-pics'),
			$this->get_folders_id_list(),
			array('required' => true, 'class' => 'mini-checkbox full-field')
		));

		$this->submit_button = new FormButtonDefaultSubmit();
		$form->add_button($this->submit_button);
		$form->add_button(new FormButtonReset());

		$this->form = $form;
	}

	private function get_folders_list()
	{
		$folders_list = array();
		$root_folders = new Folder(PATH_TO_ROOT);
		if($root_folders->exists())
		{
			foreach($root_folders->get_folders() as $main_folder)
			{
				$main_folder_name = explode('/', $main_folder->get_path() ?? '');
				$main_folder_name = $main_folder_name != '..' ? end($main_folder_name) : '';
				if(!in_array($main_folder_name, array('kernel', 'admin', 'install', 'update', '.vscode')))
				{
					$folders_list[] = new FormFieldMultipleCheckboxOption($main_folder_name, '+' . $main_folder_name);
				
					foreach($main_folder->get_folders() as $folder)
					{
						$folder_name = explode('/', $folder->get_path() ?? '');
						$folder_name = $folder_name != '..' ? end($folder_name) : '';
						if(!in_array($folder_name, array('controllers', 'extension', 'fields', 'lang', 'phpboost', 'services', 'util', 'database', 'update')))
						{
							$folders_list[] = new FormFieldMultipleCheckboxOption($folder_name, '-' . $folder_name);
							foreach ($folder->get_folders() as $sub_folder) 
							{
								$sub_folder_name = explode('/', $sub_folder->get_path() ?? '');
								$sub_folder_name = $sub_folder_name != '..' ? end($sub_folder_name) : '';
								if(!in_array($sub_folder_name, array('js', 'lang')))
								{
									$folders_list[] = new FormFieldMultipleCheckboxOption($sub_folder_name, '_' . $sub_folder_name);
								}
							}
						}
					}
				}
			}
			return $folders_list;
		}		
	}

	private function get_folders_id_list()
	{
		$folders_list = array();
		$root_folders = new Folder(PATH_TO_ROOT);
		if($root_folders->exists())
		{
			$rfi = 0;
			foreach($root_folders->get_folders() as $main_folder)
			{
				$main_folder_name = explode('/', $main_folder->get_path() ?? '');
				$main_folder_name = $main_folder_name != '..' ? end($main_folder_name) : '';
				if(!in_array($main_folder_name, array('kernel', 'admin', 'install', 'update', '.vscode')))
				{
					$folders_list[] = new FormFieldMultipleCheckboxOption('root-' . $main_folder_name, $main_folder_name . '|' . $rfi);
					
					$mfi = 0;
					foreach($main_folder->get_folders() as $folder)
					{
						$folder_name = explode('/', $folder->get_path() ?? '');
						$folder_name = $folder_name != '..' ? end($folder_name) : '';
						if(!in_array($folder_name, array('controllers', 'extension', 'fields', 'lang', 'phpboost', 'services', 'util', 'database', 'update')))
						{
							$folders_list[] = new FormFieldMultipleCheckboxOption('root-' . $main_folder_name . '-' . $folder_name, $folder_name. '|' . $rfi . '|' . $mfi);
							$sfi = 0;
							foreach ($folder->get_folders() as $sub_folder) 
							{
								$sub_folder_name = explode('/', $sub_folder->get_path() ?? '');
								$sub_folder_name = $sub_folder_name != '..' ? end($sub_folder_name) : '';
								if(!in_array($sub_folder_name, array('js', 'lang', 'fields')))
								{
									$folders_list[] = new FormFieldMultipleCheckboxOption('root-' . $main_folder_name . '-' . $folder_name . '-' . $sub_folder_name, $sub_folder_name . '|' . $rfi . '|' . $mfi . '|' . $sfi);
								}
								$sfi++;
							}
						}
						$mfi++;
					}
				}
				$rfi++;
			}
			return $folders_list;
		}		
	}

	private function save()
	{
		ReviewConfig::save();

		HooksService::execute_hook_action('edit_config', self::$module_id, array('title' => StringVars::replace_vars($this->lang['form.module.title'], array('module_name' => self::get_module_configuration()->get_name())), 'url' => ModulesUrlBuilder::configuration()->rel()));
	}
}
?>
