<?php

$serverdb = "mysql:host=192.168.20.20; db=name=";
$dbname = '';
$username = 'root';
$password = '';

// Create connection
$dbconnect = new PDO($serverdb . $dbname, $username, $password);


$dbconnect->setAttribute(
    PDO::ATTR_DEFAULT_FETCH_MODE,
    PDO::FETCH_ASSOC);

$imgSrcToFill =