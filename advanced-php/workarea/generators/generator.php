<?php
function fizzbuzz($limit)
{
    $i = 0;
    while ($i <= $limit) {
        $yield = null;
        if ($i % 3)
            $yield = 'fizz';
        if ($i % 5)
            $yield .= 'buzz';
        yield $yield;
        $i++;
    }
    return;
}

foreach (fizzbuzz(25) as $key => $value)
    echo $key . ' => ' . $value . "\n";

?>