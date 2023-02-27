<?php
trait Log
{
    protected function Log($message)
    {
        echo "{$message}\n";
    }
}

class Table
{
    use Log;

    public function save()
    {
        $this->log('save start');
    }
}

$newTable = new Table();

$newTable->save();
?>