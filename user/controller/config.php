<?php

require_once '../vendor/autoload.php';

session_start();

// init configuration
$clientID = '920555356117-654voftn9j9r81kocl8jt6e986nc7mjg.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/invoice/user';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// Connect to database
$hostname = "localhost";
$username = "root";
$password = "";
$database = "slip_bank";

$conn = mysqli_connect($hostname, $username, $password, $database);
