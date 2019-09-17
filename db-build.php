<?php


$servername = "localhost";
$username = "root";
$password = "";


try {
    $conn = new PDO("mysql:host=192.168.20.20", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DROP DATABASE IF EXISTS `CatDB`;
            CREATE DATABASE `CatDB`;
            
            use `CatDB`;
            CREATE TABLE `breed` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `breed` varchar(255) NOT NULL DEFAULT '',
            PRIMARY KEY (`id`),
            UNIQUE KEY `breed` (`breed`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
            
           
            CREATE TABLE `img` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `img-src` varchar(255) NOT NULL DEFAULT '',
            `breed_id` int(11) unsigned NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `img-src` (`img-src`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

    $conn->exec($sql);
    echo "Database successfully initialised.<br>";
} catch (PDOException $e) {
    echo "<br>" . $e->getMessage();
}