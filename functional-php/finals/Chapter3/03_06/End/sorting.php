<?php
    $numbers = [20, 5, 6, 8, 3, 11];

    function array_sort($array, ...$rest) {
        sort($array, ...$rest);
        return $array;
    };

    $numbers_sorted = array_sort($numbers);

    print_r($numbers);
    print_r($numbers_sorted);
?>