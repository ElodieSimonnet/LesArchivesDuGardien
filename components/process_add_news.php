<?php
require_once 'utils/db_connection.php';
require_once 'utils/is_admin.php';
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification du jeton CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header('Location: ../add_news.php?error=csrf');
        exit;
    }

    // Nettoyage des données
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $image_url = trim($_POST['image']);
    $source_news = trim($_POST['source_news'] ?? '');
    $id_user = (int)($_POST['id_user'] ?? 0);

    // Validation : titre et auteur non vides
    if (empty($title) || $id_user <= 0) {
        header('Location: ../add_news.php?error=fields');
        exit;
    }

    // Vérification que l'utilisateur existe
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_users WHERE id = :id");
    $stmt->execute([':id' => $id_user]);
    if ($stmt->fetchColumn() == 0) {
        header('Location: ../add_news.php?error=invalid_user');
        exit;
    }

    // Vérification unicité du titre
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_news WHERE title = :title");
    $stmt->execute([':title' => $title]);
    if ($stmt->fetchColumn() > 0) {
        header('Location: ../add_news.php?error=duplicate');
        exit;
    }

    try {
        $sql = "INSERT INTO adg_news (title, content, image_url, source_news, id_user)
                VALUES (:title, :content, :image_url, :source_news, :id_user)";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':image_url' => $image_url,
            ':source_news' => $source_news,
            ':id_user' => $id_user,
        ]);

        header('Location: ../admin_news_gestion.php?success=news_added');
        exit;

    } catch (PDOException $e) {
        header('Location: ../add_news.php?error=sql');
        exit;
    }
} else {
    header('Location: ../admin_news_gestion.php');
    exit;
}
