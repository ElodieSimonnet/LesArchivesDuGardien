<?php
require_once 'utils/db_connection.php';
require_once 'utils/is_admin.php';
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification du jeton CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header('Location: ../admin_user_gestion.php?error=csrf');
        exit;
    }

    // Nettoyage des données
    $user_id = (int) $_POST['user_id'];
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $id_role = (int) $_POST['id_role'];
    $id_status = (int) $_POST['id_status'];

    // Validation minimale
    if (empty($username) || empty($email)) {
        header('Location: ../admin_user_gestion.php?error=fields');
        exit;
    }

    // Validation que le rôle existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_roles WHERE id = :id");
    $stmt->execute([':id' => $id_role]);
    if ($stmt->fetchColumn() == 0) {
        header('Location: ../admin_user_gestion.php?error=invalid_role');
        exit;
    }

    // Validation que le statut existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_users_status WHERE id = :id");
    $stmt->execute([':id' => $id_status]);
    if ($stmt->fetchColumn() == 0) {
        header('Location: ../admin_user_gestion.php?error=invalid_status');
        exit;
    }

    try {
        // Préparation de la mise à jour
        $sql = "UPDATE adg_users SET
                username = :username,
                email = :email,
                id_role = :role,
                id_status = :status
                WHERE id = :id";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':role' => $id_role,
            ':status' => $id_status,
            ':id' => $user_id
        ]);

        // Redirection avec succès
        header('Location: ../admin_user_gestion.php?success=1');
        exit;

    } catch (PDOException $e) {
        // En cas d'erreur (ex: email déjà pris)
        header('Location: ../admin_user_gestion.php?error=sql');
        exit;
    }
} else {
    // Si on tente d'accéder au fichier sans formulaire
    header('Location: ../admin_user_gestion.php');
    exit;
}
