<?php
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
        INNER JOIN adg_mount_types  ON adg_mounts.id_type       = adg_mount_types.id";

$conditions = [];
$params = [];
$paramIndex = 0;

// Fonction utilitaire pour gérer les filtres multi-valeurs
function addMultiFilter(string $column, string $paramName, array &$conditions, array &$params, int &$paramIndex): void {
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

addMultiFilter('adg_mount_types.type', 'type', $conditions, $params, $paramIndex);
addMultiFilter('adg_sources.source', 'source', $conditions, $params, $paramIndex);
addMultiFilter('adg_expansions.expansion', 'expansion', $conditions, $params, $paramIndex);
addMultiFilter('adg_factions.faction', 'faction', $conditions, $params, $paramIndex);
addMultiFilter('adg_difficulties.difficulty', 'difficulty', $conditions, $params, $paramIndex);

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$sql .= " ORDER BY adg_mounts.id ASC";

$stmt = $db->prepare($sql);
$stmt->execute($params);

$all_mounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les listes pour les filtres
$all_types = $db->query("SELECT type FROM adg_mount_types ORDER BY type ASC")->fetchAll(PDO::FETCH_ASSOC);
$all_sources = $db->query("SELECT source FROM adg_sources ORDER BY source ASC")->fetchAll(PDO::FETCH_ASSOC);
$all_expansions = $db->query("SELECT expansion FROM adg_expansions ORDER BY expansion ASC")->fetchAll(PDO::FETCH_ASSOC);
$all_factions = $db->query("SELECT faction FROM adg_factions ORDER BY faction ASC")->fetchAll(PDO::FETCH_ASSOC);
$all_difficulties = $db->query("SELECT difficulty FROM adg_difficulties ORDER BY difficulty ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
