<?php
require_once './backend/controllers/pages-controller.php';
require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secretKey = 'your-secret-key';
$issuedAt = time();
$expirationTime = $issuedAt + 3600;  // jwt valid for 1 hour
$issuer = 'localhost';

// Function to create JWT
function createJWT($userId, $username, $secretKey, $issuer, $issuedAt, $expirationTime) {
    $payload = [
        'iss' => $issuer,
        'iat' => $issuedAt,
        'exp' => $expirationTime,
        'data' => [
            'userId' => $userId,
            'username' => $username
        ]
    ];

    return JWT::encode($payload, $secretKey, 'HS256');
}

// Function to decode JWT
function decodeJWT($jwt, $secretKey) {
    try {
        $decoded = JWT::decode($jwt, new Key($secretKey, 'HS256'));
        return (array) $decoded;
    } catch (Exception $e) {
        return 'Caught exception: '. $e->getMessage();
    }
}

// Creăm o instanță a controllerului și gestionăm cererea
$controller = new PagesController();
$view = new View();

try {
    $page = $controller->handleRequest();
    $view->render($page);
} catch (Exception $e) {
    echo $e->getMessage();
}
