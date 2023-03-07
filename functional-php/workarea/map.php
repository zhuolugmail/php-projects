<?php
$map = function ($func, $array) {
    return array_reduce(
        $array,
        function ($c, $i) use ($func) {
            $c[] = $func($i);
            return $c;
        }
        ,
        []
    );
};

$a = [3, 7, 1];

var_dump($a);
var_dump($map(fn($x) => $x + 2, $a));
?>