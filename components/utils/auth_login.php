<?php
require_once 'db_connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $identifier = trim($_POST['username']);
    $password = $_POST['password'];

    // On cherche l'utilisateur par pseudo ou email
    $stmt = $db->prepare("SELECT * FROM adg_users WHERE username = ? OR email = ?");
    $stmt->execute([$identifier, $identifier]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        echo "success";
    } else {
        echo "error";
    }
}