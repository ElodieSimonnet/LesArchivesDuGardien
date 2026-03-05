<?php

/**
 * ============================================================
 * CONTRÔLEUR : UserController
 * ============================================================
 * Rôle : Gérer toute la logique liée aux utilisateurs.
 * ============================================================
 */

class UserController
{
    private UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    // ========================================================
    // PAGES PUBLIQUES
    // ========================================================

    /**
     * Affiche la page de profil de l'utilisateur connecté.
     */
    public function profile(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php');
            exit;
        }

        $user = $this->model->getById((int) $_SESSION['user_id']);

        if (!$user || $user['status'] !== 'Actif') {
            session_destroy();
            header('Location: index.php');
            exit;
        }

        $counts = $this->model->getCollectionCounts((int) $_SESSION['user_id']);
        extract($counts);

        require __DIR__ . '/../views/profile.php';
    }

    /**
     * Déconnecte l'utilisateur (POST seulement, avec CSRF).
     */
    public function logout(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                header('Location: index.php?error=security_breach');
                exit;
            }

            $_SESSION = [];

            if (ini_get('session.use_cookies')) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params['path'],
                    $params['domain'],
                    $params['secure'],
                    $params['httponly']
                );
            }

            session_destroy();
            header('Location: index.php?status=logged_out');
            exit;
        }

        header('Location: index.php');
        exit;
    }

    // ========================================================
    // PAGES ADMIN - Connexion & Dashboard
    // ========================================================

    /**
     * Affiche la page de connexion admin.
     */
    public function adminLogin(): void
    {
        require __DIR__ . '/../views/admin/login.php';
    }

    /**
     * Affiche le dashboard admin.
     */
    public function dashboard(): void
    {
        require_once __DIR__ . '/../components/utils/is_admin.php';
        restrictToAdmin();

        $stats = $this->model->getDashboardStats();
        extract($stats);

        // Pour la liste des utilisateurs (affichée aussi sur le dashboard)
        $all_users = $this->model->getAll();

        require __DIR__ . '/../views/admin/dashboard.php';
    }

    // ========================================================
    // PAGES ADMIN - Gestion des utilisateurs
    // ========================================================

    /**
     * Affiche la liste admin des utilisateurs (avec filtres GET).
     */
    public function adminList(): void
    {
        require_once __DIR__ . '/../components/utils/is_admin.php';
        restrictToAdmin();

        $filters = [
            'status' => $_GET['status'] ?? 'all',
            'role'   => $_GET['role'] ?? 'all',
        ];

        $all_users = $this->model->getAll($filters);

        require __DIR__ . '/../views/admin/user_management.php';
    }

    /**
     * Affiche le détail d'un utilisateur côté admin (lecture seule).
     */
    public function adminView(): void
    {
        require_once __DIR__ . '/../components/utils/is_admin.php';
        restrictToAdmin();

        $user_id = (int) ($_GET['id'] ?? 0);
        if (!$user_id) {
            header('Location: user_management.php');
            exit;
        }

        $user = $this->model->getByIdWithDetails($user_id);
        if (!$user) {
            header('Location: user_management.php');
            exit;
        }

        require __DIR__ . '/../views/admin/view_user.php';
    }

    /**
     * Affiche le formulaire d'ajout d'un utilisateur.
     */
    public function showAddForm(): void
    {
        require_once __DIR__ . '/../components/utils/is_admin.php';
        restrictToAdmin();

        $all_roles    = $this->model->getAllRoles();
        $all_statuses = $this->model->getAllStatuses();

        require __DIR__ . '/../views/admin/add_user.php';
    }

    /**
     * Affiche le formulaire de modification d'un utilisateur.
     */
    public function showEditForm(): void
    {
        require_once __DIR__ . '/../components/utils/is_admin.php';
        restrictToAdmin();

        $user_id = (int) ($_GET['id'] ?? 0);
        if (!$user_id) {
            header('Location: user_management.php');
            exit;
        }

        $user = $this->model->getRawById($user_id);
        if (!$user) {
            header('Location: user_management.php');
            exit;
        }

        $all_roles    = $this->model->getAllRoles();
        $all_statuses = $this->model->getAllStatuses();

        require __DIR__ . '/../views/admin/edit_user.php';
    }

    // ========================================================
    // PAGES ADMIN - Traitement des formulaires
    // ========================================================

    /**
     * Traite le formulaire d'ajout d'un utilisateur (POST).
     */
    public function create(): void
    {
        require_once __DIR__ . '/../components/utils/is_admin.php';
        restrictToAdmin();

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            set_flash('error', 'Erreur de sécurité : requête non autorisée.');
            header('Location: add_user.php');
            exit;
        }

        $username  = trim($_POST['username'] ?? '');
        $email     = trim($_POST['email'] ?? '');
        $password  = $_POST['password'] ?? '';
        $id_role   = (int) ($_POST['id_role'] ?? 0);
        $id_status = (int) ($_POST['id_status'] ?? 0);

        if (empty($username) || empty($email) || empty($password)) {
            set_flash('error', "Le nom d'utilisateur, l'email et le mot de passe sont obligatoires.");
            header('Location: add_user.php');
            exit;
        }

        if (strlen($password) < 12 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password)
            || !preg_match('/[0-9]/', $password) || !preg_match('/[^A-Za-z0-9]/', $password)) {
            set_flash('error', 'Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.');
            header('Location: add_user.php');
            exit;
        }

        if (!$this->model->roleExists($id_role)) {
            set_flash('error', 'Le rôle sélectionné est invalide.');
            header('Location: add_user.php');
            exit;
        }

        if (!$this->model->statusExists($id_status)) {
            set_flash('error', 'Le statut sélectionné est invalide.');
            header('Location: add_user.php');
            exit;
        }

        if ($this->model->usernameExists($username) || $this->model->emailExists($email)) {
            set_flash('error', "Ce nom d'utilisateur ou cet email est déjà utilisé.");
            header('Location: add_user.php');
            exit;
        }

        try {
            $this->model->create([
                ':username'  => $username,
                ':email'     => $email,
                ':password'  => password_hash($password, PASSWORD_DEFAULT),
                ':id_role'   => $id_role,
                ':id_status' => $id_status,
            ]);
            set_flash('success', 'Utilisateur créé avec succès !');
            header('Location: user_management.php');
            exit;
        } catch (PDOException $e) {
            set_flash('error', 'Une erreur est survenue lors de la création.');
            header('Location: add_user.php');
            exit;
        }
    }

    /**
     * Traite le formulaire de modification d'un utilisateur (POST).
     */
    public function update(): void
    {
        require_once __DIR__ . '/../components/utils/is_admin.php';
        restrictToAdmin();

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            set_flash('error', 'Erreur de sécurité : requête non autorisée.');
            header('Location: user_management.php');
            exit;
        }

        $user_id   = (int) ($_POST['user_id'] ?? 0);
        $username  = trim($_POST['username'] ?? '');
        $email     = trim($_POST['email'] ?? '');
        $id_role   = (int) ($_POST['id_role'] ?? 0);
        $id_status = (int) ($_POST['id_status'] ?? 0);

        if (empty($username) || empty($email)) {
            set_flash('error', "Le nom d'utilisateur et l'email sont obligatoires.");
            header("Location: edit_user.php?id={$user_id}");
            exit;
        }

        if (!$this->model->roleExists($id_role)) {
            set_flash('error', 'Le rôle sélectionné est invalide.');
            header("Location: edit_user.php?id={$user_id}");
            exit;
        }

        if (!$this->model->statusExists($id_status)) {
            set_flash('error', 'Le statut sélectionné est invalide.');
            header("Location: edit_user.php?id={$user_id}");
            exit;
        }

        if ($this->model->usernameExists($username, $user_id)) {
            set_flash('error', "Ce nom d'utilisateur est déjà utilisé.");
            header("Location: edit_user.php?id={$user_id}");
            exit;
        }

        if ($this->model->emailExists($email, $user_id)) {
            set_flash('error', 'Cette adresse email est déjà utilisée.');
            header("Location: edit_user.php?id={$user_id}");
            exit;
        }

        try {
            $this->model->update([
                ':username'  => $username,
                ':email'     => $email,
                ':id_role'   => $id_role,
                ':id_status' => $id_status,
                ':id'        => $user_id,
            ]);
            set_flash('success', 'Utilisateur mis à jour avec succès !');
            header('Location: user_management.php');
            exit;
        } catch (PDOException $e) {
            set_flash('error', 'Une erreur est survenue lors de la modification.');
            header("Location: edit_user.php?id={$user_id}");
            exit;
        }
    }

    /**
     * Traite la suppression d'un utilisateur (POST).
     */
    public function delete(): void
    {
        require_once __DIR__ . '/../components/utils/is_admin.php';
        restrictToAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: user_management.php');
            exit;
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            set_flash('error', 'Erreur de sécurité : requête non autorisée.');
            header('Location: user_management.php');
            exit;
        }

        $user_id = (int) ($_POST['user_id'] ?? 0);

        if ($user_id <= 0) {
            set_flash('error', 'Identifiant invalide.');
            header('Location: user_management.php');
            exit;
        }

        if ($user_id === (int) $_SESSION['user_id']) {
            set_flash('error', 'Vous ne pouvez pas supprimer votre propre compte.');
            header('Location: user_management.php');
            exit;
        }

        try {
            $this->model->delete($user_id);
            set_flash('success', 'Utilisateur supprimé avec succès !');
            header('Location: user_management.php');
            exit;
        } catch (PDOException $e) {
            set_flash('error', 'Une erreur est survenue lors de la suppression.');
            header('Location: user_management.php');
            exit;
        }
    }
}
