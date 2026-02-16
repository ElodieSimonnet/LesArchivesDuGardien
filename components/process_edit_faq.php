<?php
require_once 'utils/db_connection.php';
require_once 'utils/is_admin.php';
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification du jeton CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header('Location: ../admin_faq_gestion.php?error=csrf');
        exit;
    }

    // Nettoyage des données
    $faq_id = (int) $_POST['faq_id'];
    $question = trim($_POST['question']);
    $answer = trim($_POST['answer']);
    $id_category = (int)($_POST['id_category'] ?? 0);
    $display_order = (int)($_POST['display_order'] ?? 0);

    // Validation
    if (empty($question) || empty($answer) || $id_category <= 0) {
        header('Location: ../edit_faq.php?id=' . $faq_id . '&error=fields');
        exit;
    }

    try {
        $sql = "UPDATE adg_faq SET
                question = :question,
                answer = :answer,
                id_category = :id_category,
                display_order = :display_order
                WHERE id = :id";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':question' => $question,
            ':answer' => $answer,
            ':id_category' => $id_category,
            ':display_order' => $display_order,
            ':id' => $faq_id,
        ]);

        header('Location: ../admin_faq_gestion.php?success=1');
        exit;

    } catch (PDOException $e) {
        header('Location: ../edit_faq.php?id=' . $faq_id . '&error=sql');
        exit;
    }
} else {
    header('Location: ../admin_faq_gestion.php');
    exit;
}
