<?php

$dsn = "mysql:host=localhost; dbname=loginsystem";
$username = "root";
$pwd = "";

try {
    $pdo = new PDO ($dsn, $username, $pwd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo "connection to database failed !!! ". $e->getMessage();
}
?>