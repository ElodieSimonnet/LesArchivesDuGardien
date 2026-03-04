<?php

/**
 * ============================================================
 * CONTRÔLEUR : HomeController
 * ============================================================
 * Rôle : Gérer l'affichage de la page d'accueil.
 *
 * La page d'accueil ne nécessite pas de requête BDD,
 * donc ce contrôleur est très simple : il charge juste la vue.
 * ============================================================
 */

class HomeController
{
    /**
     * Affiche la page d'accueil.
     */
    public function home(): void
    {
        Database::getConnection(); // démarre la session + génère le token CSRF
        require __DIR__ . '/../views/index.php';
    }
}
