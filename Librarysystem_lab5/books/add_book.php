<?php
// Use absolute paths with realpath() for 100% reliability
define('ROOT_DIR', realpath(__DIR__ . '/..'));
require_once ROOT_DIR . '/config/database.php';
require_once ROOT_DIR . '/includes/functions.php';
require_once ROOT_DIR . '/includes/auth_check.php';

requireAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new AuthDatabase();
        $conn = $db->connect();

        // Validate and sanitize inputs
        $title = sanitizeInput($_POST['title'] ?? '');
        $author = sanitizeInput($_POST['author'] ?? '');
        $genre = sanitizeInput($_POST['genre'] ?? '');
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        $year = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT, [
            'options' => [
                'min_range' => 1900,
                'max_range' => date('Y')
            ]
        ]);

        if (empty($title) || empty($author) || $price === false || $year === false) {
            throw new Exception('Invalid input data');
        }

        $query = "INSERT INTO lab5_books 
                 (title, author, genre, price, publication_year, added_by) 
                 VALUES (:title, :author, :genre, :price, :year, :user_id)";
        
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':title' => $title,
            ':author' => $author,
            ':genre' => $genre,
            ':price' => $price,
            ':year' => $year,
            ':user_id' => $_SESSION['user_id']
        ]);

        header("Location: view_books.php?success=book_added");
        exit();

    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Include headers using absolute path
require_once ROOT_DIR . '/includes/header.php';
?>

<div class="container">
    <h2>Add New Book</h2>
    
    <?php if (!empty($error)): ?>
        <div class="alert error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <!-- Form fields remain the same as before -->
        <div class="form-group">
            <label>Title*</label>
            <input type="text" name="title" required>
        </div>
        <div class="form-group">
            <label>Author*</label>
            <input type="text" name="author" required>
        </div>
        <div class="form-group">
            <label>Genre</label>
            <input type="text" name="genre">
        </div>
        <div class="form-group">
            <label>Price*</label>
            <input type="number" step="0.01" name="price" required>
        </div>
        <div class="form-group">
            <label>Publication Year*</label>
            <input type="number" name="year" required 
                   min="1900" max="<?= date('Y') ?>">
        </div>
        <button type="submit" class="btn">Add Book</button>
    </form>
</div>

<?php require_once ROOT_DIR . '/includes/footer.php'; ?>