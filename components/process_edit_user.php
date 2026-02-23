<?php
require_once 'utils/db_connection.php';
require_once 'utils/is_admin.php';
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification du jeton CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        set_flash('error', 'Erreur de sécurité : requête non autorisée.');
        header('Location: ../admin_user_gestion.php');
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
        set_flash('error', 'Le nom d\'utilisateur et l\'email sont obligatoires.');
        header('Location: ../admin_user_gestion.php');
        exit;
    }

    // Validation que le rôle existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_roles WHERE id = :id");
    $stmt->execute([':id' => $id_role]);
    if ($stmt->fetchColumn() == 0) {
        set_flash('error', 'Le rôle sélectionné est invalide.');
        header('Location: ../admin_user_gestion.php');
        exit;
    }

    // Validation que le statut existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_users_status WHERE id = :id");
    $stmt->execute([':id' => $id_status]);
    if ($stmt->fetchColumn() == 0) {
        set_flash('error', 'Le statut sélectionné est invalide.');
        header('Location: ../admin_user_gestion.php');
        exit;
    }

    // Vérification d'unicité du username (hors utilisateur courant)
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_users WHERE username = :username AND id != :id");
    $stmt->execute([':username' => $username, ':id' => $user_id]);
    if ($stmt->fetchColumn() > 0) {
        set_flash('error', 'Ce nom d\'utilisateur est déjà utilisé.');
        header('Location: ../edit_user.php?id=' . $user_id);
        exit;
    }

    // Vérification d'unicité de l'email (hors utilisateur courant)
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_users WHERE email = :email AND id != :id");
    $stmt->execute([':email' => $email, ':id' => $user_id]);
    if ($stmt->fetchColumn() > 0) {
        set_flash('error', 'Cette adresse email est déjà utilisée.');
        header('Location: ../edit_user.php?id=' . $user_id);
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

        set_flash('success', 'Utilisateur mis à jour avec succès !');
        header('Location: ../admin_user_gestion.php');
        exit;

    } catch (PDOException $e) {
        // En cas d'erreur (ex: email déjà pris)
        set_flash('error', 'Une erreur est survenue lors de la modification.');
        header('Location: ../admin_user_gestion.php');
        exit;
    }
} else {
    // Si on tente d'accéder au fichier sans formulaire
    header('Location: ../admin_user_gestion.php');
    exit;
}
