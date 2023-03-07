<?php
    $numbers = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

    $is_even = function($x) {
        return $x % 2 == 0;
    };

    $even_numbers = array_values(array_filter(
        $numbers,
        fn($x) => $x % 2 == 0,
    ));

    print_r($even_numbers);
?>