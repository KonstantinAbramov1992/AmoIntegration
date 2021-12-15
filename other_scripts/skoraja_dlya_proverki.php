<?php

$input = fgets(STDIN);
$args = explode(' ', $input);

$args = [
	'K1' => $args[0],
    'M' => $args[1],
    'K2' => $args[2],
    'P2' => $args[3],
    'N2' => $args[4]
];

$floor_number;
$entrance_number;
$count_apartment_on_floor1;
$count_apartment_on_floor2;

if ($args['K1'] === 1) {
    $floor_number = 1;
    $entrance_number = 1;
} elseif ($args['M'] === 1) {
    $floor_number = 1;
    $entrance_number = 0;
} elseif ($args['K2'] === 1) {
    $floor_number = -1;
    $entrance_number = -1;
} elseif ($args['K2'] >= $args['P2']) {
    $floor_number = -1;
    $entrance_number = -1;
} else {
    $count_apartment_on_floor2 = $args['K2'] / ($args['M']*$args['P2'] - ($args['M'] - $args['N2']));

        if ($count_apartment_on_floor2 >= 1) {
            $count_apartment_on_floor2 = ceil($count_apartment_on_floor2);
            $entrance_number = ceil(ceil($args['K1']/$count_apartment_on_floor2)/$args['M']);
        
            if (ceil($args['K1']/$count_apartment_on_floor2) - $args['M']) {
                $floor_number = ceil($args['K1']/$count_apartment_on_floor2) - $args['M'];
            } else {
                $floor_number = ceil($args['K1']/$count_apartment_on_floor2);
            }
        
            $count_apartment_on_floor1 = ceil($args['K1'] / ($args['M']*$entrance_number - ($args['M'] - $floor_number)));
            
            if ($count_apartment_on_floor1 !== $count_apartment_on_floor2) {
                $floor_number = -1;
                $entrance_number = -1;
            } elseif ($floor_number > $args['M']) {
                $floor_number = -1;
                $entrance_number = -1;
            }
        } else {
            $floor_number = -1;
            $entrance_number = -1;
        }
}

$result = "$entrance_number $floor_number2";

fputs(STDOUT, $result);
