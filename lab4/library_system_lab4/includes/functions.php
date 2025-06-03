<?php
// includes/functions.php

/**
 * Sanitize input data to prevent XSS and SQL injection
 */
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

/**
 * Redirect to a specific URL
 */
function redirect($url) {
    header("Location: " . $url);
    exit();
}

/**
 * Display formatted error message
 */
function displayError($message) {
    return '<div class="alert alert-danger">' . sanitizeInput($message) . '</div>';
}

/**
 * Display formatted success message
 */
function displaySuccess($message) {
    return '<div class="alert alert-success">' . sanitizeInput($message) . '</div>';
}

/**
 * Format price with currency symbol
 */
function formatPrice($price) {
    return '$' . number_format((float)$price, 2);
}

/**
 * Check if a book is available for borrowing
 */
function isBookAvailable($book_id) {
    $db = new Database();
    $conn = $db->connect();

    $query = "SELECT COUNT(*) as count FROM BookLoans 
              WHERE book_id = :book_id AND return_date IS NULL";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':book_id', $book_id);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] == 0;
}

/**
 * Get all members for dropdown selection
 */
function getAllMembers() {
    $db = new Database();
    $conn = $db->connect();

    $query = "SELECT member_id, name FROM Members ORDER BY name";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get book details by ID
 */
function getBookById($book_id) {
    $db = new Database();
    $conn = $db->connect();

    $query = "SELECT * FROM Books WHERE book_id = :book_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':book_id', $book_id);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Generate book type badge (for UI display)
 */
function getBookTypeBadge($type) {
    $class = ($type === 'ebook') ? 'badge-info' : 'badge-primary';
    return '<span class="badge ' . $class . '">' . ucfirst($type) . '</span>';
}

/**
 * Calculate days a book has been borrowed
 */
function getDaysBorrowed($loan_date) {
    $loan = new DateTime($loan_date);
    $now = new DateTime();
    return $now->diff($loan)->days;
}

/**
 * Include this at the top of your pages to prevent direct access
 */
function preventDirectAccess() {
    if (!defined('IN_APP')) {
        die('Direct access not permitted');
    }
}