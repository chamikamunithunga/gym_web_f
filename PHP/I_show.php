
<?php

include 'phpcon.php';
 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT Instructor_Id, Name, price, description,In_photo FROM instructor_show";   
$result = $conn->query($sql);




if ($result->num_rows > 0) {

    $data = array();
    while ($row = $result->fetch_assoc()) {
        // $data[] = $row; 
        $instructorId = $row['Instructor_Id'];
        // Fetch the user count for the current instructor
        $sqlCount = "SELECT COUNT(*) as count FROM instructor_user WHERE Instructor_Id = '$instructorId'";
        $resultCount = $conn->query($sqlCount);
        $rowCount = $resultCount->fetch_assoc();
        $userCount = $rowCount['count'];

        // Add the user count to the current instructor's data
        $row['user_count'] = $userCount;

        $sqlAvilablestatus ="SELECT * FROM instrutor WHERE Instrutor_ID = '$instructorId'";
        $resultAvilablestatus = $conn->query($sqlAvilablestatus);
        $rowAvilablestatus = $resultAvilablestatus->fetch_assoc();
        $row['status'] = $rowAvilablestatus['Avilable_Status'];
        

        // Add instructor data to the array
        $data[] = $row;  
    }
    echo json_encode($data);
   
} else {
    echo json_encode([]);
}




$conn->close();
?>
