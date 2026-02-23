<?php
require_once 'components/utils/db_connection.php';
require_once 'components/utils/is_admin.php';
restrictToAdmin();

$mount_id = $_GET['id'] ?? null;

if ($mount_id === null) {
    header('Location: admin_mount_gestion.php');
    exit;
}

$query = "SELECT
            adg_mounts.*,
            adg_expansions.expansion,
            adg_factions.faction,
            adg_sources.source,
            adg_difficulties.difficulty,
            adg_mount_types.type,
            adg_zones.zone,
            adg_targets.target,
            adg_currencies.name AS currency_name
        FROM adg_mounts
        INNER JOIN adg_expansions   ON adg_mounts.id_expansion  = adg_expansions.id
        INNER JOIN adg_factions     ON adg_mounts.id_faction    = adg_factions.id
        INNER JOIN adg_sources      ON adg_mounts.id_source     = adg_sources.id
        INNER JOIN adg_difficulties ON adg_mounts.id_difficulty = adg_difficulties.id
        INNER JOIN adg_mount_types  ON adg_mounts.id_type       = adg_mount_types.id
        LEFT JOIN adg_zones         ON adg_mounts.id_zone       = adg_zones.id_zone
        LEFT JOIN adg_targets       ON adg_mounts.id_target     = adg_targets.id
        LEFT JOIN adg_currencies    ON adg_mounts.id_currency  = adg_currencies.id
        WHERE adg_mounts.id = :id";

$stmt = $db->prepare($query);
$stmt->execute([':id' => $mount_id]);
$mount = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$mount) {
    header('Location: admin_mount_gestion.php');
    exit;
}

$difficultyColor = match(strtolower($mount['difficulty'])) {
    'facile' => 'text-green-500',
    'moyen' => 'text-orange-500',
    'difficile' => 'text-red-500',
    'argent réel' => 'text-cyan-400',
    default => 'text-a11y-gray',
};
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Détail monture | Admin - Les Archives du Gardien</title>
</head>
<body class="bg-black text-primary-white">
    <?php include 'components/admin_sidebar.php'; ?>

    <main id="main-content" class="flex-1 min-h-screen bg-row-dark p-4 xl:p-8 xl:ml-64">

        <div class="mb-8">
            <a href="admin_mount_gestion.php" class="text-primary-orange hover:text-amber-400 flex items-center gap-2 transition-colors uppercase text-xs font-bold tracking-widest">
                <i class="ph ph-arrow-left"></i> Retour à la gestion
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl font-black uppercase tracking-widest border-b-2 border-primary-orange pb-4 inline-block">
                    <span class="text-primary-white">#<?php echo $mount['id']; ?></span>
                    <span class="ml-3"><?php echo htmlspecialchars($mount['name']); ?></span>
                </h1>
                <a href="edit_mount.php?id=<?php echo $mount['id']; ?>" class="px-6 py-3 border border-primary-orange text-primary-orange font-black uppercase text-xs rounded hover:bg-primary-orange hover:text-primary-black transition-all flex items-center gap-2">
                    <i class="ph ph-pencil-simple text-lg"></i> Modifier
                </a>
            </div>

            <div class="bg-[#1a0f0a] border border-primary-orange rounded-lg p-6 lg:p-10 shadow-2xl">

                <?php if (!empty($mount['image'])): ?>
                <div class="flex justify-center mb-8">
                    <img src="<?php echo htmlspecialchars($mount['image']); ?>" alt="<?php echo htmlspecialchars($mount['name']); ?>" class="h-48 object-contain">
                </div>
                <?php endif; ?>

                <?php if (!empty($mount['description'])): ?>
                <div class="mb-8">
                    <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Description</span>
                    <p class="mt-2 bg-black/60 border border-amber-900 rounded p-4 text-primary-white leading-relaxed">
                        <?php echo htmlspecialchars($mount['description']); ?>
                    </p>
                </div>
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Type</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white">
                            <?php echo htmlspecialchars($mount['type']); ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Source</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white">
                            <?php echo htmlspecialchars($mount['source']); ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Extension</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white">
                            <?php echo htmlspecialchars($mount['expansion']); ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Faction</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white">
                            <?php echo htmlspecialchars($mount['faction']); ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Difficulté</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 font-bold <?php echo $difficultyColor; ?>">
                            <?php echo htmlspecialchars($mount['difficulty']); ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Taux de drop</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white">
                            <?php echo $mount['droprate'] !== null ? htmlspecialchars($mount['droprate']) . '%' : '---'; ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Prix</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white">
                            <?php if (!empty($mount['cost']) && !empty($mount['currency_name'])): ?>
                                <?php echo htmlspecialchars($mount['cost']) . ' ' . htmlspecialchars($mount['currency_name']); ?>
                            <?php else: ?>
                                ---
                            <?php endif; ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Zone</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white">
                            <?php echo !empty($mount['zone']) ? htmlspecialchars($mount['zone']) : '---'; ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Cible</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white">
                            <?php echo !empty($mount['target']) ? htmlspecialchars($mount['target']) : '---'; ?>
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </main>

</body>
</html>
