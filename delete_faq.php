<?php
require_once 'components/utils/db_connection.php';
require_once 'components/utils/is_admin.php';
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: admin_faq_gestion.php?error=invalid_method');
    exit;
}

// Vérification du jeton CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    header('Location: admin_faq_gestion.php?error=csrf');
    exit;
}

$faq_id = (int) ($_POST['faq_id'] ?? -1);

if ($faq_id < 0) {
    header('Location: admin_faq_gestion.php?error=invalid_id');
    exit;
}

try {
    $stmt = $db->prepare("DELETE FROM adg_faq WHERE id = :id");
    $stmt->execute([':id' => $faq_id]);
    header('Location: admin_faq_gestion.php?success=faq_deleted');
    exit;
} catch (PDOException $e) {
    header('Location: admin_faq_gestion.php?error=sql');
    exit;
}
