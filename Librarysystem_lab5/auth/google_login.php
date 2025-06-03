<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/google_oauth_config.php';

$client = new Google_Client();
$client->setClientId($config['client_id']);
$client->setClientSecret($config['client_secret']);
$client->setRedirectUri($config['redirect_uri']);
$client->addScope('email');
$client->addScope('profile');

$authUrl = $client->createAuthUrl();
header('Location: ' . $authUrl);
exit();
