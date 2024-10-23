<?php
include 'phpcon.php';   
include 'mailsend.php';

session_start();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['userId'];
$date = date("Y-m-d");

if(isset($_POST['payment_photo_link'])){

    $payment = $_POST['payment_photo_link'];
    $price = $_POST['plane_Price'];
    
    $sql_plan = "SELECT membership_type FROM membership_user WHERE user_id = '$user_id'";
    $result = $conn->query($sql_plan);

    if ($result->num_rows > 0) {
        
        $escaped_path = addslashes($payment);    

        $sql = "UPDATE users SET payment_slip = '$escaped_path' WHERE user_id = '$user_id'";
        $result_1 = $conn->query($sql);

        $row = $result->fetch_assoc();
        $plan_type = $row['membership_type'];

        if($plan_type == "Week"){
            $expiry_date = date('Y-m-d', strtotime($date. ' + 7 days'));
        } else if($plan_type == "Month"){
            $expiry_date = date('Y-m-d', strtotime($date. ' + 30 days'));
           
        } else if($plan_type == "Year"){
            $expiry_date = date('Y-m-d', strtotime($date. ' + 365 days'));
           
        }else{
            echo "Error: Plan type not found";
            exit();
        }

        $start_date = $date;
        $sql_date = "UPDATE membership_user SET start_date = '$start_date', end_date = '$expiry_date',cost = '$price' WHERE user_id = '$user_id'";
        $result = $conn->query($sql_date);

    } else {
        echo "Error: Plan not found";
        exit();
    }

    if($result){
        // echo "success";
        $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $email = $row['email'];
        $name = $row['user_name'];

        $to = $email;
        $subject = "Payment Renewed";
        $message = "Dear $name, your payment has been renewed. Thank you for your continued support.";
        $headers = "From: your_email@example.com";
        mailsend($to, $subject, $message, $headers);
        
        exit();
    }
    else{
        echo "Error renewing payment";
        exit();
    }
}


?>

