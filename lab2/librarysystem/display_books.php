<?php
include "db.php";

$sql = "SELECT Books.title, Books.genre, Books.price, Authors.name AS author_name
        FROM Books
        JOIN Authors ON Books.author_id = Authors.author_id";

$result = $conn->query($sql);

echo "<h2>Library Books</h2>";
echo "<a href='add_author.php'>Add Author</a> | <a href='add_book.php'>Add Book</a><br><br>";

echo "<table border='1' cellpadding='8'>
<tr><th>Title</th><th>Genre</th><th>Price</th><th>Author</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['title']}</td>
        <td>{$row['genre']}</td>
        <td>{$row['price']}</td>
        <td>{$row['author_name']}</td>
    </tr>";
}

echo "</table>";
$conn->close();
?>

