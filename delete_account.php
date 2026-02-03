<?php
session_start();
require_once 'components/utils/db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete']) && isset($_SESSION['user_id'])) {
    
    $userId = $_SESSION['user_id'];

    try {
        // On supprime l'utilisateur de la table adg_users
        $stmt = $db->prepare("DELETE FROM adg_users WHERE id = ?");
        $stmt->execute([$userId]);

        // On nettoie la session et on déconnecte
        session_destroy();
        
        // Retour à l'accueil
        header("Location: index.php?status=account_deleted");
        exit();

    } catch (PDOException $e) {
        // En cas de pépin SQL
        header("Location: profile.php?error=delete_failed");
        exit();
    }
} else {
    // Si on arrive ici par erreur, on renvoie au profil
    header("Location: profile.php");
    exit();
}