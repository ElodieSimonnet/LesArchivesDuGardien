<?php
require_once 'db_connection.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // VÉRIFICATION DU JETON CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode(['status' => 'error', 'message' => 'Erreur de sécurité : session expirée ou requête invalide.']);
        exit;
    }

    $identifier = trim($_POST['username']);
    $password = $_POST['password'];

    // On cherche l'utilisateur par pseudo ou email
    $stmt = $db->prepare("SELECT * FROM adg_users WHERE username = ? OR email = ?");
    $stmt->execute([$identifier, $identifier]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si l'utilisateur n'existe pas, on renvoie un message générique
    if (!$user) {
        echo json_encode(['status' => 'error', 'message' => 'Identifiants incorrects.']);
        exit;
    }

    // VÉRIFICATION DU BLOCAGE TEMPORAIRE
    if (!empty($user['locked_until']) && strtotime($user['locked_until']) > time()) {
        $minutesRestantes = ceil((strtotime($user['locked_until']) - time()) / 60);
        echo json_encode([
            'status' => 'locked',
            'message' => "Compte temporairement bloqué. Réessayez dans $minutesRestantes minute(s)."
        ]);
        exit;
    }

    // VÉRIFICATION DU MOT DE PASSE
    if (password_verify($password, $user['password'])) {
        // Succès : on réinitialise les tentatives
        $reset = $db->prepare("UPDATE adg_users SET failed_attempts = 0, locked_until = NULL WHERE id = ?");
        $reset->execute([$user['id']]);

        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        echo json_encode(['status' => 'success']);
    } else {
        // Échec : on incrémente les tentatives
        $newAttempts = $user['failed_attempts'] + 1;
        $lockedUntil = null;

        if ($newAttempts >= 3) {
            // Blocage pour 15 minutes
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
                'message' => "Identifiants incorrects. Il vous reste $restantes tentative(s)."
            ]);
        }
    }
}