<?php
require_once 'components/utils/db_connection.php';
require_once 'components/utils/is_admin.php';
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    set_flash('error', 'Méthode non autorisée.');
    header('Location: admin_mount_gestion.php');
    exit;
}

// Vérification du jeton CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    set_flash('error', 'Erreur de sécurité : requête non autorisée.');
    header('Location: admin_mount_gestion.php');
    exit;
}

$mount_id = (int) ($_POST['mount_id'] ?? -1);

if ($mount_id < 0) {
    set_flash('error', 'Identifiant invalide.');
    header('Location: admin_mount_gestion.php');
    exit;
}

try {
    $stmt = $db->prepare("DELETE FROM adg_mounts WHERE id = :id");
    $stmt->execute([':id' => $mount_id]);
    set_flash('success', 'Monture supprimée avec succès !');
    header('Location: admin_mount_gestion.php');
    exit;
} catch (PDOException $e) {
    set_flash('error', 'Une erreur est survenue lors de la suppression.');
    header('Location: admin_mount_gestion.php');
    exit;
}
