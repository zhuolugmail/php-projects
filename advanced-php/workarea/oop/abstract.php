<?php
abstract class Database
{
    abstract public function connection();
    public function disconnect()
    {

    }
}

class Mysql extends Database
{
    public function connection()
    {

    }
}

// $db = new Database();
$db = new Mysql();

?>