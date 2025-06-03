<?php
include "db.php";

$name = trim($_POST['name']);
$email = trim($_POST['email']);

if (empty($name)) {
    echo "Author name is required. <a href='add_author.php'>Back</a>";
    exit();
}

$sql = "INSERT INTO Authors (name, email) VALUES ('$name', '$email')";
if ($conn->query($sql) === TRUE) {
    echo "Author added successfully. <a href='add_author.php'>Add Another</a> | <a href='add_book.php'>Add Book</a>";
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
?>

