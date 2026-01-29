<?php
include "components/utils/db_connection.php";

$mountId = 2;

$sql = "SELECT 
            adg_mounts.*, 
            adg_expansions.expansion, 
            adg_factions.faction, 
            adg_sources.source, 
            adg_difficulties.difficulty,
            adg_mount_types.type,
            adg_targets.target,      
            adg_zones.zone
        FROM adg_mounts
        INNER JOIN adg_expansions   ON adg_mounts.id_expansion  = adg_expansions.id
        INNER JOIN adg_factions     ON adg_mounts.id_faction    = adg_factions.id
        INNER JOIN adg_sources      ON adg_mounts.id_source     = adg_sources.id
        INNER JOIN adg_difficulties ON adg_mounts.id_difficulty = adg_difficulties.id
        INNER JOIN adg_mount_types  ON adg_mounts.id_type       = adg_mount_types.id
        LEFT JOIN adg_zones         ON adg_mounts.id_zone       = adg_zones.id_zone
        LEFT JOIN adg_targets       ON adg_mounts.id_target     = adg_targets.id
        WHERE adg_mounts.id = :id";

$query = $db->prepare($sql);
$query->execute(['id' => $mountId]); // on passe l'ID ici pour la sécurité
$mount = $query->fetch();

// GESTION DE L'IMAGE DU TYPE DE MONTURE

$mountTypeLink = "assets/images/mounts/" . $mount['type'] . ".png";
?>



