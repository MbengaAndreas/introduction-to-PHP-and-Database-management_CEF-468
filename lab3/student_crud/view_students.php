<?php
$conn = new mysqli("localhost", "root", "", "StudentDB");

$result = $conn->query("SELECT * FROM Students");
?>

<h2>Student Records</h2>
<a href="add_student.php">Add New Student</a><br><br>

<table border="1">
<tr>
    <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Actions</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['student_id'] ?></td>
    <td><?= $row['name'] ?></td>
    <td><?= $row['email'] ?></td>
    <td><?= $row['phone_number'] ?></td>
    <td>
        <a href="edit_student.php?id=<?= $row['student_id'] ?>">Edit</a> |
        <a href="delete_student.php?id=<?= $row['student_id'] ?>" onclick="return confirm('Delete?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>

<?php $conn->close(); ?>
