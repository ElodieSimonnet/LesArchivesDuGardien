
<?php
require_once 'components/utils/db_connection.php';
require_once 'components/utils/is_admin.php';
restrictToAdmin();
?>
<?php include 'retrieveAllPetsData.php';?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="assets/js/admin-messages.js" defer></script>
    <script src="assets/js/admin-sidebar.js" defer></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Gestion des mascottes | Admin - Les Archives du Gardien</title>
</head>
<body class="bg-black">
    <?php include 'components/admin_sidebar.php'; ?>

    <main class="flex-1 min-h-screen overflow-y-auto bg-[url(../images/lava_cave_mob.webp)] bg-cover bg-center bg-fixed md:bg-[url(../images/lava_cave_without_f2_tab.webp)] lg:bg-[url(../images/lava_cave_without_f2.webp)] text-primary-white font-sans p-4 xl:p-8 lg:ml-64">

        <section class="max-w-full mx-auto w-full px-4">

        <div class="flex justify-center mb-10 mt-4">
            <h1 class="px-8 lg:px-16 py-3 border-2 border-primary-orange bg-[#1a0f0a] text-primary-orange font-bold uppercase tracking-[0.2em] shadow-2xl rounded-lg text-center">
                Gestion des Mascottes
            </h1>
        </div>

            <?php $flash = get_flash(); if ($flash): ?>
                <div id="flash-message" role="alert" aria-live="polite" class="mb-6 p-4 <?= $flash['type'] === 'success' ? 'bg-green-500/10 border-green-500 text-green-500 animate-pulse' : 'bg-red-500/10 border-red-500 text-red-500' ?> border rounded-lg flex items-center gap-3">
                    <i class="ph <?= $flash['type'] === 'success' ? 'ph-check-circle' : 'ph-warning-circle' ?> text-2xl"></i>
                    <span class="text-sm font-bold uppercase"><?= htmlspecialchars($flash['message']) ?></span>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 xl:grid-cols-12 gap-4 mb-6 bg-[#1a0f0a] p-3 border-t border-b border-primary-orange">
                <div class="xl:col-span-6 relative">
                    <span class="absolute left-3 top-2.5 text-primary-orange">
                        <i class="ph ph-magnifying-glass text-xl"></i>
                    </span>
                    <input type="text" id="search-pet" placeholder="Rechercher une mascotte" aria-label="Rechercher une mascotte" class="w-full bg-black/40 border border-amber-900/70 rounded-md py-2 pl-10 pr-4 text-sm focus:outline-none focus:border-primary-orange text-amber-100">
                </div>

                <button type="button" id="open-filters-btn" class="xl:col-span-3 relative cursor-pointer group w-full text-left" aria-haspopup="dialog" aria-label="Ouvrir les filtres">
                    <span class="absolute left-3 top-2.5 text-primary-orange group-hover:scale-110 transition-transform pointer-events-none">
                        <i class="ph ph-sliders text-xl" aria-hidden="true"></i>
                    </span>
                    <span class="block w-full bg-black/40 border border-amber-900/70 rounded-md py-2 pl-10 pr-4 text-sm text-amber-100 outline-none cursor-pointer focus:border-primary-orange transition-all">Filtrer</span>
                </button>

                <a href="add_pet.php" class="xl:col-span-3 bg-amber-500 hover:bg-amber-400 text-black font-black py-2 rounded uppercase text-xs tracking-tighter flex items-center justify-center gap-2 transition-transform active:scale-95 shadow-lg shadow-amber-500/20">
                    <span class="text-lg">+</span> NOUVELLE MASCOTTE
                </a>
            </div>

            <div role="table" class="w-full border border-primary-orange rounded-lg bg-[#1a0f0a] overflow-hidden">

                <div role="rowgroup" class="hidden xl:block border-b border-primary-orange bg-[#1a0f0a]">
                    <div role="row" class="grid grid-cols-12 py-4 text-[11px] font-black uppercase tracking-widest text-primary-orange">
                        <div role="columnheader" class="col-span-1 text-center">ID</div>
                        <div role="columnheader" class="col-span-3 text-center">Nom</div>
                        <div role="columnheader" class="col-span-2 text-center">Famille</div>
                        <div role="columnheader" class="col-span-2 text-center">Source</div>
                        <div role="columnheader" class="col-span-2 text-center">Extension</div>
                        <div role="columnheader" class="col-span-2 text-center">Actions</div>
                    </div>
                </div>

                <div role="rowgroup" class="flex flex-col divide-y divide-amber-900/20">
                    <?php foreach ($all_pets as $petRow) : ?>
                        <div role="row" data-name="<?php echo htmlspecialchars(strtolower($petRow['name'])); ?>" class="pet-row flex flex-col xl:grid xl:grid-cols-12 bg-row-dark xl:items-stretch border-b border-primary-orange gap-3 xl:gap-0 p-5 xl:p-0 hover:bg-amber-500/5 transition-all group">

                            <div role="cell" class="xl:col-span-1 xl:p-4 flex justify-between xl:justify-center items-center xl:border-r xl:border-primary-orange border-dashed">
                                <span class="xl:hidden text-[12px] font-bold text-primary-orange uppercase">ID</span>
                                <span class="font-bold text-primary-white">#<?php echo htmlspecialchars($petRow['id']); ?></span>
                            </div>

                            <div role="cell" class="xl:col-span-3 xl:p-4 flex justify-between xl:justify-center items-center xl:border-r xl:border-primary-orange border-dashed">
                                <span class="xl:hidden text-[12px] font-bold text-primary-orange uppercase">Nom</span>
                                <span class="font-bold text-primary-white text-sm"><?php echo htmlspecialchars($petRow['name']); ?></span>
                            </div>

                            <div role="cell" class="xl:col-span-2 xl:p-4 flex justify-between xl:justify-center items-center xl:border-r xl:border-primary-orange border-dashed">
                                <span class="xl:hidden text-[12px] font-bold text-primary-orange uppercase">Famille</span>
                                <span class="text-sm text-primary-white font-black uppercase">
                                    <?php echo htmlspecialchars($petRow['family']); ?>
                                </span>
                            </div>

                            <div role="cell" class="xl:col-span-2 xl:p-4 flex justify-between xl:justify-center items-center xl:border-r xl:border-primary-orange border-dashed">
                                <span class="xl:hidden text-[12px] font-bold text-primary-orange uppercase">Source</span>
                                <span class="text-sm text-primary-white text-center">
                                    <?php echo htmlspecialchars($petRow['source']); ?>
                                </span>
                            </div>

                            <div role="cell" class="xl:col-span-2 xl:p-4 flex justify-between xl:justify-center items-center xl:border-r xl:border-primary-orange border-dashed">
                                <span class="xl:hidden text-[12px] font-bold text-primary-orange uppercase">Extension</span>
                                <span class="text-sm text-primary-white text-center">
                                    <?php echo htmlspecialchars($petRow['expansion']); ?>
                                </span>
                            </div>

                            <div role="cell" class="xl:col-span-2 xl:p-4 flex justify-end xl:justify-center items-center gap-3">
                                <a href="view_pet.php?id=<?php echo $petRow['id']; ?>" class="p-2 border border-primary-orange rounded text-primary-orange hover:bg-primary-orange hover:text-black transition-all" title="Voir" aria-label="Voir">
                                    <i class="ph ph-eye text-2xl" aria-hidden="true"></i>
                                </a>
                                <a href="edit_pet.php?id=<?php echo $petRow['id']; ?>" class="p-2 border border-primary-orange rounded text-primary-orange hover:bg-primary-orange hover:text-black transition-all" title="Modifier" aria-label="Modifier">
                                    <i class="ph ph-pencil-simple text-2xl" aria-hidden="true"></i>
                                </a>
                                <form action="delete_pet.php" method="POST" onsubmit="return confirm('Supprimer cette mascotte ?')" class="inline">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <input type="hidden" name="pet_id" value="<?php echo $petRow['id']; ?>">
                                    <button type="submit" class="p-2 border border-primary-orange rounded text-primary-orange hover:bg-red-600 transition-all hover:border-none hover:text-black cursor-pointer" title="Supprimer" aria-label="Supprimer">
                                        <i class="ph ph-trash text-2xl" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>

    <?php include 'components/admin-pet-filters.php'; ?>
    <script src="assets/js/admin-pet-filters.js"></script>

</body>
</html>
