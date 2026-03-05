<?php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/utils/is_admin.php';
$db = Database::getConnection();
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../admin/user_management.php');
    exit;
}

// Vérification du jeton CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    set_flash('error', 'Erreur de sécurité : requête non autorisée.');
    header('Location: ../../admin/user_management.php');
    exit;
}

$user_id = (int) ($_POST['user_id'] ?? 0);

if ($user_id <= 0) {
    set_flash('error', 'Identifiant invalide.');
    header('Location: ../admin/user_management.php');
    exit;
}

try {
    // Récupérer le chemin de l'avatar actuel
    $stmt = $db->prepare("SELECT avatar FROM adg_users WHERE id = :id");
    $stmt->execute([':id' => $user_id]);
    $avatar_path = $stmt->fetchColumn();

    // Supprimer le fichier du serveur s'il existe
    if (!empty($avatar_path)) {
        $filePath  = realpath(__DIR__ . '/../../' . $avatar_path);
        $avatarDir = realpath(__DIR__ . '/../../assets/avatars/');
        if ($filePath && $avatarDir && strpos($filePath, $avatarDir) === 0 && file_exists($filePath)) {
            unlink($filePath);
        }
    }

    // Remettre le champ avatar à NULL en BDD
    $stmt = $db->prepare("UPDATE adg_users SET avatar = NULL WHERE id = :id");
    $stmt->execute([':id' => $user_id]);

    set_flash('success', 'Avatar supprimé avec succès !');
    header('Location: ../../admin/edit_user.php?id=' . $user_id);
    exit;

} catch (PDOException $e) {
    set_flash('error', 'Une erreur est survenue lors de la suppression de l\'avatar.');
    header('Location: ../../admin/edit_user.php?id=' . $user_id);
    exit;
}
