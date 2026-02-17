<?php
include "components/utils/db_connection.php";

$userIdForCollection = $_SESSION['user_id'] ?? 0;

$sql = "SELECT
            adg_pets.*,
            adg_pet_families.family,
            adg_expansions.expansion,
            adg_factions.faction,
            adg_sources.source,
            CASE WHEN up.id IS NOT NULL THEN 1 ELSE 0 END AS is_owned,
            CASE WHEN wp.id IS NOT NULL THEN 1 ELSE 0 END AS is_wishlisted
        FROM adg_pets
        INNER JOIN adg_pet_families ON adg_pets.id_family    = adg_pet_families.id
        INNER JOIN adg_expansions   ON adg_pets.id_expansion = adg_expansions.id
        INNER JOIN adg_factions     ON adg_pets.id_faction   = adg_factions.id
        INNER JOIN adg_sources      ON adg_pets.id_source    = adg_sources.id
        LEFT JOIN adg_user_pets up ON adg_pets.id = up.id_pet AND up.id_user = :user_id
        LEFT JOIN adg_wishlist_pets wp ON adg_pets.id = wp.id_pet AND wp.id_user = :user_id2
        ORDER BY adg_pets.name ASC";

$query = $db->prepare($sql);
$query->execute([':user_id' => $userIdForCollection, ':user_id2' => $userIdForCollection]);
$pets = $query->fetchAll();
