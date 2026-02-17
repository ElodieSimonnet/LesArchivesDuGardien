<?php
include "components/utils/db_connection.php";

$userIdForCollection = $_SESSION['user_id'] ?? 0;

$sql = "SELECT
            adg_mounts.*,
            adg_expansions.expansion,
            adg_factions.faction,
            adg_sources.source,
            adg_difficulties.difficulty,
            adg_mount_types.type,
            CASE WHEN um.id IS NOT NULL THEN 1 ELSE 0 END AS is_owned,
            CASE WHEN wm.id IS NOT NULL THEN 1 ELSE 0 END AS is_wishlisted
        FROM adg_mounts
        INNER JOIN adg_expansions   ON adg_mounts.id_expansion  = adg_expansions.id
        INNER JOIN adg_factions     ON adg_mounts.id_faction    = adg_factions.id
        INNER JOIN adg_sources      ON adg_mounts.id_source     = adg_sources.id
        INNER JOIN adg_difficulties ON adg_mounts.id_difficulty = adg_difficulties.id
        INNER JOIN adg_mount_types  ON adg_mounts.id_type       = adg_mount_types.id
        LEFT JOIN adg_user_mounts um ON adg_mounts.id = um.id_mount AND um.id_user = :user_id
        LEFT JOIN adg_wishlist_mounts wm ON adg_mounts.id = wm.id_mount AND wm.id_user = :user_id2
        ORDER BY adg_mounts.name ASC";

$query = $db->prepare($sql);
$query->execute([':user_id' => $userIdForCollection, ':user_id2' => $userIdForCollection]);
$mounts = $query->fetchAll();

?>



