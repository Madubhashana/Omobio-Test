<?php

class Db
{
    private $host = 'localhost';
    private $user = 'root';
    private $pwd = 'toor';
    private $dbname = 'exam';

    public function connect()
    {
        $myql_connector = "mysql:host=$this->host; dbname=$this->dbname";
        $db_connection = new PDO($myql_connector, $this->user, $this->pwd);
        $db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db_connection;
    }
}
