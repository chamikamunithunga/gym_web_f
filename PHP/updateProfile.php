<?php
session_start();

include 'phpcon.php'; 
include 'mailsend.php'; 

$oldEmail = $_SESSION['email'];

if($conn == false){
    echo "Connection Failed!";
    die();
} else {  
    $userId = isset($_POST['user_id']) ? $_POST['user_id'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $p_number = isset($_POST['mobile']) ? $_POST['mobile'] : '';
    $age = isset($_POST['age']) ? $_POST['age'] : '';

    
    $updateQuery = "UPDATE users SET user_name = '$username', p_number = '$p_number', age = '$age' WHERE user_id = '$userId'";

    if(mysqli_query($conn, $updateQuery)) {
        
        if ($oldEmail != $email) {
            
            $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $checkEmailQuery);

            if (mysqli_num_rows($result) > 0) {
                echo "Email already exists in the database";
                exit();
            } else {
                // Update the user's email
                $updateEmailQuery = "UPDATE users SET email = '$email' WHERE user_id = '$userId'";

                if (mysqli_query($conn, $updateEmailQuery)) {
                    // Update session email
                    $_SESSION['email'] = $email;

                    // Send confirmation email
                    $to = $email;
                    $subject = "Email Change Notification";
                    $message = "This is to inform you that your email has been updated to: $email";
                    $headers = "From: no-reply@example.com\r\n";
                    mailsend($to, $subject, $message, $headers);

                    echo "Email updated successfully";
                    exit();
                } else {
                    echo "Error updating email.";
                    exit();
                }
            }
        } else {
            echo "Profile updated successfully.";
            exit();
        }
    } else {
        echo "Error: " . mysqli_error($conn);
        exit();
    }
}
?>
