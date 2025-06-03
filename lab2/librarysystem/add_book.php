<?php
include "db.php";
$result = $conn->query("SELECT * FROM Authors");
?>

<!DOCTYPE html>
<html>
<head><title>Add Book</title></head>
<body>
<h2>Add Book</h2>
<form method="POST" action="insert_book.php">
    Title: <input type="text" name="title" required><br><br>
    Genre: <input type="text" name="genre" required><br><br>
    Price: <input type="text" name="price" required><br><br>
    Author:
    <select name="author_id" required>
        <option value="">-- Select Author --</option>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['author_id']}'>{$row['name']}</option>";
        }
        ?>
    </select><br><br>
    <input type="submit" value="Add Book">
</form>
<br>
<a href="add_author.php">Add Author</a> | <a href="display_books.php">View All Books</a>
</body>
</html>
