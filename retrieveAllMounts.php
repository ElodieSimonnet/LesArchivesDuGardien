<?php
include "components/utils/db_connection.php";

$sql = "SELECT 
            adg_mounts.*,
            adg_expansions.expansion, 
            adg_factions.faction, 
            adg_sources.source,  
            adg_difficulties.difficulty,
            adg_mount_types.type
        FROM adg_mounts
        INNER JOIN adg_expansions   ON adg_mounts.id_expansion  = adg_expansions.id
        INNER JOIN adg_factions     ON adg_mounts.id_faction    = adg_factions.id
        INNER JOIN adg_sources      ON adg_mounts.id_source     = adg_sources.id
        INNER JOIN adg_difficulties ON adg_mounts.id_difficulty = adg_difficulties.id
        INNER JOIN adg_mount_types  ON adg_mounts.id_type       = adg_mount_types.id
        ORDER BY adg_mounts.name ASC";

$query = $db->prepare($sql);
$query->execute();
$mounts = $query->fetchAll();

?>



