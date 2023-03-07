<?php
    # Should return an "enhanced version" of $func,
    # such that func can be called on either a value
    # or an array.
    $call_on_value_or_array = function($func) {
        # Your code goes here
    };

    $double = fn($x) => $x * 2;
    $double_wrapped = $call_on_value_or_array($double);

    $value = 4;
    $doubled_value = $double_wrapped($value);

    $array = [1, 2, 3, 4];
    $doubled_array = $double_wrapped($array);

    echo $doubled_value . "\n"; # Should print 8
    print_r($doubled_array);    # Should print [2, 4, 6, 8]
?>