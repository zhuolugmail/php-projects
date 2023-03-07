<?php
    function count_down($x) {
        if ($x < 0) {
            echo "Blast off!";
            return;
        }
        echo $x . "...\n";
        count_down($x - 1);
    }

    function count_up($x, $max) {
        if ($x > $max) {
            echo "Done!\n";
            return;
        }
        echo $x . "...\n";
        count_up($x + 1, $max);
    };

    count_up(0, 10);
?>