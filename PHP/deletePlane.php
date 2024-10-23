<?php
include 'phpcon.php';
include 'mailsend.php';

session_start();

$userId = $_SESSION['userId'];
$email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();

    if ($password == $hashedPassword) {

        $stmt = $conn->prepare("SELECT * FROM membership_user WHERE user_id = ?");
        $stmt->bind_param("s", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if($result->num_rows === 0) {
            echo "<script>alert('Membership not found.');</script>";
            exit();
        }else{
        
        $stmt = $conn->prepare("DELETE FROM membership_user WHERE user_id = ?");
        $stmt->bind_param("s", $userId);
        $stmt->execute();
        $stmt->close();

        $update_query = "UPDATE users SET payment_slip = 'null', membership_status = '0' membership_plan = 'null' WHERE user_id = '$userId'";
        mysqli_query($conn, $update_query);

        $delete_membership_query = "DELETE FROM membership_user WHERE user_id = '$userId'";
        mysqli_query($conn, $delete_membership_query);

                $to = $email;
                $subject = "Membership deleted";
                $message = "We wanted to let you know that your Fitnes Zone membership was deleted. If you did not perform this action, please contact us.";
                $headers = "From: your_email@example.com";
                mailsend($to, $subject, $message, $headers);

        echo "<script>alert('Membership deleted successfully.');</script>";

        header("Location: ../services.html");
        }  
    } else {
        echo "<script>alert('Incorrect password.');</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Plane</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h1 {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input[type="password"] {
            width: 90%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Delete Plane</h1>
        <form method="post" action="deletePlane.php">
            <label for="password">Enter Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>