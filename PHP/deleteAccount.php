<?php
include 'phpcon.php';
include 'mailsend.php';
 session_start();

if ($conn == false) {
     echo "Connection Failed!";
    die();
} else {
    $email = $_SESSION['email'];
    $verificationCode =null;
    

    if(isset($_POST['email'])){
        $email_user = $_POST['email'];
        $user_id = $_SESSION['userId'];
        if($email_user == $email){
            $verificationCode = mt_rand(1000, 9999);
            $to = $email;
            $subject = "Delete Account";
            $message = "Your verification code is: $verificationCode";
            $headers = "From: your_email@example.com";

            if(mailsend($to, $subject, $message, $headers)){
                $_SESSION['verificationCode'] = $verificationCode;
                echo "<script>alert('Verification code sent successfully');</script>";
            }else{
                echo "<script>alert(' Failed to send Verification code  ');</script>";
                $verificationCode =null;
            }    
        }else{
            echo "<script>alert('email is not find');</script>";
            echo '<script>document.getElementById(\'email_enter\').reset();</script>';
        }
    }

    if(isset($_POST['verificationCode'])){
        $verificationCode_user = $_POST['verificationCode'];
        $verificationCode = $_SESSION['verificationCode'];
        if($verificationCode_user == $verificationCode){

            // Check if the user has any memberships
            // $sql_check_membership = "SELECT * FROM membership_user WHERE user_id = '$user_id'";
            // $result = $conn->query($sql_check_membership);

            // if ($result->num_rows > 0) {
            //     // Delete memberships if they exist
            //     $sql_delete_Me = "DELETE FROM membership_user WHERE user_id = '$user_id'";
            //     $conn->query($sql_delete_Me);
            // }

            // $sql_check_instuctor = "SELECT * FROM instructor_user WHERE user_Id = '$user_id'";
            // $result = $conn->query($sql_check_instuctor);
            
            // if ($result->num_rows > 0) {
            //     // Delete instructor if they exist
            //     $sql_delete_In = "DELETE FROM instructor_user WHERE user_Id = '$user_id'";
            //     $conn->query($sql_delete_In);
            // }

            

            $sql = "DELETE FROM users WHERE email = '$email'";

            if($conn->query($sql)){

                $to = $email;
                $subject = "Delete Account";
                $message = "Thank you for using our service. Your account has been deleted successfully.if you have any question please contact us. supoort team email: zonef845@gmail.com";
                $headers = "From: your_email@example.com";
                mailsend($to, $subject, $message, $headers);

                echo "<script>alert('Account deleted successfully');</script>";
                echo '<script>localStorage.clear();</script>';
                echo '<script>window.location.href = "../index.html";</script>';
            }else{
                echo "<script>alert('Failed to delete account');</script>";
            }
        }else{
            echo "<script>alert('Verification code is incorrect');</script>";
        }
    }   

       

};
?>
<!DOCTYPE html>
<html>
<head>
    <title>delete Account</title>
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
     if($verificationCode == null){
        echo'
    <div class="container">
        <h2>Delete Account</h2>
        <form action="deleteAccount.php" method="post" id="email_enter">
            <div class="form-group">
                
                <input type="email" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <button type="submit">Send Verification Code</button>
            </div>
        </form>
    </div>
    ';
     }else{
        echo '
     }      
    <div class="container">
            <h2>Enter Verification Code</h2>
            <form action="deleteAccount.php" method="post">
            <div class="form-group">
                <label for="verificationCode">Verification Code:</label>
                <input type="text" id="verificationCode" name="verificationCode" required>
            </div>
            <div class="form-group">
                <button type="submit">Delete Account</button>
            </div>
            </form>
        </div>
        ';
        }
  ?>  
</body>
</html>


