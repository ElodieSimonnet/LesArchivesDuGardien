<?php
require_once 'utils/db_connection.php';
require_once 'utils/is_admin.php';
restrictToAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification du jeton CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        set_flash('error', 'Erreur de sécurité : requête non autorisée.');
        header('Location: ../admin_pet_gestion.php');
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
    $droprate = (isset($_POST['droprate']) && $_POST['droprate'] !== '') ? (float) $_POST['droprate'] : null;
    $cost = (isset($_POST['cost']) && $_POST['cost'] !== '') ? (int) $_POST['cost'] : null;
    $id_zone = !empty($_POST['id_zone']) ? (int) $_POST['id_zone'] : null;
    $id_currency = !empty($_POST['id_currency']) ? (int) $_POST['id_currency'] : null;
    $id_target = !empty($_POST['id_target']) ? (int) $_POST['id_target'] : null;
    $spells = [];
    for ($i = 1; $i <= 6; $i++) {
        $spells[$i] = !empty($_POST['spell_' . $i]) ? (int) $_POST['spell_' . $i] : null;
    }

    // Validation minimale
    if (empty($name)) {
        set_flash('error', 'Le nom de la mascotte est obligatoire.');
        header('Location: ../admin_pet_gestion.php');
        exit;
    }

    // Validation que la famille existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_pet_families WHERE id = :id");
    $stmt->execute([':id' => $id_family]);
    if ($stmt->fetchColumn() == 0) {
        set_flash('error', 'La famille sélectionnée est invalide.');
        header('Location: ../admin_pet_gestion.php');
        exit;
    }

    // Validation que la source existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_sources WHERE id = :id");
    $stmt->execute([':id' => $id_source]);
    if ($stmt->fetchColumn() == 0) {
        set_flash('error', 'La source sélectionnée est invalide.');
        header('Location: ../admin_pet_gestion.php');
        exit;
    }

    // Validation que l'extension existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_expansions WHERE id = :id");
    $stmt->execute([':id' => $id_expansion]);
    if ($stmt->fetchColumn() == 0) {
        set_flash('error', 'L\'extension sélectionnée est invalide.');
        header('Location: ../admin_pet_gestion.php');
        exit;
    }

    // Validation que la faction existe en BDD
    $stmt = $db->prepare("SELECT COUNT(*) FROM adg_factions WHERE id = :id");
    $stmt->execute([':id' => $id_faction]);
    if ($stmt->fetchColumn() == 0) {
        set_flash('error', 'La faction sélectionnée est invalide.');
        header('Location: ../admin_pet_gestion.php');
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
                id_zone = :id_zone,
                id_currency = :id_currency,
                id_target = :id_target,
                spell_1 = :spell_1,
                spell_2 = :spell_2,
                spell_3 = :spell_3,
                spell_4 = :spell_4,
                spell_5 = :spell_5,
                spell_6 = :spell_6
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
            ':id_zone' => $id_zone,
            ':id_currency' => $id_currency,
            ':id_target' => $id_target,
            ':spell_1' => $spells[1],
            ':spell_2' => $spells[2],
            ':spell_3' => $spells[3],
            ':spell_4' => $spells[4],
            ':spell_5' => $spells[5],
            ':spell_6' => $spells[6],
            ':id' => $pet_id
        ]);

        set_flash('success', 'Mascotte mise à jour avec succès !');
        header('Location: ../admin_pet_gestion.php');
        exit;

    } catch (PDOException $e) {
        set_flash('error', 'Une erreur est survenue lors de la modification.');
        header('Location: ../admin_pet_gestion.php');
        exit;
    }
} else {
    header('Location: ../admin_pet_gestion.php');
    exit;
}
