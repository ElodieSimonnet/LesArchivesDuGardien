<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function restrictToAdmin() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Administrateur') {
        header('Location: ../index.php');
        exit;
    }
}
