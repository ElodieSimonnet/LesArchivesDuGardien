<?php
require_once 'utils/db_connection.php';
require_once 'utils/is_admin.php';
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification du jeton CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        set_flash('error', 'Erreur de sécurité : requête non autorisée.');
        header('Location: ../add_user.php');
        exit;
    }

    // Nettoyage des données
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $id_role = (int) $_POST['id_role'];
    $id_status = (int) $_POST['id_status'];

    // Validation : champs non vides
    if (empty($username) || empty($email) || empty($password)) {
        set_flash('error', 'Le nom d\'utilisateur, l\'email et le mot de passe sont obligatoires.');
        header('Location: ../add_user.php');
        exit;
    }

    // Validation de la robustesse du mot de passe
    if (strlen($password) < 12 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[^A-Za-z0-9]/', $password)) {
        set_flash('error', 'Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.');
        header('Location: ../add_user.php');
        exit;
    }

    // Validation que le rôle existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_roles WHERE id = :id");
    $stmt->execute([':id' => $id_role]);
    if ($stmt->fetchColumn() == 0) {
        set_flash('error', 'Le rôle sélectionné est invalide.');
        header('Location: ../add_user.php');
        exit;
    }

    // Validation que le statut existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_users_status WHERE id = :id");
    $stmt->execute([':id' => $id_status]);
    if ($stmt->fetchColumn() == 0) {
        set_flash('error', 'Le statut sélectionné est invalide.');
        header('Location: ../add_user.php');
        exit;
    }

    // Vérification unicité username/email
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_users WHERE username = :username OR email = :email");
    $stmt->execute([':username' => $username, ':email' => $email]);
    if ($stmt->fetchColumn() > 0) {
        set_flash('error', 'Ce nom d\'utilisateur ou cet email est déjà utilisé.');
        header('Location: ../add_user.php');
        exit;
    }

    try {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO adg_users (username, email, password, id_role, id_status)
                VALUES (:username, :email, :password, :id_role, :id_status)";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword,
            ':id_role' => $id_role,
            ':id_status' => $id_status,
        ]);

        set_flash('success', 'Utilisateur créé avec succès !');
        header('Location: ../admin_user_gestion.php');
        exit;

    } catch (PDOException $e) {
        set_flash('error', 'Une erreur est survenue lors de la création.');
        header('Location: ../add_user.php');
        exit;
    }
} else {
    header('Location: ../admin_user_gestion.php');
    exit;
}
