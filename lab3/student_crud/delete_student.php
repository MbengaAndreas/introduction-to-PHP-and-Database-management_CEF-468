<?php
$conn = new mysqli("localhost", "root", "", "StudentDB");

$id = $_GET['id'];
$sql = "DELETE FROM Students WHERE student_id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Student deleted. <a href='view_students.php'>Back</a>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
