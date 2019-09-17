<?php


$servername = "localhost";
$username = "root";
$password = "";


try {
    $conn = new PDO("mysql:host=192.168.20.20", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DROP DATABASE IF EXISTS `CatDB`;
            CREATE TABLE `CatDB`";
    $conn->exec($sql);
    echo "Database successfully initialised.<br>";
} catch (PDOException $e) {
    echo "<br>" . $e->getMessage();
}