<?php
/* tableau de composition des équipes */

function rules($nb)
{
    if ($nb >= 4){
        $rules = array(
            '2 doublettes'                 => '4',
            '1 doublette + 1 triplette'    => '5',
            '2 triplettes'                 => '6',
            'impossible'                   => '7',
            '4 doublettes'                 => '8',
            '3 doublettes + 1 triplette'   => '9',
            '2 doublettes + 2 triplettes'  => '10',
            '1 doublette + 3 triplettes'   => '11',
            '6 doublettes'                 => '12',
            '5 doublettes + 1 triplette'   => '13',
            '4 doublettes + 2 triplettes'  => '14',
            '3 doublettes + 3 triplettes'  => '15',
            '8 doublettes '                => '16',
            '7 doublettes + 1 triplette'   => '17',
            '6 doublettes + 2 triplettes'  => '18',
            '5 doublettes + 3 triplettes'  => '19',
            '10 doublettes'                => '20',
            '9 doublettes + 1 triplette'   => '21',
            '8 doublettes + 2 triplettes'  => '22',
            '7 doublettes + 3 triplettes'  => '23',
            '12 doublettes'                => '24',
            '11 doublettes + 1 triplette'  => '25',
            '10 doublettes + 2 triplettes' => '26',
            '9 doublettes + 3 triplettes'  => '27',
            '14 doublettes'                => '28',
            '13 doublettes + 1 triplette'  => '29',
            '12 doublettes + 2 triplettes' => '30',
            '11 doublettes + 3 triplettes' => '31',
            '16 doublettes'                => '32',
            '15 doublettes + 1 triplette'  => '33',
            '14 doublettes + 2 triplettes' => '34',
            '13 doublettes + 3 triplettes' => '35',
            '18 doublettes'                => '36',
            '17 doublettes + 1 triplette'  => '37',
            '16 doublettes + 2 triplettes' => '38',
            '15 doublettes + 3 triplettes' => '39',
            '20 doublettes'                => '40',
            '19 doublettes + 1 triplette'  => '41',
            '18 doublettes + 2 triplettes' => '42',
            '17 doublettes + 3 triplettes' => '43',
            '22 doublettes'                => '44',
            '21 doublettes + 1 triplette'  => '45',
            '20 doublettes + 2 triplettes' => '46',
            '19 doublettes + 3 triplettes' => '47',
            '24 doublettes'                => '48',
            '23 doublettes + 1 triplette'  => '49',
            '22 doublettes + 2 triplettes' => '50',
            '21 doublettes + 3 triplettes' => '51',
            '26 doublettes'                => '52',
            '25 doublettes + 1 triplette'  => '53',
            '24 doublettes + 2 triplettes' => '54',
            '23 doublettes + 3 triplettes' => '55',
            '28 doublettes'                => '56',
            '27 doublettes + 1 triplette'  => '57',
            '26 doublettes + 2 triplettes' => '58',
            '25 doublettes + 3 triplettes' => '59',
            '24 doublettes + 4 triplettes' => '60',
            '23 doublettes + 5 triplettes' => '61',
            '22 doublettes + 6 triplettes' => '62',
            '21 doublettes + 7 triplettes' => '63',
            '20 doublettes + 8 triplettes' => '64',
        );
        $rule = array_search($nb, $rules);
        return $rule;
    }else{
        return 'Nombre de joueurs insuffisant';
    }
}
?>

