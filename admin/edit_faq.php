<?php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/FaqModel.php';
require_once __DIR__ . '/../controllers/FaqController.php';

$controller = new FaqController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->update();
} else {
    $controller->showEditForm();
}
