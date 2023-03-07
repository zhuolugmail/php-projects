<?php
    $create_printer = function() {
        $my_favorite_number = 42;

        return function() use ($my_favorite_number) {
            echo "My favorite number is $my_favorite_number\n";
        };
    };

    $my_printer = $create_printer();
    $my_printer();
?>