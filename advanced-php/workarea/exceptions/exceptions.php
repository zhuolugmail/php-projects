<?php

class InvalidCCException extends InvalidArgumentException
{
    public function __construct($message = "No CC number", $code = 0, $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}

try {
    processCC(1);
} catch (InvalidCCException $e) {
    echo $e->getMessage();
    echo "\n";
    echo get_class($e) . "\n";
} catch (Exception $e) {
    echo $e->getMessage();
    echo "\n";
    echo get_class($e) . "\n";
} finally {
    echo "final\n";
}

function processCC($num = null, $zip = null)
{
    try {
        validate($num, $zip);
    } catch (Exception $e) {
        throw $e;
    }
    echo 'processed' . "\n";
}

function validate($num, $zip)
{
    if (is_null($num)) {
        throw new InvalidCCException();
    }
}
?>