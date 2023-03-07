<?php
    $add = function($x, $y) {
        return $x + $y;
    };

    $subtract = function($x, $y) {
        return $x - $y;
    };

    $combine_2_and_3 = function($func) {
        return $func(2, 3);
    };

    
    $combine_names = function($func) {
        return $func("Shaun", "Wassell");
    };

    $append_with_space = function($str_1, $str_2) {
        return $str_1 . $str_2;
    };

    $government_form_notation = function($str_1, $str_2) {
        return strtoupper($str_2) . ", " . strtoupper($str_1);
    };

    echo $combine_names(function($str_1, $str_2) {
        return strtoupper($str_2) . ", " . strtoupper($str_1);
    }) . "\n";
?>