<?php
// includes/auth_check.php

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Redirect unauthorized users
 */
function requireAuth() {
    if (!isLoggedIn()) {
        header("Location: /library_system_lab5/auth/login.php");
        exit();
    }
}

/**
 * Check if user is admin
 */ 
function isAdmin() {
    return isLoggedIn() && ($_SESSION['is_admin'] ?? false);
}

?>