<?php
require_once 'db_connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Non connecté.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée.']);
    exit;
}

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    header('HTTP/1.1 403 Forbidden');
    echo json_encode(['status' => 'error', 'message' => 'Erreur de sécurité.']);
    exit;
}

$type = $_POST['type'] ?? '';
$itemId = (int)($_POST['item_id'] ?? 0);
$userId = $_SESSION['user_id'];

if ($itemId <= 0 || !in_array($type, ['mount', 'pet'])) {
    echo json_encode(['status' => 'error', 'message' => 'Paramètres invalides.']);
    exit;
}

$table = $type === 'mount' ? 'adg_wishlist_mounts' : 'adg_wishlist_pets';
$column = $type === 'mount' ? 'id_mount' : 'id_pet';

$check = $db->prepare("SELECT id FROM $table WHERE id_user = ? AND $column = ?");
$check->execute([$userId, $itemId]);

if ($check->fetch()) {
    $db->prepare("DELETE FROM $table WHERE id_user = ? AND $column = ?")->execute([$userId, $itemId]);
    echo json_encode(['status' => 'removed']);
} else {
    $db->prepare("INSERT INTO $table (id_user, $column, added_at) VALUES (?, ?, NOW())")->execute([$userId, $itemId]);
    echo json_encode(['status' => 'added']);
}
