<?php
$array = [1, 2, 3, 4, 5, 6];

$out = array_filter($array, function ($item) {
    return ($item % 2 == 0);
});
print_r($out);
print_r($array);

$filterFunc = function ($item) {
    return ($item % 2 == 1);
};
$out2 = array_filter($array, $filterFunc);
print_r($out2);
?>