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
			array('root-gallery-pics', 'root-gallery-pics-thumbnails', 'root-images', 'root-upload'),
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
		// TODO use recursive php functions https://www.php.net/manual/en/class.recursivedirectoryiterator.php
		$folders_list = array();
		$path_folders = new Folder(PATH_TO_ROOT);
		if($path_folders->exists())
		{
			$level_1_exceptions = array('admin', 'database', 'install', 'kernel', 'lang', 'search', 'update', 'user');
			$level_2_exceptions = array('controllers', 'lang', 'update');
			$level_3_exceptions = array('js', 'lang');
			$level_4_exceptions = array();
			$level_5_exceptions = array();
			$level_6_exceptions = array();
			$level_7_exceptions = array();
			$level_8_exceptions = array();
			$lv1 = 0;
			foreach($path_folders->get_folders() as $level_1)
			{				
				$level_1_name = explode('/', $level_1->get_path() ?? '');
				$level_1_name = $level_1_name != '..' ? end($level_1_name) : '';
				if($this->check_content($level_1) && !in_array($level_1_name, $level_1_exceptions))
				{
					$folders_list[] = new FormFieldMultipleCheckboxOption('root-'.$level_1_name, $level_1_name.'|'.$lv1);
					
					$lv2 = 0;
					foreach($level_1->get_folders() as $level_2)
					{
						$level_2_name = explode('/', $level_2->get_path() ?? '');
						$level_2_name = $level_2_name != '..' ? end($level_2_name) : '';
						if($this->check_content($level_2) && !in_array($level_2_name, $level_2_exceptions))
						{
							$folders_list[] = new FormFieldMultipleCheckboxOption('root-'.$level_1_name.'-'.$level_2_name, $level_2_name. '|'.$lv1.'|'.$lv2);
							$lv3 = 0;
							foreach ($level_2->get_folders() as $level_3) 
							{
								$level_3_name = explode('/', $level_3->get_path() ?? '');
								$level_3_name = $level_3_name != '..' ? end($level_3_name) : '';
								if($this->check_content($level_3) && !in_array($level_3_name, $level_3_exceptions))
								{
									$folders_list[] = new FormFieldMultipleCheckboxOption('root-'.$level_1_name.'-'.$level_2_name.'-'.$level_3_name, $level_3_name.'|'.$lv1.'|'.$lv2.'|'.$lv3);
									$lv4 = 0;
									foreach($level_3->get_folders() as $level_4)
									{
										$level_4_name = explode('/', $level_4->get_path() ?? '');
										$level_4_name = $level_4_name != '..' ? end($level_4_name) : '';
										if($this->check_content($level_4) && !in_array($level_4_name, $level_4_exceptions))
										{
											$folders_list[] = new FormFieldMultipleCheckboxOption('root-'.$level_1_name.'-'.$level_2_name.'-'.$level_3_name.'-'.$level_4_name, $level_4_name.'|'.$lv1.'|'.$lv2.'|'.$lv3.'|'.$lv4);
											$lv5 = 0;
											foreach($level_4->get_folders() as $level_5)
											{
												$level_5_name = explode('/', $level_5->get_path() ?? '');
												$level_5_name = $level_5_name != '..' ? end($level_5_name) : '';
												if($this->check_content($level_5) && !in_array($level_5_name, $level_5_exceptions))
												{
													$folders_list[] = new FormFieldMultipleCheckboxOption('root-'.$level_1_name.'-'.$level_2_name.'-'.$level_3_name.'-'.$level_4_name.'-'.$level_5_name, $level_5_name.'|'.$lv1.'|'.$lv2.'|'.$lv3.'|'.$lv4.'|'.$lv5);
													$lv6 = 0;
													foreach($level_5->get_folders() as $level_6)
													{
														$level_6_name = explode('/', $level_6->get_path() ?? '');
														$level_6_name = $level_6_name != '..' ? end($level_6_name) : '';
														if($this->check_content($level_6) && !in_array($level_6_name, $level_6_exceptions))
														{
															$folders_list[] = new FormFieldMultipleCheckboxOption('root-'.$level_1_name.'-'.$level_2_name.'-'.$level_3_name.'-'.$level_4_name.'-'.$level_5_name.'-'.$level_6_name, $level_6_name.'|'.$lv1.'|'.$lv2.'|'.$lv3.'|'.$lv4.'|'.$lv5.'|'.$lv6);
															$lv7 = 0;
															foreach($level_6->get_folders() as $level_7)
															{
																$level_7_name = explode('/', $level_7->get_path() ?? '');
																$level_7_name = $level_7_name != '..' ? end($level_7_name) : '';
																if($this->check_content($level_7) && !in_array($level_7_name, $level_7_exceptions))
																{
																	$folders_list[] = new FormFieldMultipleCheckboxOption('root-'.$level_1_name.'-'.$level_2_name.'-'.$level_3_name.'-'.$level_4_name.'-'.$level_5_name.'-'.$level_6_name.'-'.$level_7_name, $level_7_name.'|'.$lv1.'|'.$lv2.'|'.$lv3.'|'.$lv4.'|'.$lv5.'|'.$lv6.'|'.$lv7);
																	$lv8 = 0;
																	foreach($level_7->get_folders() as $level_8)
																	{
																		$level_8_name = explode('/', $level_8->get_path() ?? '');
																		$level_8_name = $level_8_name != '..' ? end($level_8_name) : '';
																		if($this->check_content($level_8) && !in_array($level_8_name, $level_8_exceptions))
																		{
																			$folders_list[] = new FormFieldMultipleCheckboxOption('root-'.$level_1_name.'-'.$level_2_name.'-'.$level_3_name.'-'.$level_4_name.'-'.$level_5_name.'-'.$level_6_name.'-'.$level_7_name.'-'.$level_8_name, $level_8_name.'|'.$lv1.'|'.$lv2.'|'.$lv3.'|'.$lv4.'|'.$lv5.'|'.$lv6.'|'.$lv7.'|'.$lv8);
																		}
																		$lv8++;
																	}
																}
																$lv7++;
															}
														}
														$lv6++;
													}
												}
												$lv5++;
											}
										}
										$lv4++;
									}
								}
								$lv3++;
							}
						}
						$lv2++;
					}
				}
				$lv1++;
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