<?php

class NewsController
{
    private NewsModel $model;

    public function __construct()
    {
        $this->model = new NewsModel();
    }

    public function list(): void
    {
        $carousel_news = $this->model->getCarouselNews();
        $list_news     = $this->model->getListNews();

        require __DIR__ . '/../views/news.php';
    }

    public function adminList(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        $all_news = $this->model->getAll();

        require __DIR__ . '/../views/admin/news_management.php';
    }

    public function showAddForm(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        $users = $this->model->getAdminUsers();

        require __DIR__ . '/../views/admin/add_news.php';
    }

    public function showEditForm(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        $news_id = (int) ($_GET['id'] ?? 0);
        if (!$news_id) {
            header('Location: news_management.php');
            exit;
        }

        $article = $this->model->getRawById($news_id);
        if (!$article) {
            header('Location: news_management.php');
            exit;
        }

        $users = $this->model->getAdminUsers();

        require __DIR__ . '/../views/admin/edit_news.php';
    }

    public function adminView(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        $news_id = (int) ($_GET['id'] ?? 0);
        if (!$news_id) {
            header('Location: news_management.php');
            exit;
        }

        $article = $this->model->getById($news_id);
        if (!$article) {
            header('Location: news_management.php');
            exit;
        }

        require __DIR__ . '/../views/admin/view_news.php';
    }

    public function create(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            set_flash('error', 'Erreur de sécurité : requête non autorisée.');
            header('Location: add_news.php');
            exit;
        }

        $title      = trim($_POST['title'] ?? '');
        $content    = trim($_POST['content'] ?? '');
        $image_url  = trim($_POST['image'] ?? '');
        $source_news = trim($_POST['source_news'] ?? '');
        $id_user    = (int) ($_POST['id_user'] ?? 0);

        if (empty($title) || $id_user <= 0) {
            set_flash('error', "Le titre et l'auteur sont obligatoires.");
            header('Location: add_news.php');
            exit;
        }

        if (!$this->model->userExists($id_user)) {
            set_flash('error', "L'auteur sélectionné est invalide.");
            header('Location: add_news.php');
            exit;
        }

        if ($this->model->titleExists($title)) {
            set_flash('error', 'Un article avec ce titre existe déjà.');
            header('Location: add_news.php');
            exit;
        }

        try {
            $this->model->create([
                ':title'      => $title,
                ':content'    => $content,
                ':image_url'  => $image_url,
                ':source_news' => $source_news,
                ':id_user'    => $id_user,
            ]);
            set_flash('success', 'Article créé avec succès !');
            header('Location: news_management.php');
            exit;
        } catch (PDOException $e) {
            set_flash('error', 'Une erreur est survenue lors de la création.');
            header('Location: add_news.php');
            exit;
        }
    }

    public function update(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            set_flash('error', 'Erreur de sécurité : requête non autorisée.');
            header('Location: news_management.php');
            exit;
        }

        $news_id    = (int) ($_POST['news_id'] ?? 0);
        $title      = trim($_POST['title'] ?? '');
        $content    = trim($_POST['content'] ?? '');
        $image_url  = trim($_POST['image'] ?? '');
        $source_news = trim($_POST['source_news'] ?? '');
        $id_user    = (int) ($_POST['id_user'] ?? 0);

        if (empty($title) || $id_user <= 0) {
            set_flash('error', "Le titre et l'auteur sont obligatoires.");
            header("Location: edit_news.php?id={$news_id}");
            exit;
        }

        if (!$this->model->userExists($id_user)) {
            set_flash('error', "L'auteur sélectionné est invalide.");
            header("Location: edit_news.php?id={$news_id}");
            exit;
        }

        if ($this->model->titleExists($title, $news_id)) {
            set_flash('error', 'Un article avec ce titre existe déjà.');
            header("Location: edit_news.php?id={$news_id}");
            exit;
        }

        try {
            $this->model->update([
                ':id'         => $news_id,
                ':title'      => $title,
                ':content'    => $content,
                ':image_url'  => $image_url,
                ':source_news' => $source_news,
                ':id_user'    => $id_user,
            ]);
            set_flash('success', 'Article mis à jour avec succès !');
            header('Location: news_management.php');
            exit;
        } catch (PDOException $e) {
            set_flash('error', 'Une erreur est survenue lors de la modification.');
            header("Location: edit_news.php?id={$news_id}");
            exit;
        }
    }

    public function delete(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: news_management.php');
            exit;
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            set_flash('error', 'Erreur de sécurité : requête non autorisée.');
            header('Location: news_management.php');
            exit;
        }

        $news_id = (int) ($_POST['news_id'] ?? -1);
        if ($news_id < 0) {
            set_flash('error', 'Identifiant invalide.');
            header('Location: news_management.php');
            exit;
        }

        try {
            $this->model->delete($news_id);
            set_flash('success', 'Article supprimé avec succès !');
            header('Location: news_management.php');
            exit;
        } catch (PDOException $e) {
            set_flash('error', 'Une erreur est survenue lors de la suppression.');
            header('Location: news_management.php');
            exit;
        }
    }
}
