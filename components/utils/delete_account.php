<?php
require_once __DIR__ . '/../../models/Database.php';
$db = Database::getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete']) && isset($_SESSION['user_id'])) {

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        
        set_flash('error', 'Erreur de sécurité : requête non autorisée.');
        header("Location: ../../profile.php");
        exit();
    }

    $userId = $_SESSION['user_id'];

    try {
        
        $stmt = $db->prepare("SELECT avatar FROM adg_users WHERE id = ?");
        $stmt->execute([$userId]);
        $avatar_path = $stmt->fetchColumn();

$db->prepare("DELETE FROM adg_user_mounts WHERE id_user = ?")->execute([$userId]);
        $db->prepare("DELETE FROM adg_user_pets WHERE id_user = ?")->execute([$userId]);
        $db->prepare("DELETE FROM adg_wishlist_mounts WHERE id_user = ?")->execute([$userId]);
        $db->prepare("DELETE FROM adg_wishlist_pets WHERE id_user = ?")->execute([$userId]);
        
        $db->prepare("UPDATE adg_news SET id_user = NULL WHERE id_user = ?")->execute([$userId]);

$stmt = $db->prepare("DELETE FROM adg_users WHERE id = ?");
        $stmt->execute([$userId]);

if (!empty($avatar_path)) {
            $filePath = realpath(__DIR__ . '/../../' . $avatar_path);
            $avatarDir = realpath(__DIR__ . '/../../assets/avatars/');
            if ($filePath && $avatarDir && strpos($filePath, $avatarDir) === 0 && file_exists($filePath)) {
                unlink($filePath);
            }
        }

session_unset(); 
        session_destroy();

session_start();
        set_flash('success', 'Votre compte a été supprimé avec succès.');

header("Location: ../../index.php");
        exit();

    } catch (PDOException $e) {
        set_flash('error', 'La suppression du compte a échoué. Veuillez réessayer.');
        header("Location: ../../profile.php");
        exit();
    }
} else {
    header("Location: ../../profile.php");
    exit();
}
