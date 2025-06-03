<?php
require_once 'includes/auth_check.php';
require_once 'config/database.php';
requireAuth();
?>

<?php include 'includes/header.php'; ?>

<div class="container">
    <h2>Library Dashboard</h2>
    
    <div class="actions">
        <a href="books/add_book.php" class="btn">Add New Book</a>
        <a href="books/view_books.php" class="btn">View All Books</a>
    </div>
    
    <div class="stats">
        <?php
        $db = new AuthDatabase();
        $conn = $db->connect();
        
        // Count books
        $stmt = $conn->query("SELECT COUNT(*) FROM lab5_books");
        $bookCount = $stmt->fetchColumn();
        
        // Count users
        $stmt = $conn->query("SELECT COUNT(*) FROM users");
        $userCount = $stmt->fetchColumn();
        ?>
        
        <div class="stat-card">
            <h3>Total Books</h3>
            <p><?= $bookCount ?></p>
        </div>
        
        <div class="stat-card">
            <h3>Registered Users</h3>
            <p><?= $userCount ?></p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>