<?php
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function createUsernameFromEmail($email) {
    return strtok($email, '@');
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function displayError($message) {
    return '<div class="alert alert-danger">' . sanitizeInput($message) . '</div>';
}

function displaySuccess($message) {
    return '<div class="alert alert-success">' . sanitizeInput($message) . '</div>';
}

function formatPrice($price) {
    return '$' . number_format((float)$price, 2);
}

function getCurrentUser() {
    if (isset($_SESSION['user_id'])) {
        $db = new AuthDatabase();
        $conn = $db->connect();
        $query = "SELECT * FROM users WHERE user_id = :user_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return null;
}
?>