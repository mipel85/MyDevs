<?php

/*
 * Class of the playgrounds
*/

error_reporting(E_ALL);
ini_set('display_errors', true);

class Fields {
    private $id;
    private $day_id;
    private $field_1;
    private $field_2;
    private $field_3;
    private $field_4;
    private $field_5;
    private $field_6;
    private $field_7;
    private $field_8;
    private $field_9;
    private $field_10;
    private $field_11;
    private $field_12;
    private $field_13;
    private $field_14;

    public function __construct($id = null)
    {
        if (!is_null($id)){
            $req = 'SELECT * FROM fields WHERE id = ' . $id;
            if ($result = Connection::query($req)){
                $result = $result[0];
                $this->set_id($result['id']);
                $this->set_id($result['day_id']);
                $this->set_field_1($result['field_1']);
                $this->set_field_2($result['field_2']);
                $this->set_field_3($result['field_3']);
                $this->set_field_4($result['field_4']);
                $this->set_field_5($result['field_5']);
                $this->set_field_6($result['field_6']);
                $this->set_field_7($result['field_7']);
                $this->set_field_8($result['field_8']);
                $this->set_field_9($result['field_9']);
                $this->set_field_10($result['field_10']);
                $this->set_field_11($result['field_11']);
                $this->set_field_12($result['field_12']);
                $this->set_field_13($result['field_13']);
                $this->set_field_14($result['field_14']);
            }
        }
    }

// start getters setters
    public function get_id() { return $this->id; }
    public function set_id($id) { $this->id = $id; }

    public function get_day_id() { return $this->day_id; }
    public function set_day_id($day_id) { $this->day_id = $day_id; }

    public function get_field_1() { return $this->field_1; }
    public function set_field_1($value) { $this->field_1 = $value; }

    public function get_field_2() { return $this->field_2; }
    public function set_field_2($value) { $this->field_2 = $value; }

    public function get_field_3() { return $this->field_3; }
    public function set_field_3($value) { $this->field_3 = $value; }

    public function get_field_4() { return $this->field_4; }
    public function set_field_4($value) { $this->field_4 = $value; }

    public function get_field_5() { return $this->field_5; }
    public function set_field_5($value) { $this->field_5 = $value; }

    public function get_field_6() { return $this->field_6; }
    public function set_field_6($value) { $this->field_6 = $value; }

    public function get_field_7() { return $this->field_7; }
    public function set_field_7($value) { $this->field_7 = $value; }

    public function get_field_8() { return $this->field_8; }
    public function set_field_8($value) { $this->field_8 = $value; }

    public function get_field_9() { return $this->field_9; }
    public function set_field_9($value) { $this->field_9 = $value; }

    public function get_field_10() { return $this->field_10; }
    public function set_field_10($value) { $this->field_10 = $value; }

    public function get_field_11() { return $this->field_11; }
    public function set_field_11($value) { $this->field_11 = $value; }

    public function get_field_12() { return $this->field_12; }
    public function set_field_12($value) { $this->field_12 = $value; }

    public function get_field_13() { return $this->field_13; }
    public function set_field_13($value) { $this->field_13 = $value; }

    public function get_field_14() { return $this->field_14; }
    public function set_field_14($value) { $this->field_14 = $value; }
// end getters setters

    function add_fields()
    {
        $req = 'INSERT INTO fields values (
                    NULL,
                    "' . $this->get_day_id() . '",
                    "1",
                    "1",
                    "1",
                    "1",
                    "1",
                    "1",
                    "1",
                    "1",
                    "1",
                    "1",
                    "0",
                    "0",
                    "0",
                    "0"
                )';
        return Connection::query($req);
    }

    function remove_day_fields($day_id)
    {
        $req = 'DELETE FROM fields WHERE day_id = "' . $day_id . '"';
        return Connection::query($req);
    }

    function remove_all_fields()
    {
        $req = 'DELETE FROM fields';
        return Connection::query($req);
    }

    function check_field($field_id)
    {
        $req = 'UPDATE fields SET `'. $field_id . '` = 1 WHERE `fields`.`id` = ' . $this->get_id() . '';
        return Connection::query($req);
    }

    function uncheck_field($field_id)
    {
        $req = 'UPDATE fields SET `'. $field_id . '` = 0 WHERE `fields`.`id` = ' . $this->get_id() . '';
        return Connection::query($req);
    }

    static function day_fields_list($day_id)
    {
        $fields = array();
        $req = 'SELECT fields.*, days.date AS date '
            . ' FROM fields '
            . ' LEFT JOIN days ON days.id = fields.day_id'
            . ' WHERE fields.day_id = ' . $day_id;

        if ($result = Connection::query($req)){
            if (!empty($result)){
                foreach ($result as $value)
                {
                    if($value['day_id'] = $day_id)
                        $fields[] = $value;
                }
            }
        }
        return $fields;
    }

    static function field_id($day_id)
    {
        $id = [];
        foreach (self::day_fields_list($day_id) as $values)
        {
            if($values['day_id'] == $day_id)
                $id[] = $values['id'];
        }
        return $id[0];
    }
    
    static function fields_checkbox_list($day_id)
    {
        foreach(Fields::day_fields_list($day_id) as $field) {
            $checkboxes_list = [];
            $checkboxes_list[] = [
                '1' => $field['field_1'],
                '2' => $field['field_2'],
                '3' => $field['field_3'],
                '4' => $field['field_4'],
                '5' => $field['field_5'],
                '6' => $field['field_6'],
                '7' => $field['field_7'],
                '8' => $field['field_8'],
                '9' => $field['field_9'],
                '10' => $field['field_10'],
                '11' => $field['field_11'],
                '12' => $field['field_12'],
                '13' => $field['field_13'],
                '14' => $field['field_14']
            ];
        }

        return $checkboxes_list;
    }

    static function fields_list($day_id)
    {
        $fields_list = [];
    
        $fields = self::fields_checkbox_list($day_id);
        foreach($fields as $list) {
            foreach($list as $item => $checked) {
                if($checked) $fields_list[] = $item;
            }
        }
        
        return $fields_list;
    }
}