<?php
require 'C:/wamp64/www/sahan/gym-main/vendor/autoload.php'; // Assuming you are using Composer for Google Client Library

session_start();

$client = new Google_Client();
$client->setAuthConfig('C:\wamp64\www\sahan\gym-main\PHP\client_secret_823479849184-mh1qt1hhp0anif9gf1m9uuioggs35v24.apps.googleusercontent.com.json');
$client->setRedirectUri('C:\wamp64\www\sahan\gym-main\PHP\oauth2callback.php'); // Change this to your actual redirect URI
$client->addScope(Google_Service_Drive::DRIVE_FILE);

if (!isset($_GET['code'])) {
    // Step 1: Generate the authorization URL and redirect the user to Google's OAuth 2.0 server
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
} else {
    // Step 2: Exchange the authorization code for an access token
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    header('Location: upload.php'); // Redirect to the upload script after authentication
    exit;
}
?>
