<?php

class DB
{
    private $serverdb = 'mysql:host=192.168.20.20; dbname=cat-test';
    private $username = 'root';
    private $password = '';

    /**
     * Create DB connection
     * @return PDO
     */
    public function dbConnect()
    {
        $dbconnect = new PDO($this->serverdb, $this->username, $this->password);
        $dbconnect->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            PDO::FETCH_ASSOC);
        return $dbconnect;
    }
}