<?php
    $cookie_lifetime = 7 * 24 * 60 * 60; // 1 week
    session_set_cookie_params($cookie_lifetime); 
    session_start();

    if(isset($_SESSION['email'])!= null){
        header("Location:./index.html");
        exit;
    }
    
    include 'phpcon.php';

    

    if($conn === false){
        die("ERROR: Could not connect. " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE email = '$email' AND Password = '$password'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){

        echo 'Login Successful';
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        $_SESSION['userId'] = $row['user_id'];
        
    }else{
        $_SESSION['login_error'] = 'Invalid email or password';
        echo'Invalid email or password';
        
    }
    $conn->close();











?>