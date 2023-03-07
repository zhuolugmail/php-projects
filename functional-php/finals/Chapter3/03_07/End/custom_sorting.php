<?php
    $employees = [
        [
            'name' => 'Bill',
            'years_of_service' => 55,
        ], [
            'name' => 'Caroline',
            'years_of_service' => 34,
        ], [
            'name' => 'Clark',
            'years_of_service' => 40,
        ], [
            'name' => 'Hannah',
            'years_of_service' => 24,
        ]
    ];

    function array_usort($array, $comparator_func) {
        usort($array, $comparator_func);
        return $array;
    };

    $years_of_service_comparator = function($a, $b) {
        return $a['years_of_service'] - $b['years_of_service'];
    };

    $sorted_employees = array_usort($employees, $years_of_service_comparator);

    print_r($sorted_employees);
?>