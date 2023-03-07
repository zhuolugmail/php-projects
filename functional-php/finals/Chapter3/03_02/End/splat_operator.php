<?php
    $names_1 = [
        'John',
        'Betty',
        'Chris',
    ];

    $names_2 = [
        'Peter',
        'Denise',
        'Carl',
    ];

    $all_names = [
        'Jenny',
        ...$names_1,
        'Bill',
        ...$names_2,
        'James',
    ];

    //////////////////////////

    $person_data = [
        'name' => 'Bryan',
        'age' => 43,
    ];

    $career_data = [
        'name' => 'Brian',
        'job' => 'developer',
        'salary' => 120000,
    ];

    $person_with_career_data = array_merge(
        $person_data,
        $career_data,
    );

    //////////////////////////////////

    $add = function(...$args) {
        $sum = 0;
        for ($i = 0; $i < count($args); $i += 1) {
            $sum += $args[$i];
        }
        return $sum;
    };

    $numbers_to_add = [1, 2, 3, 4, 5, 6, 7, 8];

    echo $add(...$numbers_to_add) . "\n";
?>