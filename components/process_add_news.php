<?php
require_once 'utils/db_connection.php';
require_once 'utils/is_admin.php';
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification du jeton CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        set_flash('error', 'Erreur de sécurité : requête non autorisée.');
        header('Location: ../add_news.php');
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
        set_flash('error', 'Le titre et l\'auteur sont obligatoires.');
        header('Location: ../add_news.php');
        exit;
    }

    // Vérification que l'utilisateur existe
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_users WHERE id = :id");
    $stmt->execute([':id' => $id_user]);
    if ($stmt->fetchColumn() == 0) {
        set_flash('error', 'L\'auteur sélectionné est invalide.');
        header('Location: ../add_news.php');
        exit;
    }

    // Vérification unicité du titre
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_news WHERE title = :title");
    $stmt->execute([':title' => $title]);
    if ($stmt->fetchColumn() > 0) {
        set_flash('error', 'Un article avec ce titre existe déjà.');
        header('Location: ../add_news.php');
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

        set_flash('success', 'Article créé avec succès !');
        header('Location: ../admin_news_gestion.php');
        exit;

    } catch (PDOException $e) {
        set_flash('error', 'Une erreur est survenue lors de la création.');
        header('Location: ../add_news.php');
        exit;
    }
} else {
    header('Location: ../admin_news_gestion.php');
    exit;
}
