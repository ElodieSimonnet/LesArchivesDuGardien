<?php
require_once 'utils/db_connection.php';
require_once 'utils/is_admin.php';
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification du jeton CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header('Location: ../add_faq.php?error=csrf');
        exit;
    }

    // Nettoyage des données
    $question = trim($_POST['question']);
    $answer = trim($_POST['answer']);
    $id_category = (int)($_POST['id_category'] ?? 0);
    $display_order = (int)($_POST['display_order'] ?? 0);

    // Validation
    if (empty($question) || empty($answer) || $id_category <= 0) {
        header('Location: ../add_faq.php?error=fields');
        exit;
    }

    try {
        $sql = "INSERT INTO adg_faq (question, answer, id_category, display_order)
                VALUES (:question, :answer, :id_category, :display_order)";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':question' => $question,
            ':answer' => $answer,
            ':id_category' => $id_category,
            ':display_order' => $display_order,
        ]);

        header('Location: ../admin_faq_gestion.php?success=faq_added');
        exit;

    } catch (PDOException $e) {
        header('Location: ../add_faq.php?error=sql');
        exit;
    }
} else {
    header('Location: ../admin_faq_gestion.php');
    exit;
}
