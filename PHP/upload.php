<?php
require 'C:/wamp64/www/sahan/gym-main/vendor/autoload.php'; // Assuming you are using Composer for Google Client Library

session_start();

$client = new Google_Client();
$client->setAuthConfig('C:\wamp64\www\sahan\gym-main\PHP\client_secret_823479849184-mh1qt1hhp0anif9gf1m9uuioggs35v24.apps.googleusercontent.com.json');
$client->addScope(Google_Service_Drive::DRIVE_FILE);

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);

    if ($client->isAccessTokenExpired()) {
        // If access token is expired, refresh it
        unset($_SESSION['access_token']);
        header('Location: oauth2callback.php');
        exit;
    }

    // Create Google Drive Service
    $service = new Google_Service_Drive($client);

    // File upload logic
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
        $file = new Google_Service_Drive_DriveFile();
        $file->setName($_FILES['file']['name']);

        $content = file_get_contents($_FILES['file']['tmp_name']);
        
        // Upload file to Google Drive
        $uploadedFile = $service->files->create($file, [
            'data' => $content,
            'mimeType' => $_FILES['file']['type'],
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);

        // Get the file ID and create a link to the file
        $fileId = $uploadedFile->id;
        $fileLink = "https://drive.google.com/file/d/$fileId/view";

        echo "File uploaded successfully! <a href='$fileLink'>View File</a>";
    }
} else {
    // If the user hasn't authorized the app, redirect them to the authorization flow
    header('Location: oauth2callback.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload File to Google Drive</title>
</head>
<body>
    <h1>Upload a File to Google Drive</h1>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <button type="submit">Upload File</button>
    </form>
</body>
</html>
