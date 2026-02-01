<?php
include "components/utils/db_connection.php";

$sql = "SELECT 
            adg_mounts.*, 
            adg_difficulties.difficulty,
            adg_mount_types.type
        FROM adg_mounts
        INNER JOIN adg_difficulties ON adg_mounts.id_difficulty = adg_difficulties.id
        INNER JOIN adg_mount_types  ON adg_mounts.id_type       = adg_mount_types.id";

$query = $db->prepare($sql);
$query->execute();
$mounts = $query->fetchAll();

?>



