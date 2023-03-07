<?php
    $create_multiplier = function($y) {
        return fn($x) => $x * $y;
    };

    $double = $create_multiplier(2);

    echo $double(18) . "\n";
?>