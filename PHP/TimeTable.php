<?php
 include 'phpcon.php';
 session_start();

$sql = "SELECT day, time_slot, class_name, instructor_name, meta_type FROM timetable ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), time_slot";
$result = $conn->query($sql);
 
$timetable = [];

if ($result->num_rows > 0) {
    
    while($row = $result->fetch_assoc()) {
        $timetable[$row['time_slot']][$row['day']] = [
            'class_name' => $row['class_name'],
            'instructor_name' => $row['instructor_name'],
            'meta_type' => $row['meta_type']
        ];
    }
    echo json_encode($timetable); 
} else {
    echo json_encode([]);
}

$conn->close();
?>