<?php
include 'mailsend.php';
include 'phpcon.php';
session_start();

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
} else {
    echo "Email is not set in the session.";
    exit();
}

if(isset($_SESSION['userId'])!= null){

    $user_id = $_SESSION['userId'];
    $queryuser = "SELECT * FROM users WHERE user_id = '$user_id'";
    $resultuser = mysqli_query($conn, $queryuser);
    $row = mysqli_fetch_assoc($resultuser);
    $membership = $row['membership_status'];
    
    if($membership == '0'){
        echo "You have not membership.";
        exit();
    }else{

         $Is_id = isset($_POST['In_Id']) ? $_POST['In_Id'] : null;
         $Is_cost = isset($_POST['In_cost']) ? $_POST['In_cost'] : null;
         $date = isset($_POST['date']) ? $_POST['date'] : null;
         $expiry_date = isset($_POST['expireddate']) ? $_POST['expireddate'] : null;
         $payment = isset($_POST['paymnetLink']) ? $_POST['paymnetLink'] : null;

         $query = "SELECT * FROM instructor_user WHERE user_Id = ?";
         $stmt_check = $conn->prepare($query);
         $stmt_check->bind_param("s", $user_id);
         $stmt_check->execute();
         $result = $stmt_check->get_result();

           if ($result->num_rows > 0) {
              echo "You already have Insrtuctor.";
              exit();
         }
    
           $stmt = $conn->prepare("INSERT INTO instructor_user (user_Id, Instructor_Id, s_date, e_date, cost) VALUES (?, ?, ?, ?, ?)");
           $stmt->bind_param("sssss", $user_id, $Is_id, $date, $expiry_date , $Is_cost);

           
           $escaped_path = addslashes($payment);  

           $update_query = "UPDATE users SET instructor_pyamnet_slip = '$escaped_path', instructor = '$Is_id' WHERE user_id = '$user_id'";
           mysqli_query($conn, $update_query);
    

          if ($stmt->execute()) {

               $to = $email;
               $subject = "Instructor purchased";
               $message = "We wanted to let you successfully purchased a instructor.wait until If  the admin approve your payment. ";
               $headers = "From:";
               mailsend($to, $subject, $message, $headers);
         } else {
             echo "Error: " . $stmt->error;
             exit();
         }     
    }
}else{
    echo "Please login to continue";
}

?>
