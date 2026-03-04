<?php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../controllers/UserController.php';

$controller = new UserController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->update();
} else {
    $controller->showEditForm();
}
