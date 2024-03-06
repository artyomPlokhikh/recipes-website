<?php

$dsn = "mysql:host=localhost; dbname=plokhart; user=plokhart; charset=utf8mb4; password=webove aplikace" ;

try {
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}