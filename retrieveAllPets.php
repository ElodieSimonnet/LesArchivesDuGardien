<?php
include "components/utils/db_connection.php";

$sql = "SELECT
            adg_pets.*,
            adg_pet_families.family,
            adg_expansions.expansion,
            adg_factions.faction,
            adg_sources.source
        FROM adg_pets
        INNER JOIN adg_pet_families ON adg_pets.id_family    = adg_pet_families.id
        INNER JOIN adg_expansions   ON adg_pets.id_expansion = adg_expansions.id
        INNER JOIN adg_factions     ON adg_pets.id_faction   = adg_factions.id
        INNER JOIN adg_sources      ON adg_pets.id_source    = adg_sources.id
        ORDER BY adg_pets.name ASC";

$query = $db->prepare($sql);
$query->execute();
$pets = $query->fetchAll();
