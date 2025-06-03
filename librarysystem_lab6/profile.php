<?php
require_once 'includes/auth_check.php';
require_once 'config/database.php';
requireAuth();

// Secure database fetch
$db = new AuthDatabase();
$conn = $db->connect();
$query = "SELECT * FROM users WHERE user_id = :user_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Redirect if user not found
if (!$user) {
    header("Location: auth/login.php?error=user_not_found");
    exit();
}
?>

<?php include 'includes/header.php'; ?>

<div class="container">
    <h2>User Profile</h2>
    
    <div class="profile-info">
        <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Registered:</strong> <?= date('F j, Y', strtotime($user['created_at'])) ?></p>
        
        <?php if (!empty($user['google_id'])): ?>
            <p class="connected-account">✓ Connected with Google</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>