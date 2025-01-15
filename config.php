<?php

require_once './vendor/autoload.php';



// init configuration
// Connect to database
//in .env
$clientID = "";
$clientSecret ="";
$redirectUri = "";

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// Connect to database
//in .env

// Connect to your database
try {
    $pdo = new PDO('mysql:host='. $hostname .';dbname='. $database, $username, $password);
    // Set error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
