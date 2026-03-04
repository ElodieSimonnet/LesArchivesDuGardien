<?php
require_once __DIR__ . '/models/Database.php';
require_once __DIR__ . '/models/PetModel.php';
require_once __DIR__ . '/controllers/PetController.php';

$controller = new PetController();
$controller->list();
