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