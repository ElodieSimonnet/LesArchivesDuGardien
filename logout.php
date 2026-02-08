<?php
// On inclut la connexion pour démarrer la session et accéder au jeton CSRF
require_once 'components/utils/db_connection.php';

/*
  SÉCURITÉ RENFORCÉE
  On n'autorise la déconnexion que si elle provient d'un formulaire (POST)
  et que le jeton de sécurité (CSRF) est valide.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Vérification du jeton CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        // Tentative de déconnexion suspecte ou jeton expiré
        header("Location: index.php?error=security_breach");
        exit();
    }

    // Nettoyage des variables de session
    $_SESSION = array();

    // Destruction du cookie de session dans le navigateur
    // Cela empêche quelqu'un de récupérer un vieil identifiant de session
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], 
            $params["domain"],
            $params["secure"], 
            $params["httponly"]
        );
    }

    // Destruction physique de la session sur le serveur
    session_destroy();

    // Redirection avec un message de succès
    header("Location: index.php?status=logged_out");
    exit();

} else {
    /*
     * Si l'utilisateur tape "logout.php" dans la barre d'adresse (GET),
     * on refuse l'action car elle n'est pas sécurisée contre le CSRF.
     */
    header("Location: index.php");
    exit();
}