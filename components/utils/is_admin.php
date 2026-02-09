<?php
// On vérifie si une session est déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
 * Fonction pour sécuriser une page admin
 */
function restrictToAdmin() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Administrateur') {
        // Si pas admin, on bloque et on redirige
        header('Location: index.php');
        exit;
    }
}