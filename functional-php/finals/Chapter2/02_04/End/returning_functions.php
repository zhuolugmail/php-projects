<?php
    $create_printer = function() {
        return function() {
            echo "Hello functional!\n";
        };
    };

    $my_printer = $create_printer();
    $my_printer();

    $create_multiplier = function($y) {
        return function($x) use ($y) {
            return $x * $y;
        };
    };

    $double = $create_multiplier(2);
    $triple = $create_multiplier(3);
    $quadruple = $create_multiplier(4);
?>