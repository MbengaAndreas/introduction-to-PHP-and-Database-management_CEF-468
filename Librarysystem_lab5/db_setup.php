<?php
require_once 'config/database.php';

try {
    $db = new AuthDatabase();
    $conn = $db->connect();
    
    // Enable foreign key checks
    $conn->exec("SET FOREIGN_KEY_CHECKS=0");
    
    // Create tables
    $conn->exec("CREATE TABLE IF NOT EXISTS users (
        user_id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255),
        google_id VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    $conn->exec("CREATE TABLE IF NOT EXISTS lab5_books (
        book_id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        author VARCHAR(100) NOT NULL,
        genre VARCHAR(50),
        price DECIMAL(10,2),
        publication_year INT,
        added_by INT,
        FOREIGN KEY (added_by) REFERENCES users(user_id)
    )");
    
    $conn->exec("SET FOREIGN_KEY_CHECKS=1");
    
    echo "Database setup completed successfully!";
} catch (PDOException $e) {
    die("Database setup failed: " . $e->getMessage());
}
?>