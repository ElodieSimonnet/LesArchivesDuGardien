<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons" defer></script>
    <link href="../assets/css/output.css" rel="stylesheet">
    <title>Détail mascotte | Admin - Les Archives du Gardien</title>
</head>
<body class="bg-black text-primary-white">
    <?php require __DIR__ . '/sidebar.php'; ?>

    <main id="main-content" class="flex-1 overflow-y-auto bg-[url(../images/backgrounds/lava-cave-mob.webp)] bg-cover bg-center bg-fixed md:bg-[url(../images/backgrounds/lava-cave-without-f2-tab.webp)] lg:bg-[url(../images/backgrounds/lava-cave-without-f2.webp)] p-4 xl:p-8 lg:ml-64">

        <div class="mb-8">
            <a href="pet_management.php" class="text-primary-orange hover:text-amber-400 flex items-center gap-2 transition-colors uppercase text-xs lg:text-sm font-bold tracking-widest">
                <i class="ph ph-arrow-left" aria-hidden="true"></i> Retour à la gestion
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl lg:text-3xl font-black uppercase tracking-widest inline-block">
                    <span class="text-primary-white">#<?= (int)$pet['id'] ?></span>
                    <span class="ml-3"><?= htmlspecialchars($pet['name']) ?></span>
                </h1>
                <a href="edit_pet.php?id=<?= (int)$pet['id'] ?>" class="px-6 py-3 border border-primary-orange text-primary-orange font-black uppercase text-xs lg:text-sm rounded btn-orange-hover flex items-center gap-2">
                    <i class="ph ph-pencil-simple text-lg" aria-hidden="true"></i> Modifier
                </a>
            </div>

            <div class="bg-admin-dark border border-primary-orange rounded-lg p-6 lg:p-10 shadow-2xl">

                <?php if (!empty($pet['image'])): ?>
                <div class="flex justify-center mb-8">
                    <img src="../<?= htmlspecialchars($pet['image']) ?>" alt="<?= htmlspecialchars($pet['name']) ?>" class="h-48 object-contain">
                </div>
                <?php endif; ?>

                <?php if (!empty($pet['description'])): ?>
                <div class="mb-8">
                    <span class="text-sm lg:text-base font-black uppercase text-primary-orange tracking-widest">Description</span>
                    <p class="mt-2 bg-black/60 border border-primary-orange rounded p-4 text-primary-white lg:text-lg leading-relaxed">
                        <?= htmlspecialchars($pet['description']) ?>
                    </p>
                </div>
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="flex flex-col gap-2">
                        <span class="text-sm lg:text-base font-black uppercase text-primary-orange tracking-widest">Famille</span>
                        <span class="form-field lg:text-lg">
                            <?= htmlspecialchars($pet['family']) ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm lg:text-base font-black uppercase text-primary-orange tracking-widest">Source</span>
                        <span class="form-field lg:text-lg">
                            <?= htmlspecialchars($pet['source']) ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm lg:text-base font-black uppercase text-primary-orange tracking-widest">Extension</span>
                        <span class="form-field lg:text-lg">
                            <?= htmlspecialchars($pet['expansion']) ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm lg:text-base font-black uppercase text-primary-orange tracking-widest">Faction</span>
                        <span class="form-field lg:text-lg">
                            <?= htmlspecialchars($pet['faction']) ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm lg:text-base font-black uppercase text-primary-orange tracking-widest">Taux de drop</span>
                        <span class="form-field lg:text-lg">
                            <?= $pet['droprate'] !== null ? htmlspecialchars($pet['droprate']) . '%' : '---' ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm lg:text-base font-black uppercase text-primary-orange tracking-widest">Prix</span>
                        <span class="form-field lg:text-lg">
                            <?php if (!empty($pet['cost']) && !empty($pet['currency_name'])): ?>
                                <?= htmlspecialchars($pet['cost']) ?> <?= htmlspecialchars($pet['currency_name']) ?>
                            <?php else: ?>
                                ---
                            <?php endif; ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm lg:text-base font-black uppercase text-primary-orange tracking-widest">Zone</span>
                        <span class="form-field lg:text-lg">
                            <?= !empty($pet['zone']) ? htmlspecialchars($pet['zone']) : '---' ?>
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
                                <img src="../<?= htmlspecialchars($spell['icon']) ?>" alt="<?= htmlspecialchars($spell['name']) ?>" class="w-16 h-16 lg:w-20 lg:h-20 rounded border border-primary-orange object-cover">
                                <span class="text-xs lg:text-sm text-primary-white text-center"><?= htmlspecialchars($spell['name']) ?></span>
                            <?php else: ?>
                                <div class="w-16 h-16 lg:w-20 lg:h-20 rounded border border-primary-orange/40 bg-black/40 flex items-center justify-center">
                                    <span class="text-primary-orange/40 text-2xl">—</span>
                                </div>
                                <span class="text-xs lg:text-sm text-primary-orange/40 text-center">Vide</span>
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
