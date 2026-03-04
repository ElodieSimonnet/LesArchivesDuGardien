<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="../assets/js/admin-messages.js" defer></script>
    <link href="../assets/css/output.css" rel="stylesheet">
    <title>Ajouter une monture | Admin - Les Archives du Gardien</title>
</head>
<body class="bg-black text-primary-white">
    <?php require __DIR__ . '/sidebar.php'; ?>

    <main id="main-content" class="flex-1 min-h-screen overflow-y-auto bg-[url(../images/lava_cave_mob.webp)] bg-cover bg-center bg-fixed md:bg-[url(../images/lava_cave_without_f2_tab.webp)] lg:bg-[url(../images/lava_cave_without_f2.webp)] p-4 xl:p-8 xl:ml-64">

        <div class="mb-8">
            <a href="mount_gestion.php" class="text-primary-orange hover:text-amber-400 flex items-center gap-2 transition-colors uppercase text-xs font-bold tracking-widest">
                <i class="ph ph-arrow-left" aria-hidden="true"></i> Retour à la gestion
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl font-black uppercase tracking-widest mb-8 border-b-2 border-primary-orange pb-4 inline-block">
                Nouvelle monture
            </h1>

            <?php $flash = get_flash(); if ($flash): ?>
                <div id="flash-message" role="alert" aria-live="polite" class="mb-6 p-4 bg-red-500/10 border border-red-500 text-red-500 rounded-lg flex items-center gap-3">
                    <i class="ph ph-warning-circle text-2xl" aria-hidden="true"></i>
                    <span class="text-sm font-bold uppercase"><?= htmlspecialchars($flash['message']) ?></span>
                </div>
            <?php endif; ?>

            <form action="add_mount.php" method="POST" class="bg-[#1a0f0a] border border-primary-orange rounded-lg p-6 lg:p-10 shadow-2xl">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label for="name" class="text-sm font-black uppercase text-primary-orange tracking-widest">Nom</label>
                        <input type="text" id="name" name="name" required
                               class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label for="description" class="text-sm font-black uppercase text-primary-orange tracking-widest">Description</label>
                        <textarea id="description" name="description" rows="3"
                                  class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all resize-vertical"></textarea>
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label for="image" class="text-sm font-black uppercase text-primary-orange tracking-widest">URL de l'image</label>
                        <input type="text" id="image" name="image"
                               class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="id_type" class="text-sm font-black uppercase text-primary-orange tracking-widest">Type</label>
                        <select id="id_type" name="id_type" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <?php foreach ($all_types as $type): ?>
                                <option value="<?= $type['id'] ?>"><?= htmlspecialchars($type['type']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="id_source" class="text-sm font-black uppercase text-primary-orange tracking-widest">Source</label>
                        <select id="id_source" name="id_source" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <?php foreach ($all_sources as $source): ?>
                                <option value="<?= $source['id'] ?>"><?= htmlspecialchars($source['source']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="id_expansion" class="text-sm font-black uppercase text-primary-orange tracking-widest">Extension</label>
                        <select id="id_expansion" name="id_expansion" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <?php foreach ($all_expansions as $expansion): ?>
                                <option value="<?= $expansion['id'] ?>"><?= htmlspecialchars($expansion['expansion']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="id_faction" class="text-sm font-black uppercase text-primary-orange tracking-widest">Faction</label>
                        <select id="id_faction" name="id_faction" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <?php foreach ($all_factions as $faction): ?>
                                <option value="<?= $faction['id'] ?>"><?= htmlspecialchars($faction['faction']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="id_difficulty" class="text-sm font-black uppercase text-primary-orange tracking-widest">Difficulté</label>
                        <select id="id_difficulty" name="id_difficulty" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <?php foreach ($all_difficulties as $difficulty): ?>
                                <option value="<?= $difficulty['id'] ?>"><?= htmlspecialchars($difficulty['difficulty']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="droprate" class="text-sm font-black uppercase text-primary-orange tracking-widest">Taux de drop (%)</label>
                        <input type="number" id="droprate" name="droprate" step="0.01" min="0" max="100" value="0"
                               class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="id_zone" class="text-sm font-black uppercase text-primary-orange tracking-widest">Zone</label>
                        <select id="id_zone" name="id_zone" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <option value="">Aucune</option>
                            <?php foreach ($all_zones as $zone): ?>
                                <option value="<?= $zone['id_zone'] ?>"><?= htmlspecialchars($zone['zone']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="id_currency" class="text-sm font-black uppercase text-primary-orange tracking-widest">Monnaie</label>
                        <select id="id_currency" name="id_currency" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <option value="">Aucune</option>
                            <?php foreach ($all_currencies as $currency): ?>
                                <option value="<?= $currency['id'] ?>"><?= htmlspecialchars($currency['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="cost" class="text-sm font-black uppercase text-primary-orange tracking-widest">Coût</label>
                        <input type="number" id="cost" name="cost" step="1" min="0"
                               class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="id_target" class="text-sm font-black uppercase text-primary-orange tracking-widest">Cible</label>
                        <select id="id_target" name="id_target" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white focus:border-primary-orange outline-none cursor-pointer">
                            <option value="">Aucune</option>
                            <?php foreach ($all_targets as $target): ?>
                                <option value="<?= $target['id'] ?>"><?= htmlspecialchars($target['target']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

                <div class="mt-12 flex justify-center gap-4">
                    <a href="mount_gestion.php" class="px-6 py-3 border border-primary-orange text-primary-orange font-bold uppercase text-xs rounded hover:bg-primary-orange hover:text-primary-black transition-all">
                        Annuler
                    </a>
                    <button type="submit" class="px-10 py-3 border border-primary-orange text-primary-orange font-black uppercase text-xs rounded shadow-lg hover:bg-primary-orange hover:text-primary-black transition-all">
                        Créer la monture
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>
