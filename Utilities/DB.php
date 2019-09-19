<?php

class DB
{
    private $server =  'mysql:host=192.168.20.20;';
    private $db = 'dbname=cat-test';
    private $username = 'root';
    private $password = '';

    /**
     * Create DB connection
     * @return PDO
     */
    public function dbConnect()
    {
        $dbconnect = new PDO($this->server . $this->db, $this->username, $this->password);
        $dbconnect->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            PDO::FETCH_ASSOC);
        return $dbconnect;
    }

    public function dbConnectToHostOnly() {
        $dbconnect = new PDO($this->server, $this->username, $this->password);
        $dbconnect->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            PDO::FETCH_ASSOC);
        return $dbconnect;
    }
}