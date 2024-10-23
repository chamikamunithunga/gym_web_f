<?php
 include 'phpcon.php';
 include 'mailsend.php';
 

 session_start();
 unset($_SESSION['verificationVariable']);
 
 $paymnet_status = "Not paid";
 $I_paymnet_status = "Not paid";
 $start_date = "Not selected";
 $end_date = "Not selected";
 $cost = "Not selected";
 $membership_type = "Not selected";
 $displayButton = "none";
 $New_cost = 0;
 $Newcost_i = 0;
 $text = "Select";
 $date = date('Y-m-d');

//  echo'<script>alert("'.$date.'");</script>';

 if (!isset($_SESSION['email'])) {
      //   echo'Notloggedin';
       echo '<script>localStorage.clear();</script>';
       echo '<script>window.location.href = "../index.html";</script>';
    echo '<script>alert(" Not Loggedin");</script>';
     exit;
 }else{
    //  echo '<script>alert("Loggedin");</script>';
    
 }
$email = $_SESSION['email'];
$user_id = $_SESSION['userId'];

//  echo '<script>alert("'.$user_id.'");</script>';

// Find the email in the database and return its values
$query = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    // Access the values from the row
    $name = isset($row['user_name']) ? $row['user_name'] : '';
    $gender = isset($row['gender']) ? $row['gender'] : '';
    $nic = isset($row['NIC']) ? $row['NIC'] : '';
    $mobile = isset($row['p_number']) ? $row['p_number'] : '';
    $user_id = isset($row['user_id']) ? $row['user_id'] : '';
    $age = isset($row['age']) ? $row['age'] : '';
    $profile_pic = isset($row['profile_photo']) ? $row['profile_photo'] : '';
    $paymentSlip = isset($row['payment_slip']) ? $row['payment_slip'] : '';
    $InstructorPaymnetSlip = isset($row['instructor_pyamnet_slip']) ? $row['instructor_pyamnet_slip'] : '';
    $membership_status = isset($row['membership_status']) ? $row['membership_status'] : '';
    $instructor_status = isset($row['instructor_status']) ? $row['instructor_status'] : '';
    
    $displayINstructorButton = "show";
    $displayRenewPaymentButton = "none";   
    $displayRenewInstructortButton = "none";  
    $displayDeleteInstructorButton = "none"; 
    
    if($paymentSlip != 'null'){
        
        // $displayRenewPaymentButton = "none";

        if($membership_status === "1"){
            
                       $paymnet_status = " success";
                       $displayButton = "show";
                       $text = "View";
                       $displayRenewPaymentButton = "none";
            

        }else{
            $paymnet_status = " Pending";
        }


    }else{
        
        $paymnet_status = "Not paid";
    }

    if($InstructorPaymnetSlip != 'null'){
        
        // $displayRenewPaymentButton = "none";

        if($instructor_status === "1"){
            
                       $I_paymnet_status = " success";
                       $displayDeleteInstructorButton = "show";
                       $displayRenewInstructortButton = "none";  
                       $text_i = "View";
                       
            

        }else{
            $I_paymnet_status = " Pending";
        }


    }else{
        
        $I_paymnet_status = "Not paid";
    }

    $sql_plan = "SELECT * FROM membership_user WHERE user_id = '$user_id'";;
    $result = $conn->query($sql_plan);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $m_id = $row['membership_id'];

                $end_date = isset($row['end_date']) ? $row['end_date'] : '';
                $membership_type = isset($row['membership_type']) ? $row['membership_type'] : '';

                // echo'<script>alert("'.$end_date.'");</script>';

                if($end_date < $date){
                    $viewbutton = "none";
                    $paymnet_status = "expired";
                     $displayButton = "show";
                     $displayRenewPaymentButton = "show";
                    $text = "Select"; 
                    $update_query = "UPDATE users SET payment_slip = 'null', membership_status = '0' WHERE user_id = '$user_id'";
                    mysqli_query($conn, $update_query);

                    

                    // $delete_membership_query = "DELETE FROM membership_user WHERE user_id = '$user_id'";
                    // mysqli_query($conn, $delete_membership_query);

                    $to = $email;
                    $subject = "Membership expired";
                    $message = "We wanted to let you know that your Fitnes Zone membership was expired. Please make a payment to renew your membership.";
                    $headers = "From: your_email@example.com";
                    mailsend($to, $subject, $message, $headers);
                    
                }else{
                   
                    
                    $text = "View";
                    $displayRenewPaymentButton = "none";
                }            


        $sql = "SELECT * FROM membership WHERE p_id = '$m_id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $New_cost = $row['price'];
        }


    }  
    
    $sql_instructor = "SELECT * FROM instructor_user WHERE user_Id = '$user_id'";;
    $result = $conn->query($sql_instructor);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $I_id = $row['Instructor_Id'];

                $end_date = isset($row['e_date']) ? $row['e_date'] : '';
                
                // echo'<script>alert("'.$end_date.'");</script>';

                if($end_date < $date){
                    
                    $I_paymnet_status = "Expired";
                    $displayDeleteInstructorButton = "show";
                    $displayRenewInstructortButton = "show";
                    $displayINstructorButton = "none";
                    $update_query = "UPDATE users SET instructor_pyamnet_slip = 'null', instructor_status = '0' WHERE user_id = '$user_id'";
                    mysqli_query($conn, $update_query);

                    

                    // $delete_membership_query = "DELETE FROM membership_user WHERE user_id = '$user_id'";
                    // mysqli_query($conn, $delete_membership_query);

                    $to = $email;
                    $subject = "Instructor payment expired";
                    $message = "We wanted to let you know that your Fitnes Zone Instructor payment  was expired. Please make a payment to renew your Payment.";
                    $headers = "From: your_email@example.com";
                    mailsend($to, $subject, $message, $headers);
                    
                }else{
                   
                    
                    // $text = "View";
                    // $displayRenewPaymentButton = "none";
                }            


        $sql = "SELECT * FROM instructor_show WHERE Instructor_Id = '$I_id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $Newcost_i = $row['price'];
        }


    }        



    // Update the corresponding HTML elements with the values
   
} else {
    // Handle the case when the email is not found in the database
    echo 'Email not found in the database';
}

$query_2 = "SELECT * FROM membership_user WHERE user_id = '$user_id'";
$result_2 = mysqli_query($conn, $query_2);

if($result_2){
    $row_2 = mysqli_fetch_assoc($result_2);
   
    $start_date = isset($row_2['start_date']) ? $row_2['start_date'] : '';
    $end_date = isset($row_2['end_date']) ? $row_2['end_date'] : '';
    $cost = isset($row_2['cost']) ? $row_2['cost'] : '';
    $membership_type = isset($row_2['membership_type']) ? $row_2['membership_type'] : '';
    $Plan_Id = isset($row_2['membership_id']) ? $row_2['membership_id'] : '';
    
   
    
    // echo'<script>alert("'.$plan_expiry_date.'");</script>';
    // echo'<script>alert("'.$instructor_expiry_date.'");</script>';
    // echo'<script>alert("'.$plan_expiry.'");</script>';
    // echo'<script>alert("'.$instructor_expiry.'");</script>';
    // echo'<script>alert("'.$plan_expiry_date.'");</script>';
    // echo'<script
}else{
    echo 'Email not found in the database';
    $start_date = "Not selected";
    $end_date = "Not selected";
    $cost = "Not selected";
    $membership_type = "Not selected";
}

$query_3 = "SELECT * FROM instructor_user WHERE user_id = '$user_id'";
$result_3 = mysqli_query($conn, $query_3);

if($result_3){
    $row_3 = mysqli_fetch_assoc($result_3);
   
    $start_date_i = isset($row_3['s_date']) ? $row_3['s_date'] : '';
    $end_date_i = isset($row_3['e_date']) ? $row_3['e_date'] : '';
    $cost_i = isset($row_3['cost']) ? $row_3['cost'] : '';
    $In_Id = isset($row_3['Instructor_Id']) ? $row_3['Instructor_Id'] : '';

    $query_4 = "SELECT * FROM instructor_show WHERE Instructor_Id = '$In_Id'";
    $result_4 = mysqli_query($conn, $query_4);
    $row_4 = mysqli_fetch_assoc($result_4);
    $Instructor_name = isset($row_4['Name']) ? $row_4['Name'] : '';
    
}else{
    echo 'Email not found in the database';
    
}
    
    
  
if (isset($_POST['logout'])) {
    
    $_SESSION = array();

    session_destroy();
    echo '<script>localStorage.clear();</script>';
    
    header("Location: ../index.html");
    exit();
}

if(isset($_POST['phpemail'])){
    $email = $_POST['phpemail'];
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $membership_status = isset($row['membership_status']) ? $row['membership_status'] : '';
        //  echo'<script>alert("'.$membership_status.'");</script>';  
        if ($membership_status === "0" ) {    
            echo 'false';
        } else {
            echo 'true';
        }
        exit;
       } else {

        echo 'failed';
        exit;
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-image:url('../img/bg1.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #f0f0f0;
            margin: 0;
            padding: 0;
            
        }

        .profile-container {
            display: flex;
            color:#cbb600;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            border:1px solid red;
        }

        .sidebar {
            width: 25%;
            background-color: #000000ee;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .profile-pic {
            width: 100px;
            height: 100px;
            background-color: #7d7d7d;
            border-radius: 50%;
            margin: 0 auto;
            background-image: url('../img/logo/user_icon.png');
            background-size: cover;
        }

        .edit-button,
        .change-button {
            background-color: #cbb600;
            border: none;
            color: #000;
            padding: 10px 20px;
            margin-top: 10px;
            cursor: pointer;
            font-weight: bold;
            border-radius: 5px;
        }

        .edit-button_2 {
            background-color: #cb0000;
            border: none;
            color: #000;
            padding: 10px 20px;
            margin-top: 10px;
            cursor: pointer;
            font-weight: bold;
            border-radius: 5px;
        }
        .delete_plane{
            display : <?php echo $displayButton; ?>;
        }
        .renew_plane{
            display : <?php echo $displayRenewPaymentButton; ?>;
        }
        .Renew_Instructor{
            display : <?php echo $displayRenewInstructortButton; ?>;
        }
        .viewbtn{
            display : <?php echo $viewbutton; ?>;
        }
        .delete_Instructor{
            display : <?php echo $displayDeleteInstructorButton; ?>;
        }
        .View_instructor{
            display : <?php echo $displayINstructorButton; ?>;
        }
        .back-button {
            margin-left: -200px;
            background-color: #cbb600;
            border: none;
            color: #000;
            padding: 10px 20px;
            margin-top: 40px;
            cursor: pointer;
            border-radius: 5px;
        }

        .back-button:hover {
            color:#ffd900;
            background-color: #000000;
            border-color:#ffd900;
            border-size:2px;
            

            /* Slightly brighter shade */
            transform: translateY(-3px);
            /* Creates lift effect */
        }

        .forget-password {
            display: block;
            margin-top: 20px;
            color: #ffeb3b;
            text-decoration: none;
        }

        .main-content {
            width: 75%;
            margin-left: 20px;

        }

        .membership-plan,
        .instructor-details,
        .online-classes {
            background-color: #2b2b2b;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .membership-plan h2,
        .instructor-details h2,
        .online-classes h2 {
            color: #ffeb3b;
            margin-left: 20px;
        }

        .plan-expiry_1 {
            color: #ff0303;
            display: none; 
        }
        .plan-expiry_2 {
            color: #ff0303;
            display: none; 
        }

        .class-box {
            background-color: #7d7d7d;
            height: 100px;
            width: 30%;
            display: inline-block;
            margin: 10px 1.5%;
            border-radius: 10px;
        }

        .online-classes {
            display: flex;
            align-items: center;
            justify-content: center;
            
            justify-content: space-between;
            gap: 5px;
            flex-wrap: nowrap;
            overflow-x: auto;
            
        }

        .class-box {
            background-color:#7d7d7d;
            flex-shrink: 0;
            width: 200px;
            height: 350px;
            text-align: center;
            border: 2px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            transition: box-shadow 0.3s ease;
        }


        .class-box img {
            width: 100%;
            height: auto;
            display: block;
        }

        .class-box button {
            background-color: #cbb600;
            border: none;
            padding: 10px;
            color: #000;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            border-radius: 0 0 10px 10px;
            transition: background-color 0.3s ease;
        }

        .class-box button:hover {
            background-color: #ffcc00;
        }

        .class-box:hover {
            box-shadow: 0 8px 16px #00000033;
        }

        .class-caption {
            font-size: 14px;
            color: #ffffff;
            margin: 10px 0;
        }

        .Edit-picture {
            background-color: #cbb600;
            border: none;
            color: #000;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 8px #00000033;
        }

        /* pesronal infomation div */
        .profile-container_2 {
            background-color: #f7f7f4ad;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px #0000001a;
            max-width: 600px;
            width: 100%;
            margin-top: -850px;
            position: absolute;
            margin-left: 480px;
            z-index: 1;
             display: none; 
             border: 1px solid red; 
        }

        .profile-details {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            Z-index: 99;
            /* border: 1px solid red; */
        }

        .profile-pic_1 {
            width: 200px;
            height: 250px;
            object-fit: cover;
            /* border: 3px solid #ccc; */
            display: flex;
            align-items: center;
            flex-direction: column;

        }

        .profile-pic-2 {
            width: 150px;
            height: 150px;
            border-radius: 100%;

            border: 3px solid #000000b6;
        }

        /* copy*/
        .button_In {
            margin-top: 10px;
            padding: 8px 16px;
            background-color: #fbff00;
            color: rgb(0, 0, 0);
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button_In:hover {
            background-color: #0c0c0c;
            color: #fbff00;
        }

        #savePhotoBtn {
            background-color: #28a745;
            margin-left: 10px;
        }

        #savePhotoBtn:hover {
            background-color: #218838;
        }

        input[type="text"],
        input[type="email"] {
            border: none;
            background-color: #f4f4f4;
            padding: 5px;
            border-radius: 5px;
            width: 100%;
        }

        input:disabled {
            background-color: #e0e0e0;
            color: #333;
        }

        #saveInfoBtn {
            background-color: #28a745;
            display: none;
        }

        #saveInfoBtn:hover {
            background-color: #218838;
        }

        @media (max-width: 768px) {
            .profile-details {
                flex-direction: column;
                align-items: center;
            }

            .profile-pic img {
                width: 120px;
                height: 120px;
            }
        }



        .back-button_1 {
            padding: 8px 16px;
            background-color: #fbff00;
            color: rgb(0, 0, 0);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 20px;
            margin-left: -10px;
            margin-top: 10px;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .back-button_1:hover {
            background-color: #030303;
            color:#fbff00 ;
        }
        .p_I{
            color: #000000;
        }
        .payment_container_3 {
            background-color: #f7f7f4ad;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px #0000001a;
            max-width: 600px;
            width: 100%;
            margin-top: -850px;
            position: absolute;
            margin-left: 480px;
            z-index: 1;
            display: none; 
            /* border: 1px solid red; */
        }
        .payment_text{
            color: #000000;
            font-size: 20px;
            font-weight: bold;
        }   
        /* pesronal infomation div */
    </style>

</head>

<body >
    <div class="profile-container" id="Body">
        <div class="sidebar">
            <button class="back-button" id="Home_page">Back</button>
            <div class="profile-pic"></div>
            <br>
            <button class="Edit-picture" onClick="show_P_C_2()" >Edit</button>

            <br>
            <?php
             echo '<p id="UID">User ID : '.$user_id.'</p>';
            echo '<p id="name">User Name : '.$name.'</p>';
            echo '<p id="Gender">Gender : '.$gender.'</p>';
            echo '<p id="NIC">NIC : '.$nic.'</p>';
            echo '<p id="age">AGE : '.$age.'</p>';
            echo '<p id="Email">Email : '.$email.'</p>';
            echo '<p id="M_number">Mobile No :+94 '.$mobile.'</p>';
            ?>

            
            <form method="POST">
              <input type="submit" class="edit-button" value="Logout" name="logout" id="logoutButton">
            </form>
            <a href="passwordchnage.php" class="forget-password">Forget Password?</a>
            <br>
            <button class="edit-button_2" id="delete_button">Delete Account</button>

        </div>

        <div class="main-content">
            <div class="membership-plan">
                <h2>Membership Plan</h2>

                <?php
                echo '<p>Issue Date : '.$start_date.'</p>';
                echo '<p>Expires Date : '.$end_date.'</p>';
                echo '<p>Type of Plan : '.$membership_type.'</p>';
                echo '<p>Select Plan Id : '.$Plan_Id.'</p>';
                echo '<p>Cost : Rs '.$cost.'.00</p>';
                echo '<p>Payment Status : '.$paymnet_status.'</p>';
                ?>
                
                <button class="change-button viewbtn" id="chnage_plane"><?php echo $text ?> Plan</button>
                <button class="edit-button_2 delete_plane" id="delete_plane">Delete Plan</button>
                <button class="change-button renew_plane" id="renew_plane">Renew Plan</button>
                <p class="plan-expiry_1">Plan is expired : within two Weeks</p>
            </div>

            <div class="instructor-details">
                <h2>Instructor Details</h2>
                <p>Instructor Name : <?php echo $Instructor_name; ?></p>
                <p>Instructor ID : <?php echo $In_Id; ?></p>
                <p>Issue Date : <?php echo $start_date_i; ?></p>
                <p>Expires Date : <?php echo $end_date_i; ?></p>
                <p>Cost : Rs <?php echo $cost_i; ?>.00</p>
                <p>Payment Status : <?php echo $I_paymnet_status; ?></p>
                
                
                <button class="change-button View_instructor" id="Change_Instructor">View Instructor</button>
                <button class="edit-button_2 delete_Instructor" id="delete_Instructor">Delete Instructor</button>
                <button class="change-button Renew_Instructor" id="Renew_Instructor">Renew Instructor</button>
                <p class="plan-expiry_2">Plan is expired : within two Weeks</p>
            </div>

            <div class="online-classes">
                <h2>Online Classes</h2>
                
                <?php

                    $sql = "SELECT * FROM zoom_clz";
                    $result = $conn->query($sql);


                  if ($result->num_rows > 0) {
                     while($row = $result->fetch_assoc()) {
                          echo '
                          
                           <div class="class-box">
                           <img src="../gym/profile/online.jpg" alt="Class '.$row["Topic"].'"> 
                           <h5>Class Topic: ' . $row["Topic"] . '</h5>
                           <h5>Instructor: ' . $row["Instructor_name"] . '</h5>
                           <h5>Date: ' . $row["date"] . '</h5>
                           <h5>Time: ' . $row["Time"] . '</h5>
                           <h5><a href="' . $row["Link"] . '" target="_blank">Join Class</a></h5>
                          </div>
                       ';
                      }
                   } else {
                      echo "No classes found.";
                    }

                  $conn->close();
                ?>
       
            </div>


        </div>
    </div>
    <div class="profile-container_2" id="profile_container_2">
        <button class="back-button_1" onclick="goToProfile()">Back</button>

        <div class="profile-details">
            <!-- Profile Picture Section -->
            <div class="profile-pic_1">
                <img id="profileImage" src="../img/logo/user_icon.png" alt="Profile Picture" class="profile-pic-2">
                <input type="file" id="upload" style="display: none;" accept="image/*">
                <button class="button_In" id="editPhotoBtn" onclick="triggerUpload()">Edit Photo</button>
                <button class="button_In" id="savePhotoBtn" style="display: none;" onclick="savePhoto()">Save
                    Photo</button>
            </div>

            <!-- User Details Section -->
            <div class="user-info">
                <p class="p_I"><strong>User:</strong> <input type="text" id="userName" value="<?php echo $name; ?>" disabled></p>
                <p class="p_I"><strong>Email:</strong> <input type="email" id="userEmail" value="<?php echo $email; ?>" disabled></p>
                <p class="p_I"><strong>Mobile No:</strong> <input type="text" id="userMobile" value="<?php echo $mobile; ?>" disabled></p>
                <p class="p_I"><strong>Age:</strong> <input type="text" id="Age" value="<?php echo $age; ?>" disabled></p>
                
                <button class="button_In" id="editInfoBtn" onclick="editInfo()">Edit Info</button>
                <button class="button_In" id="saveInfoBtn" style="display: none;" onclick="saveInfo()">Save
                    Info</button>
            </div>
        </div>
    </div>
    

    
    <script>

        var phpname = "<?php echo $name; ?>";
        var phpemail = "<?php echo $email; ?>";
        var phpmobile = "<?php echo $mobile; ?>";
        var phpage = "<?php echo $age; ?>";
        var user_id = "<?php echo $user_id; ?>";

        var phpPlanId = "<?php echo $Plan_Id; ?>";
        var cost = "<?php echo $New_cost; ?>";
        var membership_type = "<?php echo $membership_type; ?>";

        var phpInstructorId = "<?php echo $In_Id; ?>";
        var I_cost = "<?php echo $Newcost_i; ?>";

        function show_P_C_2(){
           document.getElementById("profile_container_2").style.display = "block";
           document.getElementById("Body").style.filter = "blur(5px)";
           document.getElementById("profile_container_2").classList.add("animate-show");
         }

        function goToProfile(){
           document.getElementById("profile_container_2").style.display = "none";
           document.getElementById("Body").style.filter = "blur(0px)";
           document.getElementById("profile_container_2").classList.remove("animate-show");
           location.reload();
        }
        document.getElementById('delete_button').addEventListener('click', function() {
            var r = confirm("Are you sure you want to delete your account?");
            if (r == true) {
                window.location.href = "deleteAccount.php";
            }
        });
        document.getElementById('delete_plane').addEventListener('click', function() {
            var r = confirm("Are you sure you want to delete your Plan becourse you payment is not refundable");
            if (r == true) {
                window.location.href = "deletePlane.php";
            }
        });
        document.getElementById('delete_Instructor').addEventListener('click', function() {
            var r = confirm("Are you sure you want to delete your Instructor becourse you payment is not refundable");
            if (r == true) {
                window.location.href = "deleteInstructor.php";
            }
        });
        document.getElementById('logoutButton').addEventListener('click', function() {
               localStorage.clear();
        });

        document.getElementById('Home_page').addEventListener('click', function() {
            window.location.href = "../index.html";
        });

        function editInfo() {
           document.getElementById('userName').disabled = false;
           document.getElementById('userEmail').disabled = false;
           document.getElementById('userMobile').disabled = false;
           document.getElementById('Age').disabled = false;
           document.getElementById('editInfoBtn').style.display = 'none';
           document.getElementById('saveInfoBtn').style.display = 'inline-block';
        }

        let tempImage = ''; // Store temporary image for profile picture

       // Trigger file upload
       function triggerUpload() {
           document.getElementById('upload').click();
        }

      // Handle image upload and preview
       document.getElementById('upload').addEventListener('change', function() {
          const file = this.files[0];
            if (file) {
               const reader = new FileReader();
               reader.onload = function(e) {
               tempImage = e.target.result;
               document.getElementById('profileImage').src = tempImage;
               document.getElementById('savePhotoBtn').style.display = 'inline-block';
             };
             reader.readAsDataURL(file);
            }
        });

        function saveInfo(){

            let username = document.getElementById('userName').value;
            let email = document.getElementById('userEmail').value;
            let mobile = document.getElementById('userMobile').value;
            let age = document.getElementById('Age').value;

            if (username === '' || email === '' || mobile === '' || age === '') {
                alert('Please fill all the fields');
                return;
            }

            if (email == phpemail && mobile == phpmobile && age == phpage && username == phpname) {
                alert('data is same');  
                return;
            }else{
                var formData = new FormData();
                formData.append('username', username);
                formData.append('email', email);
                formData.append('mobile', mobile);
                formData.append('age', age);
                formData.append('user_id', user_id);
                alert('data is not same');

                fetch('updateProfile.php', {
                method: 'POST',
                body: formData
               }).then(response => response.text())
               .then(data => {
                if (data === 'success') {
                    alert('Profile updated successfully');
                    document.getElementById('userName').disabled = true;
                    document.getElementById('userEmail').disabled = true;
                    document.getElementById('userMobile').disabled = true;
                    document.getElementById('Age').disabled = true;
                    document.getElementById('editInfoBtn').style.display = 'inline-block';
                    document.getElementById('saveInfoBtn').style.display = 'none';
                } else if(data.includes("Email sent successfully")) {
                    alert('Profile updated successfully');
                    document.getElementById('userName').disabled = true;
                    document.getElementById('userEmail').disabled = true;
                    document.getElementById('userMobile').disabled = true;
                    document.getElementById('Age').disabled = true;
                    document.getElementById('editInfoBtn').style.display = 'inline-block';
                    document.getElementById('saveInfoBtn').style.display = 'none'; 
                }else{
                    alert('Failed to update profile'+data);
                    console.log(data);
                }
                
            });

            }
           
        } 
        document.getElementById('chnage_plane').addEventListener('click', function() {
           window.location.href = "../services.html";
        });  
        document.getElementById('Change_Instructor').addEventListener('click', function() {
            var formData = new FormData();
            formData.append('phpemail',phpemail);
            fetch('profile.php', {
                method: 'POST',
                body: formData
            }).then(response => response.text())
            .then(data => {
                if (data == "true") {
                    alert('sucess to update instructor'+data);
                    // console.log(data);
                     window.location.href = "../team.html";
                    
                } else if(data==='false'){   
                  
                    console.log(data);
                    alert('You cant select the instructor until you membership plan is success');
                }else{
                    console.log(data);
                    alert('Failed to update instructor'+data);
                }
                
            });
        });
        document.getElementById('renew_plane').addEventListener('click', function() {
            let paymenttype = "Membership Payment renewal";
            let paymentcost = cost;
            let paymentplan = membership_type;
            let planId= phpPlanId;

            let formdata = new FormData();
            formdata.append('plane_Id', planId);
            formdata.append('plane_Name', paymentplan);
            formdata.append('plane_Price', paymentcost);
            formdata.append('membership', paymenttype);  

            let form = document.createElement('form');
            form.method = 'POST';
            form.action = 'Payment.php'; 
        
        
        for (let [key, value] of formdata.entries()) {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            form.appendChild(input);
        }

        // Append the form to the document body and submit it
        document.body.appendChild(form);
        form.submit();

            // document.getElementById('payment_container_3').style.display = "block";
            // document.getElementById("Body").style.filter = "blur(5px)";
            // document.getElementById("payment_container_3").classList.add("animate-show");
            
        });

        document.getElementById('Renew_Instructor').addEventListener('click', function() {
            let paymenttype = "Instructor Payment renewal";
            let paymentcost = I_cost;
            let paymentplan = "Month(30 days)";
            let planId= phpPlanId;

            let formdata = new FormData();
            formdata.append('plane_Id', planId);
            formdata.append('plane_Name', paymentplan);
            formdata.append('plane_Price', paymentcost);
            formdata.append('membership', paymenttype);  

            let form = document.createElement('form');
            form.method = 'POST';
            form.action = 'Payment.php'; 
        
        
        for (let [key, value] of formdata.entries()) {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            form.appendChild(input);
        }

        // Append the form to the document body and submit it
        document.body.appendChild(form);
        form.submit();

            // document.getElementById('payment_container_3').style.display = "block";
            // document.getElementById("Body").style.filter = "blur(5px)";
            // document.getElementById("payment_container_3").classList.add("animate-show");
            
        });
        

        function paymnet(){
            let payment_photo_link = document.getElementById('payment_photo_link').value;
            if (payment_photo_link === '') {
                alert('Please fill all the fields');
                return;
            }
            var formData = new FormData();
            formData.append('payment_photo_link', payment_photo_link);
            
            fetch('renewPayment.php', {
                method: 'POST',
                body: formData
            }).then(response => response.text())
            .then(data => {
                if (data === 'Email sent successfully.') {
                    alert('Payment Renewed');
                    document.getElementById('payment_container_3').style.display = "none";
                    document.getElementById("Body").style.filter = "blur(0px)";
                    document.getElementById("payment_container_3").classList.remove("animate-show");
                    location.reload();
                } else {
                    alert('Failed to upload payment slip'+data);
                    console.log(data);
                }
            });
        }
    </script>
</body>

</html>