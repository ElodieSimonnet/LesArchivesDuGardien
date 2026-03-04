<?php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/MountModel.php';
require_once __DIR__ . '/../controllers/MountController.php';

$controller = new MountController();
$controller->adminView();
