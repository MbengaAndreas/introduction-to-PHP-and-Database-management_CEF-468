<?php
$conn = new mysqli("localhost", "root", "", "StudentDB");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone_number'];

$sql = "INSERT INTO Students (name, email, phone_number)
        VALUES ('$name', '$email', '$phone')";

if ($conn->query($sql) === TRUE) {
    echo "Student added successfully! <a href='view_students.php'>View Students</a>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
