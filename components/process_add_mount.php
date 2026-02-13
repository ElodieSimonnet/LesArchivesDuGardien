<?php
require_once 'utils/db_connection.php';
require_once 'utils/is_admin.php';
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification du jeton CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header('Location: ../add_mount.php?error=csrf');
        exit;
    }

    // Nettoyage des données
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $image = trim($_POST['image']);
    $id_type = (int) $_POST['id_type'];
    $id_source = (int) $_POST['id_source'];
    $id_expansion = (int) $_POST['id_expansion'];
    $id_faction = (int) $_POST['id_faction'];
    $id_difficulty = (int) $_POST['id_difficulty'];
    $droprate = (float) $_POST['droprate'];

    // Validation : nom non vide
    if (empty($name)) {
        header('Location: ../add_mount.php?error=fields');
        exit;
    }

    // Validation que le type existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_mount_types WHERE id = :id");
    $stmt->execute([':id' => $id_type]);
    if ($stmt->fetchColumn() == 0) {
        header('Location: ../add_mount.php?error=invalid_type');
        exit;
    }

    // Validation que la source existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_sources WHERE id = :id");
    $stmt->execute([':id' => $id_source]);
    if ($stmt->fetchColumn() == 0) {
        header('Location: ../add_mount.php?error=invalid_source');
        exit;
    }

    // Validation que l'extension existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_expansions WHERE id = :id");
    $stmt->execute([':id' => $id_expansion]);
    if ($stmt->fetchColumn() == 0) {
        header('Location: ../add_mount.php?error=invalid_expansion');
        exit;
    }

    // Validation que la faction existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_factions WHERE id = :id");
    $stmt->execute([':id' => $id_faction]);
    if ($stmt->fetchColumn() == 0) {
        header('Location: ../add_mount.php?error=invalid_faction');
        exit;
    }

    // Validation que la difficulté existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_difficulties WHERE id = :id");
    $stmt->execute([':id' => $id_difficulty]);
    if ($stmt->fetchColumn() == 0) {
        header('Location: ../add_mount.php?error=invalid_difficulty');
        exit;
    }

    // Vérification unicité du nom
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_mounts WHERE name = :name");
    $stmt->execute([':name' => $name]);
    if ($stmt->fetchColumn() > 0) {
        header('Location: ../add_mount.php?error=duplicate');
        exit;
    }

    try {
        $sql = "INSERT INTO adg_mounts (name, description, image, id_type, id_source, id_expansion, id_faction, id_difficulty, droprate)
                VALUES (:name, :description, :image, :id_type, :id_source, :id_expansion, :id_faction, :id_difficulty, :droprate)";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':description' => $description,
            ':image' => $image,
            ':id_type' => $id_type,
            ':id_source' => $id_source,
            ':id_expansion' => $id_expansion,
            ':id_faction' => $id_faction,
            ':id_difficulty' => $id_difficulty,
            ':droprate' => $droprate,
        ]);

        header('Location: ../admin_mount_gestion.php?success=mount_added');
        exit;

    } catch (PDOException $e) {
        header('Location: ../add_mount.php?error=sql');
        exit;
    }
} else {
    header('Location: ../admin_mount_gestion.php');
    exit;
}
