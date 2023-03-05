<?php

if (isset($_SERVER["HTTP_X_REQUESTED_WITH"])) {
    if ($_SERVER["HTTP_X_REQUESTED_WITH"] == 'XMLHttpRequest') {
        echo 'This is the new content which has been loaded by Ajax.';
        exit();
    }
}
echo 'Not ajax';
?>