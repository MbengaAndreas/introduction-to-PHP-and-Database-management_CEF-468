<?php
// 1. INITIALIZATION - MUST BE THE FIRST LINE IN THE FILE
session_start();

// 2. ERROR REPORTING (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 3. REQUIRE FILES - UPDATE PATHS AS NEEDED
require __DIR__ . '/../includes/auth_check.php';
require __DIR__ . '/../includes/csrf_token.php';

// 4. DATABASE CONFIGURATION - UPDATE THESE!
$db_host = 'localhost';
$db_name = 'your_database_name';  // Change to your actual DB name
$db_user = 'your_username';      // Your MySQL username
$db_pass = 'your_password';      // Your MySQL password

// 5. DATABASE CONNECTION
try {
    $conn = new PDO(
        "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Database connection failed. Error: " . $e->getMessage());
}

// 6. FORM PROCESSING LOGIC (replaces process_book.php functionality)
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // A) CSRF VALIDATION
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Security error: Invalid CSRF token");
    }

    // B) INPUT SANITIZATION
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_STRING);
    $genre = filter_input(INPUT_POST, 'genre', FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $year = filter_input(INPUT_POST, 'publication_year', FILTER_SANITIZE_NUMBER_INT);

    // C) VALIDATION
    if (empty($title) || empty($author)) {
        $error = "Title and Author are required";
    } elseif (!is_numeric($price) || $price <= 0) {
        $error = "Price must be a positive number";
    } else {
        // D) DATABASE INSERTION
        try {
            $stmt = $conn->prepare("
                INSERT INTO lab5_books 
                (title, author, genre, price, publication_year, added_by) 
                VALUES (:title, :author, :genre, :price, :year, :user_id)
            ");
            
            $stmt->execute([
                ':title' => $title,
                ':author' => $author,
                ':genre' => $genre,
                ':price' => $price,
                ':year' => $year,
                ':user_id' => $_SESSION['user_id'] // From your auth system
            ]);
            
            // Redirect after successful insertion
            header("Location: view_books.php?success=book_added");
            exit();
            
        } catch (PDOException $e) {
            $error = "Error saving book: " . $e->getMessage();
            error_log("Database error: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Book</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .error { color: red; padding: 10px; background: #ffeeee; border: 1px solid red; }
        .form-group { margin-bottom: 15px; }
        label { display: inline-block; width: 150px; font-weight: bold; }
        input[type="text"], input[type="number"] { padding: 8px; width: 300px; }
        button { padding: 10px 20px; background: #4CAF50; color: white; border: none; cursor: pointer; }
        button:hover { background: #45a049; }
    </style>
</head>
<body>
    <h1>Add New Book</h1>
    
    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <form method="post">
        <!-- CSRF Protection -->
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
        
        <div class="form-group">
            <label for="title">Title*:</label>
            <input type="text" id="title" name="title" required 
                   value="<?= isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '' ?>">
        </div>
        
        <div class="form-group">
            <label for="author">Author*:</label>
            <input type="text" id="author" name="author" required
                   value="<?= isset($_POST['author']) ? htmlspecialchars($_POST['author']) : '' ?>">
        </div>
        
        <div class="form-group">
            <label for="genre">Genre:</label>
            <input type="text" id="genre" name="genre"
                   value="<?= isset($_POST['genre']) ? htmlspecialchars($_POST['genre']) : '' ?>">
        </div>
        
        <div class="form-group">
            <label for="price">Price ($):</label>
            <input type="number" step="0.01" min="0" id="price" name="price" required
                   value="<?= isset($_POST['price']) ? htmlspecialchars($_POST['price']) : '' ?>">
        </div>
        
        <div class="form-group">
            <label for="publication_year">Year:</label>
            <input type="number" id="publication_year" name="publication_year" 
                   min="1900" max="<?= date('Y') ?>" required
                   value="<?= isset($_POST['publication_year']) ? htmlspecialchars($_POST['publication_year']) : date('Y') ?>">
        </div>
        
        <button type="submit">Add Book</button>
    </form>
</body>
</html>