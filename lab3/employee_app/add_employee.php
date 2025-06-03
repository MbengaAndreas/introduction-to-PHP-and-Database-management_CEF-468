<?php
include "db.php";
$departments = $conn->query("SELECT * FROM Departments");
?>

<!DOCTYPE html>
<html>
<head><title>Add Employee</title></head>
<body>
<h2>Add Employee</h2>
<form method="POST" action="insert_employee.php">
    ID: <input type="text" name="emp_id" required><br><br>
    Name: <input type="text" name="emp_name" required><br><br>
    Salary: <input type="text" name="emp_salary" required><br><br>
    Department:
    <select name="dept_id" required>
        <option value="">-- Select Department --</option>
        <?php while ($d = $departments->fetch_assoc()) {
            echo "<option value='{$d['dept_id']}'>{$d['dept_name']}</option>";
        } ?>
    </select><br><br>
    <input type="submit" value="Add Employee">
</form>
</body>
</html>

