<?php
    $create_multiplier = function($y) {
        return function($x) use ($y) {
            return $x * $y;
        };
    };
?>