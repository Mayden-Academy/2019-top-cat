<?php


class DB
{
    private $dbconnect;

    // Create connection
    public function __construct($serverdb, $dbname, $username, $password) {
        $this->dbconnect = new PDO($serverdb . $dbname, $username, $password);
        $this->dbconnect->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            PDO::FETCH_ASSOC);
    }

    public function getPDO() {
        return $this->dbconnect;
    }
}