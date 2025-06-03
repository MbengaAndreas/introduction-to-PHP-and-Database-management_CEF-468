<?php
include "db.php";

$title = trim($_POST['title']);
$genre = trim($_POST['genre']);
$price = trim($_POST['price']);
$author_id = $_POST['author_id'];

$errors = [];

if (empty($title)) $errors[] = "Book title is required.";
if (empty($genre)) $errors[] = "Genre is required.";
if (!is_numeric($price) || $price <= 0) $errors[] = "Price must be a valid number.";
if (empty($author_id)) $errors[] = "Author is required.";

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color:red;'>$error</p>";
    }
    echo "<a href='add_book.php'>Back to form</a>";
    exit();
}

$sql = "INSERT INTO Books (title, genre, price, author_id)
        VALUES ('$title', '$genre', $price, $author_id)";

if ($conn->query($sql) === TRUE) {
    echo "Book added successfully. <a href='add_book.php'>Add Another</a> | <a href='display_books.php'>View All</a>";
} else {
 echo "Error: " . $conn->error;
}
$conn->close();
?>
