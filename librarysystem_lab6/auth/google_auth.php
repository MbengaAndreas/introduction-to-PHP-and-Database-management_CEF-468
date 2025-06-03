<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/google_oauth_config.php';
require_once __DIR__ . '/../includes/functions.php';

session_start();

try {
    $client = new Google_Client();
    $client->setClientId($config['client_id']);
    $client->setClientSecret($config['client_secret']);
    $client->setRedirectUri($config['redirect_uri']);
    $client->addScope('email');
    $client->addScope('profile');

    if (isset($_GET['code'])) {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        if (isset($token['error'])) {
            throw new Exception('Google token error: ' . $token['error']);
        }
        $client->setAccessToken($token);
        $oauth = new Google\Service\Oauth2($client);
        $userData = $oauth->userinfo->get();

        // Database connection
        $db = new AuthDatabase();
        $conn = $db->connect();

        // Check if user exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $userData->email);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            // New user
            $stmt = $conn->prepare("INSERT INTO users (username, email, google_id) VALUES (:username, :email, :google_id)");
            $username = createUsernameFromEmail($userData->email);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $userData->email);
            $stmt->bindParam(':google_id', $userData->id);
            $stmt->execute();
            $user_id = $conn->lastInsertId();
        } else {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $user_id = $user['user_id'];
            $username = $user['username'];
        }

        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $userData->email;

        header("Location: ../library.php");
        exit();
    } else {
        header("Location: ../auth/login.php");
        exit();
    }
} catch (Exception $e) {
    error_log('Google Auth Error: ' . $e->getMessage());
    header("Location: ../auth/login.php?error=google_auth_failed");
    exit();
}

