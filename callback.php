<?php

session_start();
require_once './config.php';


require_once 'vendor/autoload.php';

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    $google_service = new Google_Service_Oauth2($client);
    $google_account = $google_service->userinfo->get();

    $token = $google_account->id;
    $email = $google_account->email;
    $name = $google_account->name;
    $profile_image = $google_account->picture;
    $firstName = $google_account->givenName;
    $lastName  = $google_account->familyName;
    $gender  = $google_account->gender;
    $verifiedEmail = $google_account->verifiedEmail;





    // Check if the user exists
    $sql = "SELECT urole, id FROM invoice_users WHERE token = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $token);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['urole'] == 'user') {

        $_SESSION['user_id'] = $result['id'];
        $_SESSION['user_urole'] = $result['urole'];

        $user_id = $result['id'];
        $sql = "UPDATE invoice_users SET last_login = CURRENT_TIMESTAMP WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        header('Location: user');
        exit();
    } else if ($result['urole'] == 'admin') {

        $_SESSION['user_id'] = $result['id'];
        $_SESSION['user_urole'] = $result['urole'];

        
        $user_id = $result['id'];
        $sql = "UPDATE invoice_users SET last_login = CURRENT_TIMESTAMP WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        header('Location: ./admin');
        exit();
        } else if ($result['urole'] == 'disable') {
        
        header('Location: index.php');
        exit();
    } else {
        // Redirect to registration form
        $_SESSION['google_data'] = [
            'token' => $token,
            'email' => $email,
            'name' => $name,
            'profile_image' => $profile_image,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'gender' => $gender,
            'verifiedEmail' => $verifiedEmail,
        ];
        header('Location: ./register.php');
        exit();
    }
}
