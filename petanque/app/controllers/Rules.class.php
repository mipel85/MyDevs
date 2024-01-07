<?php

namespace App\controllers;
/* tableau de composition des équipes et du nombre de terrains requis*/

class Rules
{
    static function matching_rule($value) : string
    {
        if ($value >= 4) {
            $rules = array(
                '2 doublettes sur 1 terrain'                   => '4',
                '1 doublette + 1 triplette sur 1 terrain'      => '5',
                '2 triplettes sur 1 terrain'                   => '6',
                'Configuration impossible'                     => '7',
                '4 doublettes sur 2 terrains'                  => '8',
                '3 doublettes + 1 triplette sur 2 terrains'    => '9',
                '2 doublettes + 2 triplettes sur 2 terrains'   => '10',
                '1 doublette + 3 triplettes sur 2 terrains'    => '11',
                '6 doublettes sur 3 terrains'                  => '12',
                '5 doublettes + 1 triplette sur 3 terrains'    => '13',
                '4 doublettes + 2 triplettes sur 3 terrains'   => '14',
                '3 doublettes + 3 triplettes sur 3 terrains'   => '15',
                '8 doublettes sur 4 terrains'                  => '16',
                '7 doublettes + 1 triplette sur 4 terrains'    => '17',
                '6 doublettes + 2 triplettes sur 4 terrains'   => '18',
                '5 doublettes + 3 triplettes sur 4 terrains'   => '19',
                '10 doublettes sur 5 terrains'                 => '20',
                '9 doublettes + 1 triplette sur 5 terrains'    => '21',
                '8 doublettes + 2 triplettes sur 5 terrains'   => '22',
                '7 doublettes + 3 triplettes sur 5 terrains'   => '23',
                '12 doublettes sur 6 terrains'                 => '24',
                '11 doublettes + 1 triplette sur 6 terrains'   => '25',
                '10 doublettes + 2 triplettes sur 6 terrains'  => '26',
                '9 doublettes + 3 triplettes sur 6 terrains'   => '27',
                '14 doublettes sur 7 terrains'                 => '28',
                '13 doublettes + 1 triplette sur 7 terrains'   => '29',
                '12 doublettes + 2 triplettes sur 7 terrains'  => '30',
                '11 doublettes + 3 triplettes sur 7 terrains'  => '31',
                '16 doublettes sur 8 terrains'                 => '32',
                '15 doublettes + 1 triplette sur 8 terrains'   => '33',
                '14 doublettes + 2 triplettes sur 8 terrains'  => '34',
                '13 doublettes + 3 triplettes sur 8 terrains'  => '35',
                '18 doublettes sur 9 terrains'                 => '36',
                '17 doublettes + 1 triplette sur 9 terrains'   => '37',
                '16 doublettes + 2 triplettes sur 9 terrains'  => '38',
                '15 doublettes + 3 triplettes sur 9 terrains'  => '39',
                '20 doublettes sur 10 terrains'                => '40',
                '19 doublettes + 1 triplette sur 10 terrains'  => '41',
                '18 doublettes + 2 triplettes sur 10 terrains' => '42',
                '17 doublettes + 3 triplettes sur 10 terrains' => '43',
                '22 doublettes sur 11 terrains'                => '44',
                '21 doublettes + 1 triplette sur 11 terrains'  => '45',
                '20 doublettes + 2 triplettes sur 11 terrains' => '46',
                '19 doublettes + 3 triplettes sur 11 terrains' => '47',
                '24 doublettes sur 12 terrains'                => '48',
                '23 doublettes + 1 triplette sur 12 terrains'  => '49',
                '22 doublettes + 2 triplettes sur 12 terrains' => '50',
                '21 doublettes + 3 triplettes sur 12 terrains' => '51',
                '26 doublettes sur 13 terrains'                => '52',
                '25 doublettes + 1 triplette sur 13 terrains'  => '53',
                '24 doublettes + 2 triplettes sur 13 terrains' => '54',
                '23 doublettes + 3 triplettes sur 13 terrains' => '55',
                '28 doublettes sur 14 terrains'                => '56',
                '27 doublettes + 1 triplette sur 14 terrains'  => '57',
                '26 doublettes + 2 triplettes sur 14 terrains' => '58',
                '25 doublettes + 3 triplettes sur 14 terrains' => '59',
                '24 doublettes + 4 triplettes sur 14 terrains' => '60',
                '23 doublettes + 5 triplettes sur 14 terrains' => '61',
                '22 doublettes + 6 triplettes sur 14 terrains' => '62',
                '21 doublettes + 7 triplettes sur 14 terrains' => '63',
                '20 doublettes + 8 triplettes sur 14 terrains' => '64',
            );
            $rule = array_search($value, $rules);
            return $rule;
        } else {
            return 'Nombre de joueurs insuffisant';
        }
    }
}
?>

