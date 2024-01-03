<?php
/**
 * @copyright   &copy; 2005-2023 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Sebastien LARTIGUE <babsolune@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2023 03 03
 * @since       PHPBoost 5.1 - 2018 03 15
 */
class FinancialFormFieldClubsEditor extends AbstractFormField
{
    private $max_input = 200;
    private static $db_querier;

    public static function __static()
    {
        self::$db_querier = PersistenceContext::get_querier();
    }

    public function __construct($id, $label, array $value = array(), array $field_options = array(), array $constraints = array())
    {
        parent::__construct($id, $label, $value, $field_options, $constraints);
    }

    function display()
    {
        $template = $this->get_template_to_use();

        $view = new FileTemplate('LamTools/FinancialFormFieldClubsEditor.tpl');
        $view->add_lang(LangLoader::get_all_langs('LamTools'));

        $view->put_all(array(
            'C_DISABLED' => $this->is_disabled(),
            'NAME'       => $this->get_html_id(),
            'ID'         => $this->get_html_id()
        ));

        $this->assign_common_template_variables($template);

        $i = 0;
        foreach ($this->get_value() as $name)
        {
            $view->assign_block_vars('fieldelements', array(
                'ID'   => $i,
                'NAME' => $name
            ));
            $i++;
        }

        if ($i == 0){
            $view->assign_block_vars('fieldelements', array(
                'ID'   => $i,
                'NAME' => ''
            ));
        }

        $clubs_list = ToolsService::get_clubs_list();

        foreach ($clubs_list as $club)
        {
            $view->assign_block_vars('clubs', array(
                'CLUB_FFAM_NUM' => $club['club_ffam_number'],
                'CLUB_DPT'      => $club['club_Dept'],
                'CLUB_NAME'     => $club['club_Name']
            ));
        }
        
//		$row = 1;
//		if (($handle = fopen(PATH_TO_ROOT . "/LamTools/datas/clubs_LAMPDL.csv", "r")) !== FALSE) {
//			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
//				if ($row == 1){
//                    $row++;
//                    continue;
//                }
//				$num = count($data);
//				for ($c = 0; $c < $num; $c++) {
//					$club = explode(';', $data[$c]);
//					$club[0] = str_pad($club[0], 4, "0", STR_PAD_LEFT); // force club number to be 4 digits
//					$club[3] = ucwords(TextHelper::strtolower($club[3]));
//				}
//			}
//			fclose($handle);
//		}

        $view->put_all(array(
            'C_DISABLED'    => $this->is_disabled(),
            'NAME'          => $this->get_html_id(),
            'ID'            => $this->get_html_id(),
            'MAX_INPUT'     => $this->max_input,
            'FIELDS_NUMBER' => $i == 0 ? 1 : $i
        ));

        $template->assign_block_vars('fieldelements', array(
            'ELEMENT' => $view->render()
        ));

        return $template;
    }

    public function retrieve_value()
    {
        $request = AppContext::get_request();
        $values = array();
        for ($i = 0; $i < $this->max_input; $i++)
        {
            $field_name_id = 'field_name_' . $this->get_html_id() . '_' . $i;
            if ($request->has_postparameter($field_name_id)){
                $field_name = $request->get_poststring($field_name_id);
                $values[$field_name] = $field_name;
            }
        }
        $this->set_value($values);
    }

    protected function compute_options(array &$field_options)
    {
        foreach ($field_options as $attribute => $value)
        {
            $attribute = TextHelper::strtolower($attribute);
            switch($attribute)
            {
                case 'max_input':
                    $this->max_input = $value;
                    unset($field_options['max_input']);
                    break;
            }
        }
        parent::compute_options($field_options);
    }

    protected function get_default_template()
    {
        return new FileTemplate('framework/builder/form/FormField.tpl');
    }
}
?>
