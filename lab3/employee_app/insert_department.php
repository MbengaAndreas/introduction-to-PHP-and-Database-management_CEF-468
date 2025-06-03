<?php
include "db.php";

$name = trim($_POST['dept_name']);
$location = trim($_POST['dept_location']);

if ($name == "" || $location == "") {
    echo "All fields are required. <a href='add_department.php'>Go Back</a>";
    exit();
}

$sql = "INSERT INTO Departments (dept_name, dept_location) VALUES ('$name', '$location')";

if ($conn->query($sql) === TRUE) {
    echo "Department added. <a href='add_department.php'>Add Another</a>";
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
?>

