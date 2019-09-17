<?php


class DB
{

    private $serverdb = 'mysql:host=192.168.20.20; db=name=';
    private $dbname = '';
    private $username = 'root';
    private $password = '';

    // Create connection
    public function dbConnect($serverdb, $dbname, $username, $password) {
        public $dbconnect = new PDO($serverdb . $dbname, $username, $password);
        $dbconnect->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            PDO::FETCH_ASSOC);
    }
}