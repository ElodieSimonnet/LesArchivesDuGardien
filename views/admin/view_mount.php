<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons" defer></script>
    <link href="../assets/css/output.css" rel="stylesheet">
    <title>Détail monture | Admin - Les Archives du Gardien</title>
</head>
<body class="bg-black text-primary-white">
    <?php require __DIR__ . '/sidebar.php'; ?>

    <main id="main-content" class="flex-1 overflow-y-auto bg-[url(../images/lava_cave_mob.webp)] bg-cover bg-center bg-fixed md:bg-[url(../images/lava_cave_without_f2_tab.webp)] lg:bg-[url(../images/lava_cave_without_f2.webp)] p-4 xl:p-8 xl:ml-64">

        <div class="mb-8">
            <a href="mount_management.php" class="text-primary-orange hover:text-amber-400 flex items-center gap-2 transition-colors uppercase text-xs font-bold tracking-widest">
                <i class="ph ph-arrow-left" aria-hidden="true"></i> Retour à la gestion
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl font-black uppercase tracking-widest border-b-2 border-primary-orange pb-4 inline-block">
                    <span class="text-primary-white">#<?= (int)$mount['id'] ?></span>
                    <span class="ml-3"><?= htmlspecialchars($mount['name']) ?></span>
                </h1>
                <a href="edit_mount.php?id=<?= (int)$mount['id'] ?>" class="px-6 py-3 border border-primary-orange text-primary-orange font-black uppercase text-xs rounded btn-orange-hover flex items-center gap-2">
                    <i class="ph ph-pencil-simple text-lg" aria-hidden="true"></i> Modifier
                </a>
            </div>

            <div class="bg-admin-dark border border-primary-orange rounded-lg p-6 lg:p-10 shadow-2xl">

                <?php if (!empty($mount['image'])): ?>
                <div class="flex justify-center mb-8">
                    <img src="../<?= htmlspecialchars($mount['image']) ?>" alt="<?= htmlspecialchars($mount['name']) ?>" class="h-48 object-contain">
                </div>
                <?php endif; ?>

                <?php if (!empty($mount['description'])): ?>
                <div class="mb-8">
                    <span class="label-orange">Description</span>
                    <p class="mt-2 bg-black/60 border border-primary-orange rounded p-4 text-primary-white leading-relaxed">
                        <?= htmlspecialchars($mount['description']) ?>
                    </p>
                </div>
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="flex flex-col gap-2">
                        <span class="label-orange">Type</span>
                        <span class="form-field"><?= htmlspecialchars($mount['type']) ?></span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="label-orange">Source</span>
                        <span class="form-field"><?= htmlspecialchars($mount['source']) ?></span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="label-orange">Extension</span>
                        <span class="form-field"><?= htmlspecialchars($mount['expansion']) ?></span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="label-orange">Faction</span>
                        <span class="form-field"><?= htmlspecialchars($mount['faction']) ?></span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="label-orange">Difficulté</span>
                        <span class="bg-black/60 border border-primary-orange rounded p-3 font-bold <?= $difficultyColor ?>"><?= htmlspecialchars($mount['difficulty']) ?></span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="label-orange">Taux de drop</span>
                        <span class="form-field">
                            <?= $mount['droprate'] !== null ? htmlspecialchars($mount['droprate']) . '%' : '---' ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="label-orange">Prix</span>
                        <span class="form-field">
                            <?php if (!empty($mount['cost']) && !empty($mount['currency_name'])): ?>
                                <?= htmlspecialchars($mount['cost']) ?> <?= htmlspecialchars($mount['currency_name']) ?>
                            <?php else: ?>
                                ---
                            <?php endif; ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="label-orange">Zone</span>
                        <span class="form-field">
                            <?= !empty($mount['zone']) ? htmlspecialchars($mount['zone']) : '---' ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="label-orange">Cible</span>
                        <span class="form-field">
                            <?= !empty($mount['target']) ? htmlspecialchars($mount['target']) : '---' ?>
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </main>

</body>
</html>
