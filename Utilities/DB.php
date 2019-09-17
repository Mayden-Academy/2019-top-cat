<?php


class DB
{
    private $dbHost = '192.168.20.20';
    private $dbName = 'cat test';
    private $user = 'root';
    private $password = '';

    private $dbconnect;

    // Create connection
    public function __construct() {
        $this->dbconnect = new PDO('mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName, $this->user, $this->password);
        $this->dbconnect->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            PDO::FETCH_ASSOC);
    }

    public function getPDO() {
        return $this->dbconnect;
    }
}