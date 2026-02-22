<?php
require_once 'utils/db_connection.php';
require_once 'utils/is_admin.php';
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification du jeton CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        set_flash('error', 'Erreur de sécurité : requête non autorisée.');
        header('Location: ../admin_news_gestion.php');
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
        set_flash('error', 'Le titre et l\'auteur sont obligatoires.');
        header('Location: ../edit_news.php?id=' . $news_id);
        exit;
    }

    // Vérification que l'utilisateur existe
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_users WHERE id = :id");
    $stmt->execute([':id' => $id_user]);
    if ($stmt->fetchColumn() == 0) {
        set_flash('error', 'L\'auteur sélectionné est invalide.');
        header('Location: ../edit_news.php?id=' . $news_id);
        exit;
    }

    // Vérification unicité du titre (sauf l'article en cours)
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_news WHERE title = :title AND id != :id");
    $stmt->execute([':title' => $title, ':id' => $news_id]);
    if ($stmt->fetchColumn() > 0) {
        set_flash('error', 'Un article avec ce titre existe déjà.');
        header('Location: ../edit_news.php?id=' . $news_id);
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

        set_flash('success', 'Article mis à jour avec succès !');
        header('Location: ../admin_news_gestion.php');
        exit;

    } catch (PDOException $e) {
        set_flash('error', 'Une erreur est survenue lors de la modification.');
        header('Location: ../edit_news.php?id=' . $news_id);
        exit;
    }
} else {
    header('Location: ../admin_news_gestion.php');
    exit;
}
