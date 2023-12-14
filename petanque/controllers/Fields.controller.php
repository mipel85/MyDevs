<?php

function fields_list()
{
    $fields_number = 10;
    $fields_list = [];

    for ($i = 1; $i <= $fields_number; $i++) {
        $fields_list[] = $i;
    }

    return $fields_list;
}
?>