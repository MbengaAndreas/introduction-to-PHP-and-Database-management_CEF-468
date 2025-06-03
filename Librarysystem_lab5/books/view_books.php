<?php
define('ROOT_DIR', realpath(__DIR__ . '/..'));
require_once ROOT_DIR . '/includes/auth_check.php';
require_once ROOT_DIR . '/config/database.php';
require_once ROOT_DIR . '/includes/functions.php';
requireAuth();

// Database connection and query
try {
    $db = new AuthDatabase();
    $conn = $db->connect();
    
    $query = "SELECT * FROM lab5_books";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Ensure $books is always an array, even if empty
    if (!is_array($books)) {
        $books = [];
    }
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
    $books = []; // Set empty array if query fails
}
?>

<?php require_once ROOT_DIR . '/includes/header.php'; ?>

<div class="container">
    <h2>Book List</h2>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert success">
            <?php
            switch($_GET['success']) {
                case 'book_added': echo "Book added successfully!"; break;
                case 'book_deleted': echo "Book deleted successfully!"; break;
                case 'book_updated': echo "Book updated successfully!"; break;
            }
            ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
        <div class="alert error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Genre</th>
                <th>Price</th>
                <th>Year</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
            <tr>
                <td><?= htmlspecialchars($book['title']) ?></td>
                <td><?= htmlspecialchars($book['author']) ?></td>
                <td><?= htmlspecialchars($book['genre'] ?? '') ?></td>
                <td>$<?= number_format($book['price'], 2) ?></td>
                <td><?= $book['publication_year'] ?></td>
                <td>
                    <a href="edit_book.php?id=<?= $book['book_id'] ?>" class="btn">Edit</a>
                    <a href="delete_book.php?id=<?= $book['book_id'] ?>" 
                       class="btn danger" 
                       onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div class="actions">
        <a href="add_book.php" class="btn">Add New Book</a>
    </div>
</div>

<?php require_once ROOT_DIR . '/includes/footer.php'; ?>