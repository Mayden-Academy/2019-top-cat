<?php

class DB
{
    private $serverdb = 'mysql:host=127.0.0.1; dbname=cat-test';
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