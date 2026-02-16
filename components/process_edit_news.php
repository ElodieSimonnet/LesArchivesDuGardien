<?php
require_once 'utils/db_connection.php';
require_once 'utils/is_admin.php';
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification du jeton CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header('Location: ../admin_news_gestion.php?error=csrf');
        exit;
    }

    // Nettoyage des données
    $news_id = (int) $_POST['news_id'];
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $image_url = trim($_POST['image']);
    $source_news = trim($_POST['source_news'] ?? '');
    $id_user = (int)($_POST['id_user'] ?? 0);

    // Validation : titre et auteur non vides
    if (empty($title) || $id_user <= 0) {
        header('Location: ../edit_news.php?id=' . $news_id . '&error=fields');
        exit;
    }

    // Vérification que l'utilisateur existe
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_users WHERE id = :id");
    $stmt->execute([':id' => $id_user]);
    if ($stmt->fetchColumn() == 0) {
        header('Location: ../edit_news.php?id=' . $news_id . '&error=invalid_user');
        exit;
    }

    // Vérification unicité du titre (sauf l'article en cours)
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_news WHERE title = :title AND id != :id");
    $stmt->execute([':title' => $title, ':id' => $news_id]);
    if ($stmt->fetchColumn() > 0) {
        header('Location: ../edit_news.php?id=' . $news_id . '&error=duplicate');
        exit;
    }

    try {
        $sql = "UPDATE adg_news SET
                title = :title,
                content = :content,
                image_url = :image_url,
                source_news = :source_news,
                id_user = :id_user
                WHERE id = :id";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':image_url' => $image_url,
            ':source_news' => $source_news,
            ':id_user' => $id_user,
            ':id' => $news_id,
        ]);

        header('Location: ../admin_news_gestion.php?success=1');
        exit;

    } catch (PDOException $e) {
        header('Location: ../edit_news.php?id=' . $news_id . '&error=sql');
        exit;
    }
} else {
    header('Location: ../admin_news_gestion.php');
    exit;
}
