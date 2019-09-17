<?php

$serverdb = "mysql:host=192.168.20.20; db=name=";
$dbname = '';
$username = 'root';
$password = '';

// Create connection
$dbconnect = new PDO($serverdb . $dbname, $username, $password);
