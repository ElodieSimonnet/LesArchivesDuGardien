<?php
// SECTION MONTURES
// Compter les montures possédées par l'utilisateur
$stmtOwnedMounts = $db->prepare("SELECT COUNT(*) FROM adg_user_mounts WHERE id_user = ?");
$stmtOwnedMounts->execute([$_SESSION['user_id']]);
$countOwnedMounts = $stmtOwnedMounts->fetchColumn();

// Compter le total des montures disponibles dans le catalogue
$stmtTotalMounts = $db->query("SELECT COUNT(*) FROM adg_mounts");
$countTotalMounts = $stmtTotalMounts->fetchColumn();


// SECTION MASCOTTES
// Compter les mascottes possédées par l'utilisateur
$stmtOwnedPets = $db->prepare("SELECT COUNT(*) FROM adg_user_pets WHERE id_user = ?");
$stmtOwnedPets->execute([$_SESSION['user_id']]);
$countOwnedPets = $stmtOwnedPets->fetchColumn();

// Compter le total des mascottes disponibles dans le catalogue
$stmtTotalPets = $db->query("SELECT COUNT(*) FROM adg_pets");
$countTotalPets = $stmtTotalPets->fetchColumn();
?>