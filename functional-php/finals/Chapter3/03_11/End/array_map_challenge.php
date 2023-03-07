<?php
    $map = function($func, $array) {
        return array_reduce(
            $array,
            fn($carry, $item) => [...$carry, $func($item)],
            [],
        );
    };

    $numbers = [1, 2, 3, 4];
    $result = $map(
        fn($x) => $x * 3,
        $numbers,
    );

    print_r($result);
?>