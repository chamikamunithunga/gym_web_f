<?php 
session_start();

include 'phpcon.php';
include 'mailsend.php';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitness_zone";

$conn = new mysqli($servername, $username, $password, $dbname);

// $conn = mysqli_connect("localhost", "username", "password", "database_name");

if($conn == false){
    echo "Connection Failed!";
    die();      
}else{
    echo "<script>alert('conecct!');</script>";
    if(isset($_POST['new_password']) && isset($_POST['confirm_password'])){
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if($new_password == $confirm_password){
            

            $email = $_SESSION['email'];
            $query = "UPDATE users SET Password = '$new_password' WHERE email = '$email'";
            $result = mysqli_query($conn, $query);

            if($result){
                echo "<script>alert('Password changed successfully!');</script>";

                $to = $email;
                $subject = "Password changed";
                $message = "We wanted to let you know that your Fitnes Zone password was reset. If you did not perform this action, you can recover access by entering " . $email . " into the form at http://localhost/sahan/gym-main/PHP/forgottenPassword.php";
                $headers = "From: your_email@example.com";

                if (mailsend($to, $subject, $message, $headers)) {
                    // echo "Verification code sent successfully!";
                    echo "<script>alert('Verification sent successfully!');</script>";
                } else {
                    // echo "Failed to send verification code!";
                    echo "<script>alert('Failed to send verification !');</script>";
                }
                
                unset($_SESSION['email']);
                session_destroy();
                header("Location: ../login.html");
                exit;
            } else {
                echo "<script>alert('Failed to change password!');</script>";
            }
        } else {
            echo "<script>alert('Passwords do not match!');</script>";
        }
    }
}




?>

<!DOCTYPE html>
<html>
<head>
    <title>Password Change</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            width: 300px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Password Change</h1>
    <form method="POST" action="passwordchnage.php">
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required><br><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" required><br><br>

        <input type="submit" value="Change Password">
    </form>
</body>
</html>