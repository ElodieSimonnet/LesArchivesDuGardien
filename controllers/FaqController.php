<?php

class FaqController
{
    private FaqModel $model;

    public function __construct()
    {
        $this->model = new FaqModel();
    }

    public function list(): void
    {
        $faq_by_category = $this->model->getAllGroupedByCategory();

        require __DIR__ . '/../views/faq.php';
    }

    public function adminList(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        $all_faq = $this->model->getAll();

        require __DIR__ . '/../views/admin/faq_management.php';
    }

    public function showAddForm(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        $categories = $this->model->getCategories();

        require __DIR__ . '/../views/admin/add_faq.php';
    }

    public function showEditForm(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        $faq_id = (int) ($_GET['id'] ?? 0);
        if (!$faq_id) {
            header('Location: faq_management.php');
            exit;
        }

        $faq = $this->model->getRawById($faq_id);
        if (!$faq) {
            header('Location: faq_management.php');
            exit;
        }

        $categories = $this->model->getCategories();

        require __DIR__ . '/../views/admin/edit_faq.php';
    }

    public function adminView(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        $faq_id = (int) ($_GET['id'] ?? 0);
        if (!$faq_id) {
            header('Location: faq_management.php');
            exit;
        }

        $faq = $this->model->getById($faq_id);
        if (!$faq) {
            header('Location: faq_management.php');
            exit;
        }

        require __DIR__ . '/../views/admin/view_faq.php';
    }

    public function create(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            set_flash('error', 'Erreur de sécurité : requête non autorisée.');
            header('Location: add_faq.php');
            exit;
        }

        $question     = trim($_POST['question'] ?? '');
        $answer       = trim($_POST['answer'] ?? '');
        $id_category  = (int) ($_POST['id_category'] ?? 0);
        $display_order = (int) ($_POST['display_order'] ?? 0);

        if (empty($question) || empty($answer) || $id_category <= 0) {
            set_flash('error', 'La question, la réponse et la catégorie sont obligatoires.');
            header('Location: add_faq.php');
            exit;
        }

        try {
            $this->model->create([
                ':question'     => $question,
                ':answer'       => $answer,
                ':id_category'  => $id_category,
                ':display_order' => $display_order,
            ]);
            set_flash('success', 'Question créée avec succès !');
            header('Location: faq_management.php');
            exit;
        } catch (PDOException $e) {
            set_flash('error', 'Une erreur est survenue lors de la création.');
            header('Location: add_faq.php');
            exit;
        }
    }

    public function update(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            set_flash('error', 'Erreur de sécurité : requête non autorisée.');
            header('Location: faq_management.php');
            exit;
        }

        $faq_id       = (int) ($_POST['faq_id'] ?? 0);
        $question     = trim($_POST['question'] ?? '');
        $answer       = trim($_POST['answer'] ?? '');
        $id_category  = (int) ($_POST['id_category'] ?? 0);
        $display_order = (int) ($_POST['display_order'] ?? 0);

        if (empty($question) || empty($answer) || $id_category <= 0) {
            set_flash('error', 'La question, la réponse et la catégorie sont obligatoires.');
            header("Location: edit_faq.php?id={$faq_id}");
            exit;
        }

        try {
            $this->model->update([
                ':id'           => $faq_id,
                ':question'     => $question,
                ':answer'       => $answer,
                ':id_category'  => $id_category,
                ':display_order' => $display_order,
            ]);
            set_flash('success', 'Question mise à jour avec succès !');
            header('Location: faq_management.php');
            exit;
        } catch (PDOException $e) {
            set_flash('error', 'Une erreur est survenue lors de la modification.');
            header("Location: edit_faq.php?id={$faq_id}");
            exit;
        }
    }

    public function delete(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: faq_management.php');
            exit;
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            set_flash('error', 'Erreur de sécurité : requête non autorisée.');
            header('Location: faq_management.php');
            exit;
        }

        $faq_id = (int) ($_POST['faq_id'] ?? -1);
        if ($faq_id < 0) {
            set_flash('error', 'Identifiant invalide.');
            header('Location: faq_management.php');
            exit;
        }

        try {
            $this->model->delete($faq_id);
            set_flash('success', 'Question supprimée avec succès !');
            header('Location: faq_management.php');
            exit;
        } catch (PDOException $e) {
            set_flash('error', 'Une erreur est survenue lors de la suppression.');
            header('Location: faq_management.php');
            exit;
        }
    }
}
