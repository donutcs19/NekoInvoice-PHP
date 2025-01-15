<?php

// Connect to database
//in .env

try {
    $pdo = new PDO('mysql:host='. $hostname .';dbname='. $database, $username, $password);
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>