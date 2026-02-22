<?php
require_once 'components/utils/db_connection.php';
require_once 'components/utils/is_admin.php';
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    set_flash('error', 'Méthode non autorisée.');
    header('Location: admin_user_gestion.php');
    exit;
}

// Vérification du jeton CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    set_flash('error', 'Erreur de sécurité : requête non autorisée.');
    header('Location: admin_user_gestion.php');
    exit;
}

$user_id = (int) ($_POST['user_id'] ?? 0);

if ($user_id <= 0) {
    set_flash('error', 'Identifiant invalide.');
    header('Location: admin_user_gestion.php');
    exit;
}

// Empêcher un admin de supprimer son propre compte
if ($user_id === (int) $_SESSION['user_id']) {
    set_flash('error', 'Vous ne pouvez pas supprimer votre propre compte.');
    header('Location: admin_user_gestion.php');
    exit;
}

try {
    // Suppression des données liées
    $db->prepare("DELETE FROM adg_user_mounts WHERE id_user = ?")->execute([$user_id]);
    $db->prepare("DELETE FROM adg_user_pets WHERE id_user = ?")->execute([$user_id]);
    $db->prepare("DELETE FROM adg_wishlist_mounts WHERE id_user = ?")->execute([$user_id]);
    $db->prepare("DELETE FROM adg_wishlist_pets WHERE id_user = ?")->execute([$user_id]);
    $db->prepare("UPDATE adg_news SET id_user = NULL WHERE id_user = ?")->execute([$user_id]);

    $stmt = $db->prepare("DELETE FROM adg_users WHERE id = :id");
    $stmt->execute([':id' => $user_id]);
    set_flash('success', 'Utilisateur supprimé avec succès !');
    header('Location: admin_user_gestion.php');
    exit;
} catch (PDOException $e) {
    set_flash('error', 'Une erreur est survenue lors de la suppression.');
    header('Location: admin_user_gestion.php');
    exit;
}
