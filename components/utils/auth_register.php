<?php
require_once 'db_connection.php'; // Gère la session et le token

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // VÉRIFICATION DU JETON CSRF
    // On vérifie que le badge est valide avant d'autoriser l'inscription
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo "Erreur de sécurité : Requête non autorisée.";
        exit;
    }

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Vérification de la confirmation du mot de passe
    if ($password !== $confirmPassword) {
        echo "Les mots de passe ne correspondent pas.";
        exit;
    }

    // Validation de la robustesse du mot de passe
    if (strlen($password) < 12) {
        echo "Le mot de passe doit contenir au moins 12 caractères.";
        exit;
    }
    if (!preg_match('/[A-Z]/', $password)) {
        echo "Le mot de passe doit contenir au moins une majuscule.";
        exit;
    }
    if (!preg_match('/[a-z]/', $password)) {
        echo "Le mot de passe doit contenir au moins une minuscule.";
        exit;
    }
    if (!preg_match('/[0-9]/', $password)) {
        echo "Le mot de passe doit contenir au moins un chiffre.";
        exit;
    }
    if (!preg_match('/[^A-Za-z0-9]/', $password)) {
        echo "Le mot de passe doit contenir au moins un caractère spécial.";
        exit;
    }

    // Hachage du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $db->prepare("INSERT INTO adg_users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword]);
        echo "success";
    } catch (PDOException $e) {
        // En cas de doublon (pseudo ou email déjà pris)
        echo "Cet aventurier (ou cet email) existe déjà.";
    }
}
?>