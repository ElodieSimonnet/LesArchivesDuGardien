<?php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/FaqModel.php';
require_once __DIR__ . '/../controllers/FaqController.php';

$controller = new FaqController();
$controller->delete();
