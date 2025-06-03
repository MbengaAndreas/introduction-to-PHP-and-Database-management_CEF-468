<?php include 'includes/header.php'; ?>

<div class="container">
    <h1>Welcome to the Library System</h1>
    
    <?php if (isLoggedIn()): ?>
        <p>Hello, <?= htmlspecialchars($_SESSION['username']) ?>! 
           <a href="library.php">Go to Library</a></p>
    <?php else: ?>
        <p>Please <a href="auth/login.php">login</a> or 
           <a href="auth/register.php">register</a> to access the library.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>