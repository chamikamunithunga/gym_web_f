<?php
session_start();

if(isset($_SESSION['verificationVariable'])== null){
    header("Location: ../index.html");
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>OTP Verification</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        .container {
            text-align: center;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .otp-input {
            width: 30px;
            height: 30px;
            text-align: center;
            margin: 0 5px;
            font-size: 18px;
        }
        .submit-btn {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #45a049;
        }
        /* Full-screen overlay */
#loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.7);  /* Light opaque background */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999; /* Make sure it's above other elements */
    backdrop-filter: blur(5px); /* Apply blur effect */
}

/* Spinner styling */
.spinner {
    border: 12px solid #f3f3f3;
    border-radius: 50%;
    border-top: 12px solid #3498db;
    width: 60px;
    height: 60px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

    </style>
</head>
<body>
    <div class="container">
        <h2>OTP Verification</h2>
        <h4>Send OTP in your</h4>
        <form method="post" action="verify.php">
            <input class="otp-input" type="text" name="digit1" maxlength="1" required>
            <input class="otp-input" type="text" name="digit2" maxlength="1" required>
            <input class="otp-input" type="text" name="digit3" maxlength="1" required>
            <input class="otp-input" type="text" name="digit4" maxlength="1" required>
            <br>
            <input class="submit-btn" type="submit" value="Verify">
        </form>
    </div>
    <div id="loading-overlay" style="display: none;">
            <div class="spinner"></div>
    </div>
</body>
</html>

<?php
 
 include 'phpcon.php';
 include 'mailsend.php';



$verificationOtp = "";
$email = "" ; // Initialize the variable

if (isset($_SESSION['verificationVariable']) && isset($_SESSION['email'])) {

    $verificationOtp = $_SESSION['verificationVariable'];
    $email = $_SESSION['email'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $digit1 = $_POST['digit1'];
        $digit2 = $_POST['digit2'];
        $digit3 = $_POST['digit3'];
        $digit4 = $_POST['digit4'];
            
        $otp = $digit1 . $digit2 . $digit3 . $digit4;

        if($otp == $verificationOtp){
            
            // Update the email_v_status row value in the user table to true
            $query = "UPDATE users SET email_v_status = true WHERE email = '$email'";
            $result = mysqli_query($conn, $query);

            $V_status = ""; // Assign an empty string or any desired value to $V_status
            
            // Retrieve the v_status value from the user table
            $query = "SELECT email_v_status FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $V_status = $row['email_v_status'];
            }
               
            $email = $_SESSION['email'];  

                if ($result && $V_status == true) {
                    // Send a welcome email to the user
                    
                    $to = $email;
                    $subject = "FITNESS ZONE ";
                    $message = "Welcome to Fitnes Zone! We're thrilled to have you on board.  your account is now active,then log in to set up your profile. Once you're all set, explore the many features and resources available to you. If you need any help, our support team is ready to assist. Thank you for joining us—we look forward to your active participation!
                    
                                supoort team email: zonef845@gmail.com";
                    $headers = "From: your_email@example.com";

                    mailsend($to, $subject, $message, $headers);

                    echo "<script>alert('Email verification status updated successfully');</script>";
                    header("Location: profile.php");
                    
                    
                } else {
                    echo "<script>alert('Failed to update email verification status');</script>";
                }
            }
           
           
            
        }else
        {
            echo "<script>alert('OTP not match');</script>";
        }
        
        
        
        exit;
    




    }else{
         echo "<script>alert('Sesion not set');</script>";
}

// Rest of the code...



?>