<?php
$conn = new mysqli("localhost", "root", "", "EmployeeDB");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

