<?php
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
        INNER JOIN adg_sources      ON adg_pets.id_source    = adg_sources.id";

$conditions = [];
$params = [];
$paramIndex = 0;

function addPetMultiFilter(string $column, string $paramName, array &$conditions, array &$params, int &$paramIndex): void {
    $values = isset($_GET[$paramName]) ? (array) $_GET[$paramName] : [];
    $values = array_filter($values, fn($v) => $v !== '' && $v !== 'all');

    if (!empty($values)) {
        $placeholders = [];
        foreach ($values as $value) {
            $key = ":{$paramName}_{$paramIndex}";
            $placeholders[] = "LOWER({$column}) = LOWER({$key})";
            $params[$key] = $value;
            $paramIndex++;
        }
        $conditions[] = '(' . implode(' OR ', $placeholders) . ')';
    }
}

addPetMultiFilter('adg_pet_families.family', 'family', $conditions, $params, $paramIndex);
addPetMultiFilter('adg_sources.source', 'source', $conditions, $params, $paramIndex);
addPetMultiFilter('adg_expansions.expansion', 'expansion', $conditions, $params, $paramIndex);
addPetMultiFilter('adg_factions.faction', 'faction', $conditions, $params, $paramIndex);

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$sql .= " ORDER BY adg_pets.id ASC";

$stmt = $db->prepare($sql);
$stmt->execute($params);

$all_pets = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les listes pour les filtres
$all_families = $db->query("SELECT family FROM adg_pet_families ORDER BY family ASC")->fetchAll(PDO::FETCH_ASSOC);
$all_pet_sources = $db->query("SELECT source FROM adg_sources ORDER BY source ASC")->fetchAll(PDO::FETCH_ASSOC);
$all_pet_expansions = $db->query("SELECT expansion FROM adg_expansions ORDER BY expansion ASC")->fetchAll(PDO::FETCH_ASSOC);
$all_pet_factions = $db->query("SELECT faction FROM adg_factions ORDER BY faction ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
