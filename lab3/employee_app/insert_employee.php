<?php
include "db.php";

$id = $_POST['emp_id'];
$name = trim($_POST['emp_name']);
$salary = trim($_POST['emp_salary']);
$dept_id = $_POST['dept_id'];

$errors = [];

if (!is_numeric($id)) $errors[] = "Employee ID must be a number.";
if (empty($name)) $errors[] = "Employee name is required.";
if (!is_numeric($salary) || $salary <= 0) $errors[] = "Salary must be a positive number.";
if (empty($dept_id)) $errors[] = "You must select a department.";

if (!empty($errors)) {
    foreach ($errors as $e) echo "<p style='color:red;'>$e</p>";
    echo "<a href='add_employee.php'>Go Back</a>";
    exit();
}

$sql = "INSERT INTO Employees (emp_id, emp_name, emp_salary, dept_id)
        VALUES ($id, '$name', $salary, $dept_id)";

if ($conn->query($sql) === TRUE) {
    echo "Employee added. <a href='add_employee.php'>Add Another</a>";
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
?>

