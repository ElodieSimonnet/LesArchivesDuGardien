<?php
// Point d'entrée : page d'accueil
require_once __DIR__ . '/models/Database.php';
require_once __DIR__ . '/controllers/HomeController.php';

$controller = new HomeController();
$controller->home();
