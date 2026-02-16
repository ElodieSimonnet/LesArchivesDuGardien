<?php
require_once 'utils/db_connection.php';
require_once 'utils/is_admin.php';
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification du jeton CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header('Location: ../add_pet.php?error=csrf');
        exit;
    }

    // Nettoyage des données
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $image = trim($_POST['image']);
    $id_family = (int) $_POST['id_family'];
    $id_source = (int) $_POST['id_source'];
    $id_expansion = (int) $_POST['id_expansion'];
    $id_faction = (int) $_POST['id_faction'];
    $droprate = (isset($_POST['droprate']) && $_POST['droprate'] !== '') ? (float) $_POST['droprate'] : null;
    $cost = (isset($_POST['cost']) && $_POST['cost'] !== '') ? (int) $_POST['cost'] : null;
    $is_available = (int) $_POST['is_available'];
    $id_zone = !empty($_POST['id_zone']) ? (int) $_POST['id_zone'] : null;
    $id_currency = !empty($_POST['id_currency']) ? (int) $_POST['id_currency'] : null;

    // Validation : nom non vide
    if (empty($name)) {
        header('Location: ../add_pet.php?error=fields');
        exit;
    }

    // Validation que la famille existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_pet_families WHERE id = :id");
    $stmt->execute([':id' => $id_family]);
    if ($stmt->fetchColumn() == 0) {
        header('Location: ../add_pet.php?error=invalid_family');
        exit;
    }

    // Validation que la source existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_sources WHERE id = :id");
    $stmt->execute([':id' => $id_source]);
    if ($stmt->fetchColumn() == 0) {
        header('Location: ../add_pet.php?error=invalid_source');
        exit;
    }

    // Validation que l'extension existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_expansions WHERE id = :id");
    $stmt->execute([':id' => $id_expansion]);
    if ($stmt->fetchColumn() == 0) {
        header('Location: ../add_pet.php?error=invalid_expansion');
        exit;
    }

    // Validation que la faction existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_factions WHERE id = :id");
    $stmt->execute([':id' => $id_faction]);
    if ($stmt->fetchColumn() == 0) {
        header('Location: ../add_pet.php?error=invalid_faction');
        exit;
    }

    // Vérification unicité du nom
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_pets WHERE name = :name");
    $stmt->execute([':name' => $name]);
    if ($stmt->fetchColumn() > 0) {
        header('Location: ../add_pet.php?error=duplicate');
        exit;
    }

    try {
        $sql = "INSERT INTO adg_pets (name, description, image, id_family, id_source, id_expansion, id_faction, droprate, cost, is_available, id_zone, id_currency)
                VALUES (:name, :description, :image, :id_family, :id_source, :id_expansion, :id_faction, :droprate, :cost, :is_available, :id_zone, :id_currency)";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':description' => $description,
            ':image' => $image,
            ':id_family' => $id_family,
            ':id_source' => $id_source,
            ':id_expansion' => $id_expansion,
            ':id_faction' => $id_faction,
            ':droprate' => $droprate,
            ':cost' => $cost,
            ':is_available' => $is_available,
            ':id_zone' => $id_zone,
            ':id_currency' => $id_currency,
        ]);

        header('Location: ../admin_pet_gestion.php?success=pet_added');
        exit;

    } catch (PDOException $e) {
        header('Location: ../add_pet.php?error=sql');
        exit;
    }
} else {
    header('Location: ../admin_pet_gestion.php');
    exit;
}
