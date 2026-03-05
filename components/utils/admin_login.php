<?php
require_once __DIR__ . '/../../models/Database.php';
$db = Database::getConnection();

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header('HTTP/1.1 403 Forbidden');
        echo json_encode(['status' => 'error', 'message' => 'Erreur : Requête invalide.']);
        exit;
    }

    $identifier = trim($_POST['username']);
    $password = $_POST['password'];

    
    $sql = "SELECT adg_users.*, adg_roles.role_name
            FROM adg_users
            INNER JOIN adg_roles ON adg_users.id_role = adg_roles.id
            WHERE adg_users.username = ? OR adg_users.email = ?";

    $stmt = $db->prepare($sql);
    $stmt->execute([$identifier, $identifier]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    
    if (!$user) {
        echo json_encode(['status' => 'error', 'message' => 'Identifiants invalides.']);
        exit;
    }

    
    if (!empty($user['locked_until']) && strtotime($user['locked_until']) > time()) {
        $minutesRestantes = ceil((strtotime($user['locked_until']) - time()) / 60);
        echo json_encode([
            'status' => 'locked',
            'message' => "Compte temporairement bloqué. Réessayez dans $minutesRestantes minute(s)."
        ]);
        exit;
    }

    
    if (password_verify($password, $user['password'])) {
        
        $reset = $db->prepare("UPDATE adg_users SET failed_attempts = 0, locked_until = NULL WHERE id = ?");
        $reset->execute([$user['id']]);

        
        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        
        $_SESSION['role'] = $user['role_name'];

        echo json_encode(['status' => 'success']);
    } else {
        
        $newAttempts = $user['failed_attempts'] + 1;

        if ($newAttempts >= 3) {
            $lockedUntil = date('Y-m-d H:i:s', strtotime('+15 minutes'));
            $update = $db->prepare("UPDATE adg_users SET failed_attempts = ?, locked_until = ? WHERE id = ?");
            $update->execute([$newAttempts, $lockedUntil, $user['id']]);

            echo json_encode([
                'status' => 'locked',
                'message' => 'Trop de tentatives échouées. Compte bloqué pour 15 minutes.'
            ]);
        } else {
            $update = $db->prepare("UPDATE adg_users SET failed_attempts = ? WHERE id = ?");
            $update->execute([$newAttempts, $user['id']]);

            $restantes = 3 - $newAttempts;
            echo json_encode([
                'status' => 'error',
                'message' => "Identifiants invalides. Il vous reste $restantes tentative(s)."
            ]);
        }
    }
}
