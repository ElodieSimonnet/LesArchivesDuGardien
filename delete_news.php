<?php
require_once 'components/utils/db_connection.php';
require_once 'components/utils/is_admin.php';
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    set_flash('error', 'Méthode non autorisée.');
    header('Location: admin_news_gestion.php');
    exit;
}

// Vérification du jeton CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    set_flash('error', 'Erreur de sécurité : requête non autorisée.');
    header('Location: admin_news_gestion.php');
    exit;
}

$news_id = (int) ($_POST['news_id'] ?? -1);

if ($news_id < 0) {
    set_flash('error', 'Identifiant invalide.');
    header('Location: admin_news_gestion.php');
    exit;
}

try {
    $stmt = $db->prepare("DELETE FROM adg_news WHERE id = :id");
    $stmt->execute([':id' => $news_id]);
    set_flash('success', 'Article supprimé avec succès !');
    header('Location: admin_news_gestion.php');
    exit;
} catch (PDOException $e) {
    set_flash('error', 'Une erreur est survenue lors de la suppression.');
    header('Location: admin_news_gestion.php');
    exit;
}
