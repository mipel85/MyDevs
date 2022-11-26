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
			array('root-gallery-pics', 'root-images', 'root-upload'),
			$this->get_folders_id_list(),
			array('required' => true, 'class' => 'mini-checkbox full-field')
		));

		$this->submit_button = new FormButtonDefaultSubmit();
		$form->add_button($this->submit_button);
		$form->add_button(new FormButtonReset());

		$this->form = $form;
	}

	private function get_folders_id_list()
	{
		$folders_list = array();
		$root_folders = new Folder(PATH_TO_ROOT);
		if($root_folders->exists())
		{
			$root_folders_exceptions = array('admin', 'database', 'install', 'kernel', 'lang', 'search', 'update', 'user');
			$main_folders_exceptions = array('controllers', 'lang');
			$sub_folders_exceptions = array('js', 'lang');
			$last_folders_exceptions = array('js');
			$rfi = 0;
			foreach($root_folders->get_folders() as $root_folder)
			{				
				$root_folder_name = explode('/', $root_folder->get_path() ?? '');
				$root_folder_name = $root_folder_name != '..' ? end($root_folder_name) : '';
				if($this->check_content($root_folder) && !in_array($root_folder_name, $root_folders_exceptions))
				{
					$folders_list[] = new FormFieldMultipleCheckboxOption('root-' . $root_folder_name, $root_folder_name . '|' . $rfi);
					
					$mfi = 0;
					foreach($root_folder->get_folders() as $folder)
					{
						$folder_name = explode('/', $folder->get_path() ?? '');
						$folder_name = $folder_name != '..' ? end($folder_name) : '';
						if($this->check_content($folder) && !in_array($folder_name, $main_folders_exceptions))
						{
							$folders_list[] = new FormFieldMultipleCheckboxOption('root-' . $root_folder_name . '-' . $folder_name, $folder_name. '|' . $rfi . '|' . $mfi);
							$sfi = 0;
							foreach ($folder->get_folders() as $sub_folder) 
							{
								$sub_folder_name = explode('/', $sub_folder->get_path() ?? '');
								$sub_folder_name = $sub_folder_name != '..' ? end($sub_folder_name) : '';
								if($this->check_content($sub_folder) && !in_array($sub_folder_name, $sub_folders_exceptions))
								{
									$folders_list[] = new FormFieldMultipleCheckboxOption('root-' . $root_folder_name . '-' . $folder_name . '-' . $sub_folder_name, $sub_folder_name . '|' . $rfi . '|' . $mfi . '|' . $sfi);
									$lfi = 0;
									foreach($sub_folder->get_folders() as $last_folder)
									{
										$last_folder_name = explode('/', $last_folder->get_path() ?? '');
										$last_folder_name = $last_folder_name != '..' ? end($last_folder_name) : '';
										if($this->check_content($last_folder) && !in_array($last_folder_name, $last_folders_exceptions))
										{
											$folders_list[] = new FormFieldMultipleCheckboxOption('root-' . $root_folder_name . '-' . $folder_name . '-' . $sub_folder_name . '-' . $last_folder_name, $last_folder_name . '|' . $rfi . '|' . $mfi . '|' . $sfi . '|' . $lfi);
										}
										$lfi++;
									}
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

	private function check_content($folder)
	{
		$upload_config = FileUploadConfig::load();
		$folders = $folder->get_folders();
		$files = $folder->get_files();
		
		$files_list = array();
		foreach($files as $file)
		{
			if (in_array($file->get_extension(), $upload_config->get_authorized_extensions()))
				$files_list[] = $file;
		}

		$folders_list = array();
		foreach($folders as $folder)
		{
			if($folder->get_folders())
			{
				$folders_list[] = $folder;
			}

			if($folder->get_files())
			{
				foreach($folder->get_files() as $file)
				{
					if (in_array($file->get_extension(), $upload_config->get_authorized_extensions()))
						$folders_list[] = $folder;
				}
			}				
		}

		$folders_nb = count($folders_list);
		$files_nb = count($files_list);
		
		if ($folders_nb > 0 || $files_nb > 0)
			return true;
		return false;		
	}

	private function save()
	{
		ReviewConfig::save();

		HooksService::execute_hook_action('edit_config', self::$module_id, array('title' => StringVars::replace_vars($this->lang['form.module.title'], array('module_name' => self::get_module_configuration()->get_name())), 'url' => ModulesUrlBuilder::configuration()->rel()));
	}
}
?>
