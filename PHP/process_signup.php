<?php

$cookie_lifetime = 7 * 24 * 60 * 60; // 1 week
session_set_cookie_params($cookie_lifetime);
session_start();

if(isset($_SESSION['email'])!= null){
    header("Location: ../index.html");
    exit;
}

include 'phpcon.php';
include 'mailsend.php';
include 'verfiy.php';
// Check if the connection is successful    

if($conn == false){
    echo "Connection Failed!";
    die();
}else{
    // echo "Connection Successful!";
        
    $verificationCode = mt_rand(1000, 9999);

    $userId = $_POST['userId'];    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $nic=$_POST['nic'];
    $gender=$_POST['selectedGender'];
    $p_number=$_POST['p_number'];    
    $age=$_POST['age'];
    $verificationVariable = $verificationCode;
    // Check if email already exists in the database
    $emailExistsQuery = "SELECT * FROM users WHERE email = '$email'";
    $nicExistsQuery = "SELECT * FROM users WHERE NIC = '$nic'";

    $nicExistsResult = mysqli_query($conn, $nicExistsQuery);
    $emailExistsResult = mysqli_query($conn, $emailExistsQuery);
    
    

    if (mysqli_num_rows($emailExistsResult)  > 0 || mysqli_num_rows($nicExistsResult) > 0) {    
        echo "user already exists!";
         exit();
    }else{
         // Send verification email
         $to = $email;
         $subject = "Email Verification";
         $message = "Your verification code is: $verificationVariable";
         $headers = "From: your_email@example.com";

            if (mailsend($to, $subject, $message, $headers)) {

                
                $_SESSION['verificationVariable'] = $verificationVariable;
                $_SESSION['email'] = $email;
                $_SESSION['userId'] = $userId;
                

                echo "Verification email sent!";
                $sql = "INSERT INTO users (user_id,email,email_v_status,v_code,user_name,Password,NIC,gender,profile_photo,payment_slip,instructor_pyamnet_slip,membership_status,instructor_status,p_number,age,membership_plan,instructor) 
                VALUES ('$userId','$email',null,'$verificationVariable','$username','$password','$nic','$gender','null','null','null','0','0','$p_number','$age','null','null')";
                
                  
 

            } else {
               echo "Failed to send verification email.";
               exit();
            } 

        

    }
    
   
    // Execute the SQL statement
    if (mysqli_query($conn, $sql)) {
        echo "Data stored successfully!";
    } else {
        echo "Error storing data: " . mysqli_error($conn);
    }

   
}



?>