<?php
require_once 'components/utils/db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete']) && isset($_SESSION['user_id'])) {
    
    // VÉRIFICATION DU JETON CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        // Si le jeton est mauvais, on bloque tout
        header("Location: profile.php?error=security_breach");
        exit();
    }

    $userId = $_SESSION['user_id'];

    try {
        // On supprime d'abord les données liées à l'utilisateur
        $db->prepare("DELETE FROM adg_user_mounts WHERE id_user = ?")->execute([$userId]);
        $db->prepare("DELETE FROM adg_user_pets WHERE id_user = ?")->execute([$userId]);
        $db->prepare("DELETE FROM adg_wishlist_mounts WHERE id_user = ?")->execute([$userId]);
        $db->prepare("DELETE FROM adg_wishlist_pets WHERE id_user = ?")->execute([$userId]);
        // On conserve les news mais on retire l'auteur
        $db->prepare("UPDATE adg_news SET id_user = NULL WHERE id_user = ?")->execute([$userId]);

        // On supprime l'utilisateur de la table adg_users
        $stmt = $db->prepare("DELETE FROM adg_users WHERE id = ?");
        $stmt->execute([$userId]);

        // On nettoie la session et on déconnecte
        session_unset(); // On vide les variables de session d'abord
        session_destroy();
        
        // Retour à l'accueil
        header("Location: index.php?status=account_deleted");
        exit();

    } catch (PDOException $e) {
        header("Location: profile.php?error=delete_failed");
        exit();
    }
} else {
    header("Location: profile.php");
    exit();
}