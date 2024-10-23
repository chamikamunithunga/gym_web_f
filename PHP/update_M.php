<?php
include 'phpcon.php';
include 'mailsend.php';

$cookie_lifetime = 7 * 24 * 60 * 60; // 1 week
session_start();
$user_id = null;
$email = null;

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
} else {
    echo "Email is not set in the session.";
    exit();
}

if(isset($_SESSION['userId'])!= null){

    $user_id = $_SESSION['userId'];
   
    $plan_id = isset($_POST['plane_Id']) ? $_POST['plane_Id'] : null;
    
    $plane_Name = isset($_POST['plane_Name']) ? $_POST['plane_Name'] : null;
    
    $price = isset($_POST['plane_Price']) ? $_POST['plane_Price'] : null;
    $date = isset($_POST['date']) ? $_POST['date'] : null;
    $expiry_date = isset($_POST['expireddate']) ? $_POST['expireddate'] : null;
    $payment = isset($_POST['paymnet']) ? $_POST['paymnet'] : null;

    $query = "SELECT * FROM membership_user WHERE user_id = ?";
    $stmt_check = $conn->prepare($query);
    $stmt_check->bind_param("s", $user_id);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        echo "You already have membership.";
        exit();
    }
    
    $stmt = $conn->prepare("INSERT INTO membership_user (user_id, membership_id, start_date, end_date, cost, membership_type) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $user_id, $plan_id, $date, $expiry_date , $price,$plane_Name);

         $escaped_path = addslashes($payment);    

        $update_query = "UPDATE users SET payment_slip = '$escaped_path', membership_plan = '$plane_Name' WHERE user_id = '$user_id'";
        mysqli_query($conn, $update_query);
    
 
    if ($stmt->execute()) {

        $to = $email;
        $subject = "Membership purchased";
        $message = "We wanted to let you successfully purchased a membership.wait until If  the admin approve your membership. ";
        $headers = "From: your_email@example.com";
        mailsend($to, $subject, $message, $headers);

        echo "New record created successfully";
        exit();
    } else {
       echo "Error: " . $stmt->error;
        exit();
    }
 
 }else{
     echo "Please login to continue";
    
     exit();
 }



?>