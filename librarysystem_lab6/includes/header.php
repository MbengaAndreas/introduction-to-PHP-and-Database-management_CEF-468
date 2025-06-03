<?php
// includes/header.php

// Add this ABSOLUTE FIRST LINE:
require_once __DIR__ . '/auth_check.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Rest of your existing header content -->
    ...
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
    <link rel="stylesheet" href="/library_system_lab5/assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Library System</div>
            <ul>
                <li><a href="/library_system_lab5/home.php">Home</a></li>
                <?php if (isLoggedIn()): ?>
                    <li><a href="/library_system_lab5/library.php">Library</a></li>
                    <li><a href="/library_system_lab5/profile.php">Profile</a></li>
                    <li><a href="/library_system_lab5/auth/logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="/library_system_lab5/auth/login.php">Login</a></li>
                    <li><a href="/library_system_lab5/auth/register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>