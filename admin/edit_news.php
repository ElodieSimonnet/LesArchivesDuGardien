<?php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/NewsModel.php';
require_once __DIR__ . '/../controllers/NewsController.php';

$controller = new NewsController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->update();
} else {
    $controller->showEditForm();
}
