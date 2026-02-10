<?php
require_once 'components/utils/db_connection.php';
require_once 'components/utils/is_admin.php';
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: admin_user_gestion.php?error=invalid_method');
    exit;
}

// Vérification du jeton CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    header('Location: admin_user_gestion.php?error=csrf');
    exit;
}

$user_id = (int) ($_POST['user_id'] ?? 0);

if ($user_id <= 0) {
    header('Location: admin_user_gestion.php?error=invalid_id');
    exit;
}

// Empêcher un admin de supprimer son propre compte
if ($user_id === (int) $_SESSION['user_id']) {
    header('Location: admin_user_gestion.php?error=self_delete');
    exit;
}

try {
    $stmt = $db->prepare("DELETE FROM adg_users WHERE id = :id");
    $stmt->execute([':id' => $user_id]);
    header('Location: admin_user_gestion.php?success=user_deleted');
    exit;
} catch (PDOException $e) {
    header('Location: admin_user_gestion.php?error=sql');
    exit;
}