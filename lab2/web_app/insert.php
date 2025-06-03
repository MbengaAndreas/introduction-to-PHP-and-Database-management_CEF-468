<?php
include "db.php";

$name = $_POST['name'];
$email = $_POST['email'];
$age = $_POST['age'];

$sql = "INSERT INTO users (name, email, age)
        VALUES ('$name', '$email', $age)";

if ($conn->query($sql) === TRUE) {
    echo "User added successfully. <a href='users.php'>View All Users</a>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>




