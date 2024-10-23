<?php
 session_start();

 if (isset($_POST['verificationCode'])) {
    
    $enteredCode = $_POST['verificationCode'];
    if (isset($_SESSION['verificationCode'])) {
        $storedCode = $_SESSION['verificationCode'];

        if ($enteredCode == $storedCode) {
            echo "<script>alert('Verification code is correct!');</script>";
            unset($_SESSION['verificationCode']);
            header("Location: passwordchnage.php");
            exit;
        } else {
            echo "<script>alert('Verification code is incorrect!');</script>";
            echo "<script>showToast(errorMsg_2);</script>";
        
            
        }
    } else {
        echo "<script>alert('Verification code is missing!');</script>";
        echo "<script>showToast(errorMsg_2);</script>";
        
    }

}

if (isset($_POST['back'])) {
    unset($_SESSION['verificationCode']);
     header("Location: forgottenPassword.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding:20px 20px 20px 30px;
            border: 1px solid #ccc; 
            border-radius: 5px;
            display: flex;
            aling -items: center;
            justify-content: center;
            flex-direction: column;
            background-color: white;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 90%;
            padding: 10px;
            
            font-size : 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        /*Toster msg*/
        .toastBox{
            position: absolute;
            bottom: 30px;
            right: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow: hidden;
            padding: 10px;
            border-radius: 10px;
          }
          .toast{
            width: 400px;
            height: 60px;
            background-color:rgba(255, 255, 255, 0.79);
            font-weight: 500;
            margin: 15px 0;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            position: relative;
            transform: translateX(100%);
            animation: moveleft 0.5s linear forwards;
            
          }
          @keyframes moveleft{
            100%{
                transform:translateX(0) ;
            }
          }
          .toast i{
            margin: 0 20px;
            font-size: 35px;
            color: green;
          }
          .toast.error i{
            color: rgb(255, 3, 3);
          }
          .toast.Invalid i{
            color: #ffea00;
          }
          .toast::after{
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 5px;
            background: green;
            animation: anim 5s linear forwards;
            
          }
          
          @keyframes anim {
            100%{
                width: 0;
            }
          }
          .toast.error::after{
            background-color: red;
          }
          .toast.Invalid::after{
            background-color: #ffea00;
          }
        
          

           /*Toster msg*/
    </style>
</head>

<body>
<div id="toastBox" class="toastBox"></div>

<script src="https://kit.fontawesome.com/725fc9de50.js" crossorigin="anonymous"></script>
    <script>

        
        
        let successMsg = '<i class="fa-solid fa-circle-check"></i> Verification code send successfully';
        let errorMsg = '<i class="fa-solid fa-circle-xmark"></i> Error ! Email not found!';
        let errorMsg_2 = '<i class="fa-solid fa-circle-xmark"></i> Error ! Verification code is incorrect!';
        let invalidMsg = '<i class="fa-solid fa-circle-exclamation"></i> Invalid Please fill in all fields';

        function showToast(msg) {
            let toast = document.createElement("div");
            toast.classList.add("toast");
            toast.innerHTML = msg;
            toastBox.appendChild(toast);
          
            if (msg.includes("Error")) {
              toast.classList.add("error");
            }
            if (msg.includes("Invalid")) {
              toast.classList.add("Invalid");
            }
            setTimeout(function () {
              toast.remove();
            }, 3000);
          }
          

    </script>

<?php
  

  include 'phpcon.php';
  include 'mailsend.php';

  

  if ($conn == false) {
      echo "Connection Failed!";
      die();
   } else {

      if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $_SESSION['email'] = $email;

        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            // Email exists, proceed with sending verification code
            $verificationCode = mt_rand(1000, 9999);
            

            $to = $email;
            $subject = "Forgot Password";
            $message = "Your verification code is: $verificationCode";
            $headers = "From: your_email@example.com";

            if (mailsend($to, $subject, $message, $headers)) {
                // echo "Verification code sent successfully!";
                //  echo "<script>alert('Verification code sent successfully!');</script>";
                $_SESSION['verificationCode'] = $verificationCode;
                
                echo "<script>showToast(successMsg);</script>";

            } else {
                // echo "Failed to send verification code!";
                echo "<script>alert('Failed to send verification code!');</script>";
            }

        } else {
            // Email does not exist in the users table, show error message
            //  echo "<script>alert('Email not found!');</script>";
            echo "<script>showToast(errorMsg);</script>";
        }


    }

?>

<?php

   


}

    
    if (!isset($_SESSION['verificationCode']) || $_SESSION['verificationCode'] == null) {
        echo '
        
    <div class="container">
        <h2>Forgot Password</h2>
        <form action="forgottenPassword.php" method="post">
            <div class="form-group">
                
                <input type="email" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <button type="submit">Send Verification Code</button>
            </div>
        </form>
    </div>
    ';
    } else

        echo '
        <div class="container">
            <h2>Enter Verification Code</h2>
            <form action="forgottenPassword.php" method="post">
            <div class="form-group">
                <label for="verificationCode">Verification Code:</label>
                <input type="text" id="verificationCode" name="verificationCode" required>
            </div>
            <div class="form-group">
                <button type="submit">Verify Code</button>
                
            </div>
            </form>
            <form action="forgottenPassword.php" method="post">
            <div class="form-group">
                <button type="submit" name="back">Back</button>
             </div>   
        </div>
        ';
?>

   

    
</body>
</html>
