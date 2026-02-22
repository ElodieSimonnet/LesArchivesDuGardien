<?php

/**
 * Stocke un message flash en session (une seule utilisation).
 * @param string $type    'success' ou 'error'
 * @param string $message Le message à afficher
 */
function set_flash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

/**
 * Récupère et supprime le message flash de la session.
 * @return array|null ['type' => ..., 'message' => ...] ou null si aucun message
 */
function get_flash(): ?array {
    if (!isset($_SESSION['flash'])) return null;
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}
