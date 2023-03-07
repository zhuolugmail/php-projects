<?php
    $get_property = function($key, $default, $array) {
        if (array_key_exists($key, $array)) {
            return $array[$key];
        } else {
            return $default;
        }
    };

    $create_property_getter = fn($key, $default) =>
        fn($array) => $get_property($key, $default, $array);

    $get_favorite_color = $create_property_getter('favorite_color', 'none');

    $person_1 = [
        'name' => 'Diana',
        'age' => 53,
        'job_title' => 'developer',
    ];

    $person_2 = [
        'name' => 'Jim',
        'age' => 25,
        'job_title' => 'engineer',
        'favorite_color' => 'light green',
    ];

    $person_1_favorite_color = $get_favorite_color($person_1);
    $person_2_favorite_color = $get_favorite_color($person_2);

    echo $person_1_favorite_color . "\n"; # should print 'none'
    echo $person_2_favorite_color . "\n"; # should print 'light green'
?>