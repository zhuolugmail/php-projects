<?php
    $divide = function($x, $y) {
        return $x / $y;
    };

    $second_arg_isnt_zero = function($func) {
        return function(...$args) use ($func) {
            if ($args[1] == 0) {
                echo "Cannot divide by zero!\n";
                return null;
            }

            return $func(...$args);
        };
    };

    $divide_safe = $second_arg_isnt_zero($divide);

    echo $divide_safe(10, 0) . "\n";
?>