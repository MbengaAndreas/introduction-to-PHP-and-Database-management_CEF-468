<?php
$conn = new mysqli("localhost", "root", "", "webAppDB");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>



