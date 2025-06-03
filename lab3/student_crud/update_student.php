<?php
$conn = new mysqli("localhost", "root", "", "StudentDB");

$id = $_POST['student_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone_number'];

$sql = "UPDATE Students SET name='$name', email='$email', phone_number='$phone' WHERE student_id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Record updated! <a href='view_students.php'>View Students</a>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
