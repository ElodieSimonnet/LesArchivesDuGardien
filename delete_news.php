<?php
require_once 'components/utils/db_connection.php';
require_once 'components/utils/is_admin.php';
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: admin_news_gestion.php?error=invalid_method');
    exit;
}

// Vérification du jeton CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    header('Location: admin_news_gestion.php?error=csrf');
    exit;
}

$news_id = (int) ($_POST['news_id'] ?? -1);

if ($news_id < 0) {
    header('Location: admin_news_gestion.php?error=invalid_id');
    exit;
}

try {
    $stmt = $db->prepare("DELETE FROM adg_news WHERE id = :id");
    $stmt->execute([':id' => $news_id]);
    header('Location: admin_news_gestion.php?success=news_deleted');
    exit;
} catch (PDOException $e) {
    header('Location: admin_news_gestion.php?error=sql');
    exit;
}
