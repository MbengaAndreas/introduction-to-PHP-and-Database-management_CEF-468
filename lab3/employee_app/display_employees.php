<?php
include "db.php";

$sql = "SELECT e.emp_id, e.emp_name, e.emp_salary, d.dept_name, d.dept_location
        FROM Employees e
        JOIN Departments d ON e.dept_id = d.dept_id";
$result = $conn->query($sql);

echo "<h2>Employee List</h2>";
echo "<table border='1'>
<tr><th>ID</th><th>Name</th><th>Salary</th><th>Department</th><th>Location</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['emp_id']}</td>
        <td>{$row['emp_name']}</td>
        <td>{$row['emp_salary']}</td>
        <td>{$row['dept_name']}</td>
        <td>{$row['dept_location']}</td>
    </tr>";
}

echo "</table>";
$conn->close();
?>
