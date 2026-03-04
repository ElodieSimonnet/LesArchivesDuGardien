<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="../assets/js/admin-messages.js" defer></script>
    <link href="../assets/css/output.css" rel="stylesheet">
    <title>Modifier la mascotte | Admin - Les Archives du Gardien</title>
</head>
<body class="bg-black text-primary-white">
    <?php require __DIR__ . '/sidebar.php'; ?>

    <main id="main-content" class="flex-1 min-h-screen overflow-y-auto bg-[url(../images/lava_cave_mob.webp)] bg-cover bg-center bg-fixed md:bg-[url(../images/lava_cave_without_f2_tab.webp)] lg:bg-[url(../images/lava_cave_without_f2.webp)] p-4 xl:p-8 xl:ml-64">

        <div class="mb-8">
            <a href="pet_gestion.php" class="text-primary-orange hover:text-amber-400 flex items-center gap-2 transition-colors uppercase text-xs font-bold tracking-widest">
                <i class="ph ph-arrow-left" aria-hidden="true"></i> Retour à la gestion
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl font-black uppercase tracking-widest mb-8 border-b-2 border-primary-orange pb-4 inline-block">
                Modifier la mascotte
            </h1>

            <?php $flash = get_flash(); if ($flash): ?>
                <div id="flash-message" role="alert" aria-live="polite" class="mb-6 p-4 bg-red-500/10 border border-red-500 text-red-500 rounded-lg flex items-center gap-3">
                    <i class="ph ph-warning-circle text-2xl" aria-hidden="true"></i>
                    <span class="text-sm font-bold uppercase"><?= htmlspecialchars($flash['message']) ?></span>
                </div>
            <?php endif; ?>

            <form action="edit_pet.php" method="POST" class="bg-[#1a0f0a] border border-primary-orange rounded-lg p-6 lg:p-10 shadow-2xl">
                <input type="hidden" id="pet_id" name="pet_id" value="<?= $pet['id'] ?>">
                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label for="name" class="text-sm font-black uppercase text-primary-orange tracking-widest">Nom</label>
                        <input type="text" id="name" name="name" value="<?= htmlspecialchars($pet['name']) ?>"
                               class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label for="description" class="text-sm font-black uppercase text-primary-orange tracking-widest">Description</label>
                        <textarea id="description" name="description" rows="3"
                                  class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all resize-vertical"><?= htmlspecialchars($pet['description']) ?></textarea>
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label for="image" class="text-sm font-black uppercase text-primary-orange tracking-widest">URL de l'image</label>
                        <input type="text" id="image" name="image" value="<?= htmlspecialchars($pet['image']) ?>"
                               class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="id_family" class="text-sm font-black uppercase text-primary-orange tracking-widest">Famille</label>
                        <select id="id_family" name="id_family" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <?php foreach ($all_families as $family) : ?>
                                <option value="<?= $family['id'] ?>" <?= ($family['id'] == $pet['id_family']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($family['family']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="id_source" class="text-sm font-black uppercase text-primary-orange tracking-widest">Source</label>
                        <select id="id_source" name="id_source" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <?php foreach ($all_sources as $source) : ?>
                                <option value="<?= $source['id'] ?>" <?= ($source['id'] == $pet['id_source']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($source['source']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="id_expansion" class="text-sm font-black uppercase text-primary-orange tracking-widest">Extension</label>
                        <select id="id_expansion" name="id_expansion" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <?php foreach ($all_expansions as $expansion) : ?>
                                <option value="<?= $expansion['id'] ?>" <?= ($expansion['id'] == $pet['id_expansion']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($expansion['expansion']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="id_faction" class="text-sm font-black uppercase text-primary-orange tracking-widest">Faction</label>
                        <select id="id_faction" name="id_faction" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <?php foreach ($all_factions as $faction) : ?>
                                <option value="<?= $faction['id'] ?>" <?= ($faction['id'] == $pet['id_faction']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($faction['faction']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="droprate" class="text-sm font-black uppercase text-primary-orange tracking-widest">Taux de drop (%)</label>
                        <input type="number" id="droprate" name="droprate" step="0.01" min="0" max="100" value="<?= htmlspecialchars($pet['droprate'] ?? '') ?>"
                               class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="id_zone" class="text-sm font-black uppercase text-primary-orange tracking-widest">Zone</label>
                        <select id="id_zone" name="id_zone" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <option value="">Aucune</option>
                            <?php foreach ($all_zones as $zone) : ?>
                                <option value="<?= $zone['id_zone'] ?>" <?= ($zone['id_zone'] == $pet['id_zone']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($zone['zone']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="id_currency" class="text-sm font-black uppercase text-primary-orange tracking-widest">Monnaie</label>
                        <select id="id_currency" name="id_currency" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <option value="">Aucune</option>
                            <?php foreach ($all_currencies as $currency) : ?>
                                <option value="<?= $currency['id'] ?>" <?= ($currency['id'] == $pet['id_currency']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($currency['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="cost" class="text-sm font-black uppercase text-primary-orange tracking-widest">Coût</label>
                        <input type="number" id="cost" name="cost" step="1" min="0" value="<?= htmlspecialchars($pet['cost'] ?? '') ?>"
                               class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="id_target" class="text-sm font-black uppercase text-primary-orange tracking-widest">Cible</label>
                        <select id="id_target" name="id_target" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <option value="">Aucune</option>
                            <?php foreach ($all_targets as $target) : ?>
                                <option value="<?= $target['id'] ?>" <?= ($target['id'] == $pet['id_target']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($target['target']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="md:col-span-2 mt-4">
                        <label class="text-sm font-black uppercase text-primary-orange tracking-widest">Sorts</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                            <?php for ($i = 1; $i <= 6; $i++): ?>
                            <div class="flex flex-col gap-1">
                                <label for="spell_<?= $i ?>" class="text-xs text-amber-400/60 uppercase tracking-wider">Sort <?= $i ?></label>
                                <select id="spell_<?= $i ?>" name="spell_<?= $i ?>" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                                    <option value="">Aucun</option>
                                    <?php foreach ($all_spells as $spell) : ?>
                                        <option value="<?= $spell['id'] ?>" <?= ($spell['id'] == ($pet['spell_' . $i] ?? null)) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($spell['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php endfor; ?>
                        </div>
                    </div>

                </div>

                <div class="mt-12 flex justify-center gap-4">
                    <a href="pet_gestion.php" class="px-6 py-3 border border-primary-orange text-primary-orange font-bold uppercase text-xs rounded hover:bg-primary-orange hover:text-primary-black transition-all">
                        Annuler
                    </a>
                    <button type="submit" class="px-10 py-3 border border-primary-orange text-primary-orange font-black uppercase text-xs rounded shadow-lg hover:bg-primary-orange hover:text-primary-black transition-all">
                        Confirmer les modifications
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>
