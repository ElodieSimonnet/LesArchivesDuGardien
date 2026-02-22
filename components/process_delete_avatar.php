<?php
require_once 'utils/db_connection.php';
require_once 'utils/is_admin.php';
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin_user_gestion.php');
    exit;
}

// Vérification du jeton CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    set_flash('error', 'Erreur de sécurité : requête non autorisée.');
    header('Location: ../admin_user_gestion.php');
    exit;
}

$user_id = (int) ($_POST['user_id'] ?? 0);

if ($user_id <= 0) {
    set_flash('error', 'Identifiant invalide.');
    header('Location: ../admin_user_gestion.php');
    exit;
}

try {
    // Récupérer le chemin de l'avatar actuel
    $stmt = $db->prepare("SELECT avatar FROM adg_users WHERE id = :id");
    $stmt->execute([':id' => $user_id]);
    $avatar_path = $stmt->fetchColumn();

    // Supprimer le fichier du serveur s'il existe
    if (!empty($avatar_path) && file_exists('../' . $avatar_path)) {
        unlink('../' . $avatar_path);
    }

    // Remettre le champ avatar à NULL en BDD
    $stmt = $db->prepare("UPDATE adg_users SET avatar = NULL WHERE id = :id");
    $stmt->execute([':id' => $user_id]);

    set_flash('success', 'Avatar supprimé avec succès !');
    header('Location: ../edit_user.php?id=' . $user_id);
    exit;

} catch (PDOException $e) {
    set_flash('error', 'Une erreur est survenue lors de la suppression de l\'avatar.');
    header('Location: ../edit_user.php?id=' . $user_id);
    exit;
}
