<?php
require_once 'components/utils/db_connection.php';
require_once 'components/utils/is_admin.php';
restrictToAdmin();

$pet_id = $_GET['id'] ?? null;

if ($pet_id === null) {
    header('Location: admin_pet_gestion.php');
    exit;
}

$query = "SELECT
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

$stmt = $db->prepare($query);
$stmt->execute([':id' => $pet_id]);
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pet) {
    header('Location: admin_pet_gestion.php');
    exit;
}

// Récupérer les sorts de la mascotte
$petSpells = [];
for ($i = 1; $i <= 6; $i++) {
    $spellId = $pet['spell_' . $i];
    if (!empty($spellId)) {
        $spellQuery = $db->prepare("SELECT * FROM adg_pet_spells WHERE id = :id");
        $spellQuery->execute(['id' => $spellId]);
        $petSpells[$i] = $spellQuery->fetch(PDO::FETCH_ASSOC);
    } else {
        $petSpells[$i] = null;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Détail mascotte | Admin - Les Archives du Gardien</title>
</head>
<body class="bg-black text-primary-white">
    <?php include 'components/admin_sidebar.php'; ?>

    <main id="main-content" class="flex-1 min-h-screen bg-row-dark p-4 xl:p-8 xl:ml-64">

        <div class="mb-8">
            <a href="admin_pet_gestion.php" class="text-primary-orange hover:text-amber-400 flex items-center gap-2 transition-colors uppercase text-xs lg:text-sm font-bold tracking-widest">
                <i class="ph ph-arrow-left"></i> Retour à la gestion
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl lg:text-3xl font-black uppercase tracking-widest border-b-2 border-primary-orange pb-4 inline-block">
                    <span class="text-primary-white">#<?php echo $pet['id']; ?></span>
                    <span class="ml-3"><?php echo htmlspecialchars($pet['name']); ?></span>
                </h1>
                <a href="edit_pet.php?id=<?php echo $pet['id']; ?>" class="px-6 py-3 border border-primary-orange text-primary-orange font-black uppercase text-xs lg:text-sm rounded hover:bg-primary-orange hover:text-primary-black transition-all flex items-center gap-2">
                    <i class="ph ph-pencil-simple text-lg"></i> Modifier
                </a>
            </div>

            <div class="bg-[#1a0f0a] border border-primary-orange rounded-lg p-6 lg:p-10 shadow-2xl">

                <?php if (!empty($pet['image'])): ?>
                <div class="flex justify-center mb-8">
                    <img src="<?php echo htmlspecialchars($pet['image']); ?>" alt="<?php echo htmlspecialchars($pet['name']); ?>" class="h-48 object-contain">
                </div>
                <?php endif; ?>

                <?php if (!empty($pet['description'])): ?>
                <div class="mb-8">
                    <span class="text-sm lg:text-base font-black uppercase text-primary-orange tracking-widest">Description</span>
                    <p class="mt-2 bg-black/60 border border-amber-900 rounded p-4 text-primary-white lg:text-lg leading-relaxed">
                        <?php echo htmlspecialchars($pet['description']); ?>
                    </p>
                </div>
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="flex flex-col gap-2">
                        <span class="text-sm lg:text-base font-black uppercase text-primary-orange tracking-widest">Famille</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white lg:text-lg">
                            <?php echo htmlspecialchars($pet['family']); ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm lg:text-base font-black uppercase text-primary-orange tracking-widest">Source</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white lg:text-lg">
                            <?php echo htmlspecialchars($pet['source']); ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm lg:text-base font-black uppercase text-primary-orange tracking-widest">Extension</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white lg:text-lg">
                            <?php echo htmlspecialchars($pet['expansion']); ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm lg:text-base font-black uppercase text-primary-orange tracking-widest">Faction</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white lg:text-lg">
                            <?php echo htmlspecialchars($pet['faction']); ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm lg:text-base font-black uppercase text-primary-orange tracking-widest">Taux de drop</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white lg:text-lg">
                            <?php echo $pet['droprate'] !== null ? htmlspecialchars($pet['droprate']) . '%' : '---'; ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm lg:text-base font-black uppercase text-primary-orange tracking-widest">Prix</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white lg:text-lg">
                            <?php if (!empty($pet['cost']) && !empty($pet['currency_name'])): ?>
                                <?php echo htmlspecialchars($pet['cost']) . ' ' . htmlspecialchars($pet['currency_name']); ?>
                            <?php else: ?>
                                ---
                            <?php endif; ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm lg:text-base font-black uppercase text-primary-orange tracking-widest">Zone</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white lg:text-lg">
                            <?php echo !empty($pet['zone']) ? htmlspecialchars($pet['zone']) : '---'; ?>
                        </span>
                    </div>

                </div>

                <div class="mt-8">
                    <span class="text-sm lg:text-base font-black uppercase text-primary-orange tracking-widest">Sorts</span>
                    <div class="grid grid-cols-3 md:grid-cols-6 justify-items-center gap-4 mt-3">
                        <?php for ($i = 1; $i <= 6; $i++):
                            $spell = $petSpells[$i] ?? null;
                        ?>
                        <div class="flex flex-col items-center gap-2">
                            <?php if ($spell): ?>
                                <img src="<?php echo htmlspecialchars($spell['icon']); ?>" alt="<?php echo htmlspecialchars($spell['name']); ?>" class="w-16 h-16 lg:w-20 lg:h-20 rounded border border-amber-900 object-cover">
                                <span class="text-xs lg:text-sm text-primary-white text-center"><?php echo htmlspecialchars($spell['name']); ?></span>
                            <?php else: ?>
                                <div class="w-16 h-16 lg:w-20 lg:h-20 rounded border border-amber-900/40 bg-black/40 flex items-center justify-center">
                                    <span class="text-amber-900/40 text-2xl">—</span>
                                </div>
                                <span class="text-xs lg:text-sm text-amber-900/40 text-center">Vide</span>
                            <?php endif; ?>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>

            </div>
        </div>
    </main>

</body>
</html>
