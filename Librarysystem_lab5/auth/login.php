<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new AuthDatabase();
    $conn = $db->connect();

    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() === 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            
            header("Location: ../library.php");
            exit();
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "User not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="/library_system_lab5/assets/css/style.css">
</head>
<body>
    <div class="auth-container">
        <h2>Login</h2>
        <?php if (isset($_GET['registration'])): ?>
            <div class="alert success">Registration successful! Please login.</div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert error"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register</a></p>
        <div class="oauth-option">
            <p>Or login with:</p>
            <a href="google_login.php" class="google-btn">Google</a>
        </div>
    </div>
</body>
</html>