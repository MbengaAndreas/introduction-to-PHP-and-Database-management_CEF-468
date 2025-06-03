<?php
define('ROOT_DIR', realpath(__DIR__ . '/..'));
require_once ROOT_DIR . '/includes/auth_check.php';
require_once ROOT_DIR . '/config/database.php';
require_once ROOT_DIR . '/includes/functions.php';
requireAuth();

$db = new AuthDatabase();
$conn = $db->connect();

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // First verify the book exists and belongs to the current user (or admin)
    $query = "SELECT * FROM lab5_books WHERE book_id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $book_id);
    $stmt->execute();
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($book) {
        // Delete the book
        $delete_query = "DELETE FROM lab5_books WHERE book_id = :id";
        $delete_stmt = $conn->prepare($delete_query);
        $delete_stmt->bindParam(':id', $book_id);
        
        if ($delete_stmt->execute()) {
            header("Location: view_books.php?success=book_deleted");
            exit();
        } else {
            $error = "Failed to delete book";
        }
    } else {
        $error = "Book not found";
    }
} else {
    $error = "No book ID specified";
}

// If we get here, there was an error
header("Location: view_books.php?error=" . urlencode($error ?? "Unknown error"));
exit();
?>