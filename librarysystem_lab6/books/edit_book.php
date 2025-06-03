<?php
define('ROOT_DIR', realpath(__DIR__ . '/..'));
require_once ROOT_DIR . '/includes/auth_check.php';
require_once ROOT_DIR . '/config/database.php';
require_once ROOT_DIR . '/includes/functions.php';
requireAuth();

// Initialize variables
$book = [];
$error = '';

try {
    $db = new AuthDatabase();
    $conn = $db->connect();

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $book_id = $_POST['book_id'];
        $title = sanitizeInput($_POST['title']);
        $author = sanitizeInput($_POST['author']);
        $genre = sanitizeInput($_POST['genre']);
        $price = (float)$_POST['price'];
        $year = (int)$_POST['year'];

        $query = "UPDATE lab5_books SET 
                 title = :title, 
                 author = :author, 
                 genre = :genre, 
                 price = :price, 
                 publication_year = :year 
                 WHERE book_id = :id";
        
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':title' => $title,
            ':author' => $author,
            ':genre' => $genre,
            ':price' => $price,
            ':year' => $year,
            ':id' => $book_id
        ]);

        header("Location: view_books.php?success=book_updated");
        exit();
    }

    // Get book data for editing
    if (isset($_GET['id'])) {
        $query = "SELECT * FROM lab5_books WHERE book_id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();
        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$book) {
            throw new Exception("Book not found");
        }
    } else {
        throw new Exception("No book ID specified");
    }

} catch (Exception $e) {
    $error = $e->getMessage();
    error_log("Edit Book Error: " . $error);
}
?>

<?php require_once ROOT_DIR . '/includes/header.php'; ?>

<div class="container">
    <h2>Edit Book</h2>
    
    <?php if ($error): ?>
        <div class="alert error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <input type="hidden" name="book_id" value="<?= $book['book_id'] ?>">
        
        <div class="form-group">
            <label>Title*</label>
            <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>
        </div>
        
        <div class="form-group">
            <label>Author*</label>
            <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>
        </div>
        
        <div class="form-group">
            <label>Genre</label>
            <input type="text" name="genre" value="<?= htmlspecialchars($book['genre'] ?? '') ?>">
        </div>
        
        <div class="form-group">
            <label>Price*</label>
            <input type="number" step="0.01" name="price" 
                   value="<?= htmlspecialchars($book['price']) ?>" required>
        </div>
        
        <div class="form-group">
            <label>Publication Year*</label>
            <input type="number" name="year" 
                   value="<?= htmlspecialchars($book['publication_year']) ?>" 
                   min="1900" max="<?= date('Y') ?>" required>
        </div>
        
        <button type="submit" class="btn">Update Book</button>
        <a href="view_books.php" class="btn">Cancel</a>
    </form>
</div>

<?php require_once ROOT_DIR . '/includes/footer.php'; ?>