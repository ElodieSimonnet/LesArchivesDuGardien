<?php
require_once 'db_connection.php';

// Vérification de la connexion
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../profile.php');
    exit();
}

// Vérification CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    header('Location: ../../profile.php?error=csrf');
    exit();
}

$type = $_POST['type'] ?? '';
$currentPassword = $_POST['current_password'] ?? '';

// Récupérer l'utilisateur en BDD
$stmt = $db->prepare("SELECT * FROM adg_users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header('Location: ../../index.php');
    exit();
}

// Vérification du mot de passe actuel (obligatoire pour toute modification)
if (!password_verify($currentPassword, $user['password'])) {
    header('Location: ../../profile.php?error=wrong_password');
    exit();
}

// MODIFICATION DE L'EMAIL
if ($type === 'email') {
    $newEmail = trim($_POST['email'] ?? '');

    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        header('Location: ../../profile.php?error=invalid_email');
        exit();
    }

    // Vérifier que l'email n'est pas déjà pris par un autre utilisateur
    $check = $db->prepare("SELECT id FROM adg_users WHERE email = ? AND id != ?");
    $check->execute([$newEmail, $_SESSION['user_id']]);
    if ($check->fetch()) {
        header('Location: ../../profile.php?error=duplicate_email');
        exit();
    }

    $update = $db->prepare("UPDATE adg_users SET email = ? WHERE id = ?");
    $update->execute([$newEmail, $_SESSION['user_id']]);

    header('Location: ../../profile.php?success=email_updated');
    exit();
}

// MODIFICATION DU NOM D'UTILISATEUR
if ($type === 'username') {
    $newUsername = trim($_POST['username'] ?? '');

    if (empty($newUsername) || strlen($newUsername) < 2 || strlen($newUsername) > 30) {
        header('Location: ../../profile.php?error=invalid_username');
        exit();
    }

    // Vérifier que le pseudo n'est pas déjà pris
    $check = $db->prepare("SELECT id FROM adg_users WHERE username = ? AND id != ?");
    $check->execute([$newUsername, $_SESSION['user_id']]);
    if ($check->fetch()) {
        header('Location: ../../profile.php?error=duplicate_username');
        exit();
    }

    $update = $db->prepare("UPDATE adg_users SET username = ? WHERE id = ?");
    $update->execute([$newUsername, $_SESSION['user_id']]);

    // Mettre à jour la session
    $_SESSION['username'] = $newUsername;

    header('Location: ../../profile.php?success=username_updated');
    exit();
}

// MODIFICATION DU MOT DE PASSE
if ($type === 'password') {
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Vérification de la confirmation
    if ($newPassword !== $confirmPassword) {
        header('Location: ../../profile.php?error=password_mismatch');
        exit();
    }

    // Validation de la robustesse
    if (strlen($newPassword) < 12) {
        header('Location: ../../profile.php?error=weak_password');
        exit();
    }
    if (!preg_match('/[A-Z]/', $newPassword)) {
        header('Location: ../../profile.php?error=weak_password');
        exit();
    }
    if (!preg_match('/[a-z]/', $newPassword)) {
        header('Location: ../../profile.php?error=weak_password');
        exit();
    }
    if (!preg_match('/[0-9]/', $newPassword)) {
        header('Location: ../../profile.php?error=weak_password');
        exit();
    }
    if (!preg_match('/[^A-Za-z0-9]/', $newPassword)) {
        header('Location: ../../profile.php?error=weak_password');
        exit();
    }

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $update = $db->prepare("UPDATE adg_users SET password = ? WHERE id = ?");
    $update->execute([$hashedPassword, $_SESSION['user_id']]);

    header('Location: ../../profile.php?success=password_updated');
    exit();
}

// Type inconnu
header('Location: ../../profile.php');
exit();
