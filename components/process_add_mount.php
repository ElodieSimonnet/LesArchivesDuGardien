<?php
require_once 'utils/db_connection.php';
require_once 'utils/is_admin.php';
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification du jeton CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        set_flash('error', 'Erreur de sécurité : requête non autorisée.');
        header('Location: ../add_mount.php');
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
    $droprate = (isset($_POST['droprate']) && $_POST['droprate'] !== '') ? (float) $_POST['droprate'] : null;
    $cost = (isset($_POST['cost']) && $_POST['cost'] !== '') ? (int) $_POST['cost'] : null;
    $id_currency = !empty($_POST['id_currency']) ? (int) $_POST['id_currency'] : null;
    $id_zone = !empty($_POST['id_zone']) ? (int) $_POST['id_zone'] : null;
    $id_target = !empty($_POST['id_target']) ? (int) $_POST['id_target'] : null;

    // Validation : nom non vide
    if (empty($name)) {
        set_flash('error', 'Le nom de la monture est obligatoire.');
        header('Location: ../add_mount.php');
        exit;
    }

    // Validation que le type existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_mount_types WHERE id = :id");
    $stmt->execute([':id' => $id_type]);
    if ($stmt->fetchColumn() == 0) {
        set_flash('error', 'Le type sélectionné est invalide.');
        header('Location: ../add_mount.php');
        exit;
    }

    // Validation que la source existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_sources WHERE id = :id");
    $stmt->execute([':id' => $id_source]);
    if ($stmt->fetchColumn() == 0) {
        set_flash('error', 'La source sélectionnée est invalide.');
        header('Location: ../add_mount.php');
        exit;
    }

    // Validation que l'extension existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_expansions WHERE id = :id");
    $stmt->execute([':id' => $id_expansion]);
    if ($stmt->fetchColumn() == 0) {
        set_flash('error', 'L\'extension sélectionnée est invalide.');
        header('Location: ../add_mount.php');
        exit;
    }

    // Validation que la faction existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_factions WHERE id = :id");
    $stmt->execute([':id' => $id_faction]);
    if ($stmt->fetchColumn() == 0) {
        set_flash('error', 'La faction sélectionnée est invalide.');
        header('Location: ../add_mount.php');
        exit;
    }

    // Validation que la difficulté existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_difficulties WHERE id = :id");
    $stmt->execute([':id' => $id_difficulty]);
    if ($stmt->fetchColumn() == 0) {
        set_flash('error', 'La difficulté sélectionnée est invalide.');
        header('Location: ../add_mount.php');
        exit;
    }

    // Vérification unicité du nom
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_mounts WHERE name = :name");
    $stmt->execute([':name' => $name]);
    if ($stmt->fetchColumn() > 0) {
        set_flash('error', 'Une monture avec ce nom existe déjà.');
        header('Location: ../add_mount.php');
        exit;
    }

    try {
        $sql = "INSERT INTO adg_mounts (name, description, image, id_type, id_source, id_expansion, id_faction, id_difficulty, droprate, cost, id_currency, id_zone, id_target)
                VALUES (:name, :description, :image, :id_type, :id_source, :id_expansion, :id_faction, :id_difficulty, :droprate, :cost, :id_currency, :id_zone, :id_target)";

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
            ':cost' => $cost,
            ':id_currency' => $id_currency,
            ':id_zone' => $id_zone,
            ':id_target' => $id_target,
        ]);

        set_flash('success', 'Monture créée avec succès !');
        header('Location: ../admin_mount_gestion.php');
        exit;

    } catch (PDOException $e) {
        set_flash('error', 'Une erreur est survenue lors de la création.');
        header('Location: ../add_mount.php');
        exit;
    }
} else {
    header('Location: ../admin_mount_gestion.php');
    exit;
}
