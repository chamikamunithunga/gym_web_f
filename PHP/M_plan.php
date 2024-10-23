<?php
include 'phpcon.php';
 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT p_id, name, price, benefits_1,benefits_2	,benefits_3,benefits_4,	benefits_5 FROM membership";   
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;  
    }
    echo json_encode($data);
   
} else {
    echo json_encode([]);
}





$conn->close();
?>
