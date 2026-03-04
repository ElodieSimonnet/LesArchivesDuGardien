<?php
require_once __DIR__ . '/models/Database.php';
Database::getConnection();
require __DIR__ . '/views/legals.php';
