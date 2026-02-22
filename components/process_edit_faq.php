<?php
require_once 'utils/db_connection.php';
require_once 'utils/is_admin.php';
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification du jeton CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        set_flash('error', 'Erreur de sécurité : requête non autorisée.');
        header('Location: ../admin_faq_gestion.php');
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
        set_flash('error', 'La question, la réponse et la catégorie sont obligatoires.');
        header('Location: ../edit_faq.php?id=' . $faq_id);
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

        set_flash('success', 'Question mise à jour avec succès !');
        header('Location: ../admin_faq_gestion.php');
        exit;

    } catch (PDOException $e) {
        set_flash('error', 'Une erreur est survenue lors de la modification.');
        header('Location: ../edit_faq.php?id=' . $faq_id);
        exit;
    }
} else {
    header('Location: ../admin_faq_gestion.php');
    exit;
}
