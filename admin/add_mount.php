<?php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/MountModel.php';
require_once __DIR__ . '/../controllers/MountController.php';

$controller = new MountController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->create();
} else {
    $controller->showAddForm();
}
