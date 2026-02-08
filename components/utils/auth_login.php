<?php
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // VÉRIFICATION DU JETON CSRF
    // On compare le jeton reçu du formulaire avec celui en session
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        // En cas d'échec, on arrête tout immédiatement
        echo "Erreur de sécurité : session expirée ou requête invalide.";
        exit;
    }

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