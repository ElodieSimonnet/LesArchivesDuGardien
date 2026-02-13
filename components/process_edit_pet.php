<?php
require_once 'utils/db_connection.php';
require_once 'utils/is_admin.php';
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification du jeton CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header('Location: ../admin_pet_gestion.php?error=csrf');
        exit;
    }

    // Nettoyage des données
    $pet_id = (int) $_POST['pet_id'];
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $image = trim($_POST['image']);
    $id_family = (int) $_POST['id_family'];
    $id_source = (int) $_POST['id_source'];
    $id_expansion = (int) $_POST['id_expansion'];
    $id_faction = (int) $_POST['id_faction'];
    $droprate = (float) $_POST['droprate'];
    $cost = (int) $_POST['cost'];
    $is_available = (int) $_POST['is_available'];

    // Validation minimale
    if (empty($name)) {
        header('Location: ../admin_pet_gestion.php?error=fields');
        exit;
    }

    // Validation que la famille existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_pet_families WHERE id = :id");
    $stmt->execute([':id' => $id_family]);
    if ($stmt->fetchColumn() == 0) {
        header('Location: ../admin_pet_gestion.php?error=invalid_family');
        exit;
    }

    // Validation que la source existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_sources WHERE id = :id");
    $stmt->execute([':id' => $id_source]);
    if ($stmt->fetchColumn() == 0) {
        header('Location: ../admin_pet_gestion.php?error=invalid_source');
        exit;
    }

    // Validation que l'extension existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_expansions WHERE id = :id");
    $stmt->execute([':id' => $id_expansion]);
    if ($stmt->fetchColumn() == 0) {
        header('Location: ../admin_pet_gestion.php?error=invalid_expansion');
        exit;
    }

    // Validation que la faction existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_factions WHERE id = :id");
    $stmt->execute([':id' => $id_faction]);
    if ($stmt->fetchColumn() == 0) {
        header('Location: ../admin_pet_gestion.php?error=invalid_faction');
        exit;
    }

    try {
        $sql = "UPDATE adg_pets SET
                name = :name,
                description = :description,
                image = :image,
                id_family = :id_family,
                id_source = :id_source,
                id_expansion = :id_expansion,
                id_faction = :id_faction,
                droprate = :droprate,
                cost = :cost,
                is_available = :is_available
                WHERE id = :id";

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
            ':id' => $pet_id
        ]);

        header('Location: ../admin_pet_gestion.php?success=1');
        exit;

    } catch (PDOException $e) {
        header('Location: ../admin_pet_gestion.php?error=sql');
        exit;
    }
} else {
    header('Location: ../admin_pet_gestion.php');
    exit;
}
