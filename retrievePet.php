<?php
include "components/utils/db_connection.php";

$petId = isset($_GET['id']) ? (int) $_GET['id'] : null;

if ($petId === null) {
    header('Location: pet_list.php');
    exit;
}

$sql = "SELECT
            adg_pets.*,
            adg_pet_families.family,
            adg_expansions.expansion,
            adg_factions.faction,
            adg_sources.source,
            adg_zones.zone,
            adg_currencies.name AS currency_name
        FROM adg_pets
        INNER JOIN adg_pet_families ON adg_pets.id_family    = adg_pet_families.id
        INNER JOIN adg_expansions   ON adg_pets.id_expansion = adg_expansions.id
        INNER JOIN adg_factions     ON adg_pets.id_faction   = adg_factions.id
        INNER JOIN adg_sources      ON adg_pets.id_source    = adg_sources.id
        LEFT JOIN adg_zones         ON adg_pets.id_zone      = adg_zones.id_zone
        LEFT JOIN adg_currencies    ON adg_pets.id_currency  = adg_currencies.id
        WHERE adg_pets.id = :id";

$query = $db->prepare($sql);
$query->execute(['id' => $petId]);
$pet = $query->fetch();

if (!$pet) {
    header('Location: pet_list.php');
    exit;
}

// Mapping famille -> icône
$familyIcons = [
    'Élémentaire' => 'elem',
    'Aquatique' => 'aquatic',
    'Humanoïde' => 'humanoid',
    'Magique' => 'magic',
    'Machine' => 'mechanical',
    'Mort-vivant' => 'undead',
    'Bête' => 'beast',
    'Aérien' => 'flying',
    'Bestiole' => 'critter',
    'Draconien' => 'dragonkin',
];
$petFamilyIcon = "assets/images/pets/" . ($familyIcons[$pet['family']] ?? 'critter') . ".png";

// Récupérer les sorts de la mascotte
$petSpells = [];
for ($i = 1; $i <= 6; $i++) {
    $spellId = $pet['spell_' . $i];
    if (!empty($spellId)) {
        $spellQuery = $db->prepare("SELECT * FROM adg_pet_spells WHERE id = :id");
        $spellQuery->execute(['id' => $spellId]);
        $petSpells[$i] = $spellQuery->fetch();
    } else {
        $petSpells[$i] = null;
    }
}
