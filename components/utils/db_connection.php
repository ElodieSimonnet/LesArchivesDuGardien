<?php

// CONFIGURATION SÉCURITÉ SESSIONS
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => false, // à mettre à true quand on est en ligne avec https
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

// GENERATION DU JETON CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// CONNEXION BDD
try {
    $db = new PDO(
        "mysql:host=127.0.0.1;port=3306;dbname=lesarchivesdugardien;charset=utf8",
        "root",
        "",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>