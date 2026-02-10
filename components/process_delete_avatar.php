<?php
require_once 'utils/db_connection.php';
require_once 'utils/is_admin.php';
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin_user_gestion.php');
    exit;
}

// Vérification du jeton CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    header('Location: ../admin_user_gestion.php?error=csrf');
    exit;
}

$user_id = (int) ($_POST['user_id'] ?? 0);

if ($user_id <= 0) {
    header('Location: ../admin_user_gestion.php?error=invalid_id');
    exit;
}

try {
    // Récupérer le chemin de l'avatar actuel
    $stmt = $db->prepare("SELECT avatar FROM adg_users WHERE id = :id");
    $stmt->execute([':id' => $user_id]);
    $avatar_path = $stmt->fetchColumn();

    // Supprimer le fichier du serveur s'il existe
    if (!empty($avatar_path) && file_exists('../' . $avatar_path)) {
        unlink('../' . $avatar_path);
    }

    // Remettre le champ avatar à NULL en BDD
    $stmt = $db->prepare("UPDATE adg_users SET avatar = NULL WHERE id = :id");
    $stmt->execute([':id' => $user_id]);

    header('Location: ../edit_user.php?id=' . $user_id . '&success=avatar_deleted');
    exit;

} catch (PDOException $e) {
    header('Location: ../edit_user.php?id=' . $user_id . '&error=sql');
    exit;
}
