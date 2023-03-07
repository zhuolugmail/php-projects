<?php
    $add = fn($x, $y, $z) => $x + $y + $z;

    $add_partial = fn($x) => fn($y) => fn($z) => $add($x, $y, $z);

    $add_5 = $add_partial(5);
    $add_5_and_6 = $add_5(6);
    $sum = $add_5_and_6(7);

    $sum_2 = $add_partial(9)(20)(34);

    echo $sum_2 . "\n";
?>