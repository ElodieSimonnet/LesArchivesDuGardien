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
    set_flash('error', 'Erreur de sécurité : requête non autorisée.');
    header('Location: ../../profile.php');
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
    set_flash('error', 'Mot de passe actuel incorrect.');
    header('Location: ../../profile.php');
    exit();
}

// MODIFICATION DE L'EMAIL
if ($type === 'email') {
    $newEmail = trim($_POST['email'] ?? '');

    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        set_flash('error', 'L\'adresse email n\'est pas valide.');
        header('Location: ../../profile.php');
        exit();
    }

    // Vérifier que l'email n'est pas déjà pris par un autre utilisateur
    $check = $db->prepare("SELECT id FROM adg_users WHERE email = ? AND id != ?");
    $check->execute([$newEmail, $_SESSION['user_id']]);
    if ($check->fetch()) {
        set_flash('error', 'Cette adresse email est déjà utilisée.');
        header('Location: ../../profile.php');
        exit();
    }

    $update = $db->prepare("UPDATE adg_users SET email = ? WHERE id = ?");
    $update->execute([$newEmail, $_SESSION['user_id']]);

    set_flash('success', 'Email mis à jour avec succès.');
    header('Location: ../../profile.php');
    exit();
}

// MODIFICATION DU NOM D'UTILISATEUR
if ($type === 'username') {
    $newUsername = trim($_POST['username'] ?? '');

    if (empty($newUsername) || strlen($newUsername) < 2 || strlen($newUsername) > 30) {
        set_flash('error', 'Le nom d\'utilisateur doit contenir entre 2 et 30 caractères.');
        header('Location: ../../profile.php');
        exit();
    }

    // Vérifier que le pseudo n'est pas déjà pris
    $check = $db->prepare("SELECT id FROM adg_users WHERE username = ? AND id != ?");
    $check->execute([$newUsername, $_SESSION['user_id']]);
    if ($check->fetch()) {
        set_flash('error', 'Ce nom d\'utilisateur est déjà pris.');
        header('Location: ../../profile.php');
        exit();
    }

    $update = $db->prepare("UPDATE adg_users SET username = ? WHERE id = ?");
    $update->execute([$newUsername, $_SESSION['user_id']]);

    // Mettre à jour la session
    $_SESSION['username'] = $newUsername;

    set_flash('success', 'Nom d\'utilisateur mis à jour avec succès.');
    header('Location: ../../profile.php');
    exit();
}

// MODIFICATION DU MOT DE PASSE
if ($type === 'password') {
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Vérification de la confirmation
    if ($newPassword !== $confirmPassword) {
        set_flash('error', 'Les mots de passe ne correspondent pas.');
        header('Location: ../../profile.php');
        exit();
    }

    // Validation de la robustesse
    if (strlen($newPassword) < 12) {
        set_flash('error', 'Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.');
        header('Location: ../../profile.php');
        exit();
    }
    if (!preg_match('/[A-Z]/', $newPassword)) {
        set_flash('error', 'Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.');
        header('Location: ../../profile.php');
        exit();
    }
    if (!preg_match('/[a-z]/', $newPassword)) {
        set_flash('error', 'Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.');
        header('Location: ../../profile.php');
        exit();
    }
    if (!preg_match('/[0-9]/', $newPassword)) {
        set_flash('error', 'Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.');
        header('Location: ../../profile.php');
        exit();
    }
    if (!preg_match('/[^A-Za-z0-9]/', $newPassword)) {
        set_flash('error', 'Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.');
        header('Location: ../../profile.php');
        exit();
    }

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $update = $db->prepare("UPDATE adg_users SET password = ? WHERE id = ?");
    $update->execute([$hashedPassword, $_SESSION['user_id']]);

    set_flash('success', 'Mot de passe mis à jour avec succès.');
    header('Location: ../../profile.php');
    exit();
}

// Type inconnu
header('Location: ../../profile.php');
exit();
