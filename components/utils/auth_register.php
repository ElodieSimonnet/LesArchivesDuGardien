<?php
require_once __DIR__ . '/../../models/Database.php';
$db = Database::getConnection();

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {


if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header('HTTP/1.1 403 Forbidden');
        echo json_encode(['status' => 'error', 'message' => 'Erreur de sécurité : Requête non autorisée.']);
        exit;
    }

    
    if (empty($_POST['consent'])) {
        echo json_encode(['status' => 'error', 'message' => 'Vous devez accepter la politique de confidentialité pour créer un compte.']);
        exit;
    }

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'] ?? '';

    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Adresse e-mail invalide.']);
        exit;
    }

    
    if ($password !== $confirmPassword) {
        echo json_encode(['status' => 'error', 'message' => 'Les mots de passe ne correspondent pas.']);
        exit;
    }

    
    if (strlen($password) < 12) {
        echo json_encode(['status' => 'error', 'message' => 'Le mot de passe doit contenir au moins 12 caractères.']);
        exit;
    }
    if (!preg_match('/[A-Z]/', $password)) {
        echo json_encode(['status' => 'error', 'message' => 'Le mot de passe doit contenir au moins une majuscule.']);
        exit;
    }
    if (!preg_match('/[a-z]/', $password)) {
        echo json_encode(['status' => 'error', 'message' => 'Le mot de passe doit contenir au moins une minuscule.']);
        exit;
    }
    if (!preg_match('/[0-9]/', $password)) {
        echo json_encode(['status' => 'error', 'message' => 'Le mot de passe doit contenir au moins un chiffre.']);
        exit;
    }
    if (!preg_match('/[^A-Za-z0-9]/', $password)) {
        echo json_encode(['status' => 'error', 'message' => 'Le mot de passe doit contenir au moins un caractère spécial.']);
        exit;
    }

    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $db->prepare("INSERT INTO adg_users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword]);

        
        $newUserId = $db->lastInsertId();
        session_regenerate_id(true);
        $_SESSION['user_id'] = $newUserId;
        $_SESSION['username'] = $username;

        set_flash('success', 'Bienvenue aux Archives du Gardien ! Votre compte a bien été créé.');
        echo json_encode(['status' => 'success', 'redirect' => 'profile.php']);
    } catch (PDOException $e) {
        
        echo json_encode(['status' => 'error', 'message' => 'Cet aventurier (ou cet email) existe déjà.']);
    }
}
?>
