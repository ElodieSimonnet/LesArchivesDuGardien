<?php
require_once 'components/utils/db_connection.php';
require_once 'components/utils/is_admin.php';
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: admin_mount_gestion.php?error=invalid_method');
    exit;
}

// Vérification du jeton CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    header('Location: admin_mount_gestion.php?error=csrf');
    exit;
}

$mount_id = (int) ($_POST['mount_id'] ?? -1);

if ($mount_id < 0) {
    header('Location: admin_mount_gestion.php?error=invalid_id');
    exit;
}

try {
    $stmt = $db->prepare("DELETE FROM adg_mounts WHERE id = :id");
    $stmt->execute([':id' => $mount_id]);
    header('Location: admin_mount_gestion.php?success=mount_deleted');
    exit;
} catch (PDOException $e) {
    header('Location: admin_mount_gestion.php?error=sql');
    exit;
}
