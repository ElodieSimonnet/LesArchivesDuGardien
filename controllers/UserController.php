<?php

class UserController
{
    private UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

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

    public function logout(string $redirectTo = 'index.php'): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                header('Location: ' . $redirectTo . '?error=security_breach');
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
            header('Location: ' . $redirectTo . '?status=logged_out');
            exit;
        }

        header('Location: ' . $redirectTo);
        exit;
    }

    public function adminLogin(): void
    {
        require __DIR__ . '/../views/admin/login.php';
    }

    public function dashboard(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        $stats = $this->model->getDashboardStats();
        extract($stats);

$all_users = $this->model->getAll();

        require __DIR__ . '/../views/admin/dashboard.php';
    }

    public function adminList(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        $filters = [
            'status' => $_GET['status'] ?? 'all',
            'role'   => $_GET['role'] ?? 'all',
        ];

        $all_users = $this->model->getAll($filters);

        require __DIR__ . '/../views/admin/user_management.php';
    }

    public function adminView(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
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

    public function showAddForm(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        $all_roles    = $this->model->getAllRoles();
        $all_statuses = $this->model->getAllStatuses();

        require __DIR__ . '/../views/admin/add_user.php';
    }

    public function showEditForm(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
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

    public function create(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
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

    public function update(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
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

    public function delete(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
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

    public function login(): void
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée.']);
            return;
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            header('HTTP/1.1 403 Forbidden');
            echo json_encode(['status' => 'error', 'message' => 'Erreur de sécurité : session expirée ou requête invalide.']);
            return;
        }

        $identifier = trim($_POST['username']);
        $password   = $_POST['password'];

        $user = $this->model->findByIdentifier($identifier);

        if (!$user) {
            echo json_encode(['status' => 'error', 'message' => 'Identifiants incorrects.']);
            return;
        }

        if ($user['role_name'] === 'Administrateur') {
            echo json_encode(['status' => 'error', 'message' => 'Identifiants incorrects.']);
            return;
        }

        if ($user['status'] !== 'Actif') {
            echo json_encode(['status' => 'error', 'message' => 'Ce compte est suspendu ou banni.']);
            return;
        }

        if (!empty($user['locked_until']) && strtotime($user['locked_until']) > time()) {
            $minutesRestantes = ceil((strtotime($user['locked_until']) - time()) / 60);
            echo json_encode(['status' => 'locked', 'message' => "Compte temporairement bloqué. Réessayez dans $minutesRestantes minute(s)."]);
            return;
        }

        if (password_verify($password, $user['password'])) {
            $this->model->resetFailedAttempts($user['id']);
            session_regenerate_id(true);
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            set_flash('success', 'Bienvenue ! Vous êtes connecté.');
            echo json_encode(['status' => 'success', 'redirect' => 'profile.php']);
        } else {
            $newAttempts = $user['failed_attempts'] + 1;
            if ($newAttempts >= 3) {
                $lockedUntil = date('Y-m-d H:i:s', strtotime('+15 minutes'));
                $this->model->updateFailedAttempts($user['id'], $newAttempts, $lockedUntil);
                echo json_encode(['status' => 'locked', 'message' => 'Trop de tentatives échouées. Compte bloqué pour 15 minutes.']);
            } else {
                $this->model->updateFailedAttempts($user['id'], $newAttempts);
                echo json_encode(['status' => 'error', 'message' => 'Identifiants incorrects.']);
            }
        }
    }

    public function processAdminLogin(): void
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée.']);
            return;
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            header('HTTP/1.1 403 Forbidden');
            echo json_encode(['status' => 'error', 'message' => 'Erreur : Requête invalide.']);
            return;
        }

        $identifier = trim($_POST['username']);
        $password   = $_POST['password'];

        $user = $this->model->findAdminByIdentifier($identifier);

        if (!$user) {
            echo json_encode(['status' => 'error', 'message' => 'Identifiants invalides.']);
            return;
        }

        if (!empty($user['locked_until']) && strtotime($user['locked_until']) > time()) {
            $minutesRestantes = ceil((strtotime($user['locked_until']) - time()) / 60);
            echo json_encode(['status' => 'locked', 'message' => "Compte temporairement bloqué. Réessayez dans $minutesRestantes minute(s)."]);
            return;
        }

        if (password_verify($password, $user['password'])) {
            $this->model->resetFailedAttempts($user['id']);
            session_regenerate_id(true);
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = $user['role_name'];
            echo json_encode(['status' => 'success']);
        } else {
            $newAttempts = $user['failed_attempts'] + 1;
            if ($newAttempts >= 3) {
                $lockedUntil = date('Y-m-d H:i:s', strtotime('+15 minutes'));
                $this->model->updateFailedAttempts($user['id'], $newAttempts, $lockedUntil);
                echo json_encode(['status' => 'locked', 'message' => 'Trop de tentatives échouées. Compte bloqué pour 15 minutes.']);
            } else {
                $this->model->updateFailedAttempts($user['id'], $newAttempts);
                $restantes = 3 - $newAttempts;
                echo json_encode(['status' => 'error', 'message' => "Identifiants invalides. Il vous reste $restantes tentative(s)."]);
            }
        }
    }

    public function register(): void
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée.']);
            return;
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            header('HTTP/1.1 403 Forbidden');
            echo json_encode(['status' => 'error', 'message' => 'Erreur de sécurité : Requête non autorisée.']);
            return;
        }

        if (empty($_POST['consent'])) {
            echo json_encode(['status' => 'error', 'message' => 'Vous devez accepter la politique de confidentialité pour créer un compte.']);
            return;
        }

        $username        = trim($_POST['username']);
        $email           = trim($_POST['email']);
        $password        = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['status' => 'error', 'message' => 'Adresse e-mail invalide.']);
            return;
        }

        if ($password !== $confirmPassword) {
            echo json_encode(['status' => 'error', 'message' => 'Les mots de passe ne correspondent pas.']);
            return;
        }

        if (strlen($password) < 12) {
            echo json_encode(['status' => 'error', 'message' => 'Le mot de passe doit contenir au moins 12 caractères.']);
            return;
        }
        if (!preg_match('/[A-Z]/', $password)) {
            echo json_encode(['status' => 'error', 'message' => 'Le mot de passe doit contenir au moins une majuscule.']);
            return;
        }
        if (!preg_match('/[a-z]/', $password)) {
            echo json_encode(['status' => 'error', 'message' => 'Le mot de passe doit contenir au moins une minuscule.']);
            return;
        }
        if (!preg_match('/[0-9]/', $password)) {
            echo json_encode(['status' => 'error', 'message' => 'Le mot de passe doit contenir au moins un chiffre.']);
            return;
        }
        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            echo json_encode(['status' => 'error', 'message' => 'Le mot de passe doit contenir au moins un caractère spécial.']);
            return;
        }

        try {
            $newUserId = $this->model->register($username, $email, password_hash($password, PASSWORD_DEFAULT));
            session_regenerate_id(true);
            $_SESSION['user_id']  = $newUserId;
            $_SESSION['username'] = $username;
            set_flash('success', 'Bienvenue aux Archives du Gardien ! Votre compte a bien été créé.');
            echo json_encode(['status' => 'success', 'redirect' => 'profile.php']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Cet aventurier (ou cet email) existe déjà.']);
        }
    }

    public function updateProfile(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ../index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ../profile.php');
            exit;
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            set_flash('error', 'Erreur de sécurité : requête non autorisée.');
            header('Location: ../profile.php');
            exit;
        }

        $type            = $_POST['type'] ?? '';
        $currentPassword = $_POST['current_password'] ?? '';

        $user = $this->model->getRawById((int) $_SESSION['user_id']);

        if (!$user) {
            header('Location: ../index.php');
            exit;
        }

        if (!password_verify($currentPassword, $user['password'])) {
            set_flash('error', 'Mot de passe actuel incorrect.');
            header('Location: ../profile.php');
            exit;
        }

        if ($type === 'email') {
            $newEmail = trim($_POST['email'] ?? '');

            if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                set_flash('error', "L'adresse email n'est pas valide.");
                header('Location: ../profile.php');
                exit;
            }

            if ($this->model->emailExists($newEmail, (int) $_SESSION['user_id'])) {
                set_flash('error', 'Cette adresse email est déjà utilisée.');
                header('Location: ../profile.php');
                exit;
            }

            $this->model->updateEmail((int) $_SESSION['user_id'], $newEmail);
            set_flash('success', 'Email mis à jour avec succès.');
            header('Location: ../profile.php');
            exit;
        }

        if ($type === 'username') {
            $newUsername = trim($_POST['username'] ?? '');

            if (empty($newUsername) || strlen($newUsername) < 2 || strlen($newUsername) > 30) {
                set_flash('error', "Le nom d'utilisateur doit contenir entre 2 et 30 caractères.");
                header('Location: ../profile.php');
                exit;
            }

            if ($this->model->usernameExists($newUsername, (int) $_SESSION['user_id'])) {
                set_flash('error', "Ce nom d'utilisateur est déjà pris.");
                header('Location: ../profile.php');
                exit;
            }

            $this->model->updateUsername((int) $_SESSION['user_id'], $newUsername);
            $_SESSION['username'] = $newUsername;
            set_flash('success', "Nom d'utilisateur mis à jour avec succès.");
            header('Location: ../profile.php');
            exit;
        }

        if ($type === 'password') {
            $newPassword     = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if ($newPassword !== $confirmPassword) {
                set_flash('error', 'Les mots de passe ne correspondent pas.');
                header('Location: ../profile.php');
                exit;
            }

            if (strlen($newPassword) < 12 || !preg_match('/[A-Z]/', $newPassword) ||
                !preg_match('/[a-z]/', $newPassword) || !preg_match('/[0-9]/', $newPassword) ||
                !preg_match('/[^A-Za-z0-9]/', $newPassword)) {
                set_flash('error', 'Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.');
                header('Location: ../profile.php');
                exit;
            }

            $this->model->updatePassword((int) $_SESSION['user_id'], password_hash($newPassword, PASSWORD_DEFAULT));
            set_flash('success', 'Mot de passe mis à jour avec succès.');
            header('Location: ../profile.php');
            exit;
        }

        header('Location: ../profile.php');
        exit;
    }

    public function deleteOwnAccount(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['confirm_delete']) || !isset($_SESSION['user_id'])) {
            header('Location: ../profile.php');
            exit;
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            set_flash('error', 'Erreur de sécurité : requête non autorisée.');
            header('Location: ../profile.php');
            exit;
        }

        $userId = (int) $_SESSION['user_id'];

        try {
            $avatarPath = $this->model->getAvatar($userId);
            $this->model->delete($userId);

            if (!empty($avatarPath)) {
                $filePath  = realpath(__DIR__ . '/../' . $avatarPath);
                $avatarDir = realpath(__DIR__ . '/../assets/avatars/');
                if ($filePath && $avatarDir && strpos($filePath, $avatarDir) === 0 && file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            session_unset();
            session_destroy();
            session_start();
            set_flash('success', 'Votre compte a été supprimé avec succès.');
            header('Location: ../index.php');
            exit;
        } catch (PDOException $e) {
            set_flash('error', 'La suppression du compte a échoué. Veuillez réessayer.');
            header('Location: ../profile.php');
            exit;
        }
    }

    public function uploadAvatar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
            header('Location: ../profile.php');
            exit;
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            set_flash('error', 'Erreur de sécurité : requête non autorisée.');
            header('Location: ../profile.php');
            exit;
        }

        if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== 0) {
            header('Location: ../profile.php');
            exit;
        }

        if ($_FILES['avatar']['size'] > 2 * 1024 * 1024) {
            set_flash('error', 'Le fichier est trop volumineux (2 Mo maximum).');
            header('Location: ../profile.php');
            exit;
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        $extension         = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, $allowedExtensions)) {
            set_flash('error', 'Format de fichier invalide. Formats acceptés : JPG, PNG, WEBP.');
            header('Location: ../profile.php');
            exit;
        }

        $tmpFile      = $_FILES['avatar']['tmp_name'];
        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
        $finfo        = new finfo(FILEINFO_MIME_TYPE);

        if (!in_array($finfo->file($tmpFile), $allowedMimes) || getimagesize($tmpFile) === false) {
            set_flash('error', 'Format de fichier invalide. Formats acceptés : JPG, PNG, WEBP.');
            header('Location: ../profile.php');
            exit;
        }

        $newFileName = "avatar_" . $_SESSION['user_id'] . "_" . bin2hex(random_bytes(3)) . "." . $extension;
        $destination = __DIR__ . "/../assets/avatars/" . $newFileName;

        if (move_uploaded_file($tmpFile, $destination)) {
            $this->model->updateAvatar((int) $_SESSION['user_id'], "assets/avatars/" . $newFileName);
            set_flash('success', 'Avatar mis à jour avec succès.');
        } else {
            set_flash('error', "L'upload a échoué. Veuillez réessayer.");
        }

        header('Location: ../profile.php');
        exit;
    }

    public function deleteAvatar(): void
    {
        require_once __DIR__ . '/../helpers/is_admin.php';
        restrictToAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ../admin/user_management.php');
            exit;
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            set_flash('error', 'Erreur de sécurité : requête non autorisée.');
            header('Location: ../admin/user_management.php');
            exit;
        }

        $userId = (int) ($_POST['user_id'] ?? 0);

        if ($userId <= 0) {
            set_flash('error', 'Identifiant invalide.');
            header('Location: ../admin/user_management.php');
            exit;
        }

        try {
            $avatarPath = $this->model->getAvatar($userId);

            if (!empty($avatarPath)) {
                $filePath  = realpath(__DIR__ . '/../' . $avatarPath);
                $avatarDir = realpath(__DIR__ . '/../assets/avatars/');
                if ($filePath && $avatarDir && strpos($filePath, $avatarDir) === 0 && file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $this->model->updateAvatar($userId, null);
            set_flash('success', 'Avatar supprimé avec succès !');
            header('Location: ../admin/edit_user.php?id=' . $userId);
            exit;
        } catch (PDOException $e) {
            set_flash('error', "Une erreur est survenue lors de la suppression de l'avatar.");
            header('Location: ../admin/edit_user.php?id=' . $userId);
            exit;
        }
    }

    public function toggleCollection(): void
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Non connecté.']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée.']);
            return;
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            header('HTTP/1.1 403 Forbidden');
            echo json_encode(['status' => 'error', 'message' => 'Erreur de sécurité.']);
            return;
        }

        $type   = $_POST['type'] ?? '';
        $itemId = (int) ($_POST['item_id'] ?? 0);
        $userId = (int) $_SESSION['user_id'];

        if ($itemId <= 0 || !in_array($type, ['mount', 'pet'])) {
            echo json_encode(['status' => 'error', 'message' => 'Paramètres invalides.']);
            return;
        }

        echo json_encode(['status' => $this->model->toggleCollection($userId, $type, $itemId)]);
    }

    public function toggleWishlist(): void
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Non connecté.']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée.']);
            return;
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            header('HTTP/1.1 403 Forbidden');
            echo json_encode(['status' => 'error', 'message' => 'Erreur de sécurité.']);
            return;
        }

        $type   = $_POST['type'] ?? '';
        $itemId = (int) ($_POST['item_id'] ?? 0);
        $userId = (int) $_SESSION['user_id'];

        if ($itemId <= 0 || !in_array($type, ['mount', 'pet'])) {
            echo json_encode(['status' => 'error', 'message' => 'Paramètres invalides.']);
            return;
        }

        echo json_encode(['status' => $this->model->toggleWishlist($userId, $type, $itemId)]);
    }
}
