<?php
include "db.php";

$result = $conn->query("SELECT * FROM users");

echo "<h2>Registered Users</h2>";
echo "<a href='register.php'>Add New User</a><br><br>";

echo "<table border='1' cellpadding='10'>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Age</th>
</tr>";

while($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['name']}</td>
        <td>{$row['email']}</td>
        <td>{$row['age']}</td>
    </tr>";
}

echo "</table>";
$conn->close();
?>



