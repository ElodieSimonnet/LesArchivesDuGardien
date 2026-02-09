<?php
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // VÉRIFICATION DU JETON CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header('HTTP/1.1 403 Forbidden');
        exit("Erreur : Requête invalide.");
    }

    $identifier = trim($_POST['username']);
    $password = $_POST['password'];

    // PRÉPARATION DE LA REQUÊTE
    $sql = "SELECT adg_users.*, adg_roles.role_name 
            FROM adg_users
            INNER JOIN adg_roles ON adg_users.id_role = adg_roles.id 
            WHERE adg_users.username = ? OR adg_users.email = ?";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([$identifier, $identifier]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // VÉRIFICATION DU MOT DE PASSE ET CRÉATION DE SESSION
    if ($user && password_verify($password, $user['password'])) {
        
        // Protection contre la fixation de session
        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        
        // On récupère "Administrateur" ou "Utilisateur" depuis la table adg_roles
        $_SESSION['role'] = $user['role_name']; 

        echo "success";
    } else {
        echo "Identifiants invalides.";
    }
}