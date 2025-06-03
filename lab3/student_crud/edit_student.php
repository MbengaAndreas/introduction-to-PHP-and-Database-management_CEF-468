<?php
$conn = new mysqli("localhost", "root", "", "StudentDB");

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM Students WHERE student_id = $id");
$row = $result->fetch_assoc();
?>

<h2>Edit Student</h2>
<form method="post" action="update_student.php">
    <input type="hidden" name="student_id" value="<?= $row['student_id'] ?>">
    Name: <input type="text" name="name" value="<?= $row['name'] ?>" required><br><br>
    Email: <input type="email" name="email" value="<?= $row['email'] ?>" required><br><br>
    Phone Number: <input type="text" name="phone_number" value="<?= $row['phone_number'] ?>" required><br><br>
    <input type="submit" value="Update">
</form>

