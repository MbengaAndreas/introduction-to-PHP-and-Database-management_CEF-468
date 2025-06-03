<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new AuthDatabase();
    $conn = $db->connect();

    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        header("Location: login.php?registration=success");
    } catch(PDOException $e) {
        $error = "Registration failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="/library_system_lab5/assets/css/style.css">
</head>
<body>
    <div class="auth-container">
        <h2>Register</h2>
        <?php if (isset($error)): ?>
            <div class="alert error"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>