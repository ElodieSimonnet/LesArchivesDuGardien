<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons" defer></script>
    <link href="../assets/css/output.css" rel="stylesheet">
    <title>Gestion de la F.A.Q | Admin - Les Archives du Gardien</title>
</head>
<body class="bg-black">
    <?php require __DIR__ . '/sidebar.php'; ?>

    <main id="main-content" class="flex-1 overflow-y-auto bg-[url(../images/lava_cave_mob.webp)] bg-cover bg-center bg-fixed md:bg-[url(../images/lava_cave_without_f2_tab.webp)] lg:bg-[url(../images/lava_cave_without_f2.webp)] text-primary-white font-sans p-4 xl:p-8 lg:ml-64">

        <div class="max-w-full mx-auto w-full px-4">

        <div class="flex justify-center mb-10 mt-4">
            <h1 class="px-8 lg:px-16 py-3 border-2 border-primary-orange bg-admin-dark text-primary-orange font-bold uppercase tracking-[0.2em] shadow-2xl rounded-lg text-center">
                Gestion de la F.A.Q
            </h1>
        </div>

            <?php $flash = get_flash(); if ($flash): ?>
                <div id="flash-message" role="alert" class="mb-6 p-4 <?= $flash['type'] === 'success' ? 'bg-green-500/10 border-green-500 text-green-500 animate-pulse' : 'bg-red-500/10 border-red-500 text-red-500' ?> border rounded-lg flex items-center gap-3">
                    <i class="ph <?= $flash['type'] === 'success' ? 'ph-check-circle' : 'ph-warning-circle' ?> text-2xl" aria-hidden="true"></i>
                    <span class="text-sm font-bold uppercase"><?= htmlspecialchars($flash['message']) ?></span>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 xl:grid-cols-12 gap-4 mb-6 bg-admin-dark p-3 border-t border-b border-primary-orange">
                <div class="xl:col-span-9 relative">
                    <span class="absolute left-3 top-2.5 text-primary-orange">
                        <i class="ph ph-magnifying-glass text-xl" aria-hidden="true"></i>
                    </span>
                    <input type="text" id="search-faq" placeholder="Rechercher une question" aria-label="Rechercher une question" class="w-full bg-black/40 border border-primary-orange/70 rounded-md py-2 pl-10 pr-4 text-sm focus:outline-none focus:border-primary-orange text-amber-100">
                </div>

                <a href="add_faq.php" class="xl:col-span-3 bg-amber-500 hover:bg-amber-400 text-black font-black py-2 rounded uppercase text-xs tracking-tighter flex items-center justify-center gap-2 transition-transform active:scale-95 shadow-lg shadow-amber-500/20">
                    <span class="text-lg">+</span> NOUVELLE QUESTION
                </a>
            </div>

            <div role="table" aria-label="Liste des questions F.A.Q" class="w-full border border-primary-orange rounded-lg bg-admin-dark overflow-hidden">

                <div role="rowgroup" class="hidden xl:block border-b border-primary-orange bg-admin-dark">
                    <div role="row" class="grid grid-cols-12 py-4 text-[11px] font-black uppercase tracking-widest text-primary-orange">
                        <div role="columnheader" class="col-span-1 text-center">ID</div>
                        <div role="columnheader" class="col-span-4 text-center">Question</div>
                        <div role="columnheader" class="col-span-2 text-center">Catégorie</div>
                        <div role="columnheader" class="col-span-1 text-center">Ordre</div>
                        <div role="columnheader" class="col-span-2 text-center">Date</div>
                        <div role="columnheader" class="col-span-2 text-center">Actions</div>
                    </div>
                </div>

                <div role="rowgroup" class="flex flex-col divide-y divide-amber-900/20">
                    <?php foreach ($all_faq as $i => $faqRow) : ?>
                        <div role="row" data-name="<?= htmlspecialchars(strtolower($faqRow['question'])) ?>" class="faq-row flex flex-col xl:grid xl:grid-cols-12 <?= $i % 2 === 0 ? 'bg-row-dark' : 'bg-row-light' ?> xl:items-stretch border-b border-primary-orange gap-3 xl:gap-0 p-5 xl:p-0 hover:bg-amber-500/5 transition-all group">

                            <div role="cell" class="xl:col-span-1 xl:p-4 flex justify-between xl:justify-center items-center xl:border-r xl:border-primary-orange border-dashed">
                                <span class="xl:hidden text-[12px] font-bold text-primary-orange uppercase">ID</span>
                                <span class="font-bold text-primary-white">#<?= htmlspecialchars($faqRow['id']) ?></span>
                            </div>

                            <div role="cell" class="xl:col-span-4 xl:p-4 flex justify-between xl:justify-center items-center xl:border-r xl:border-primary-orange border-dashed">
                                <span class="xl:hidden text-[12px] font-bold text-primary-orange uppercase">Question</span>
                                <span class="font-bold text-primary-white text-sm truncate max-w-[60%]"><?= htmlspecialchars($faqRow['question']) ?></span>
                            </div>

                            <div role="cell" class="xl:col-span-2 xl:p-4 flex justify-between xl:justify-center items-center xl:border-r xl:border-primary-orange border-dashed">
                                <span class="xl:hidden text-[12px] font-bold text-primary-orange uppercase">Catégorie</span>
                                <span class="text-sm text-primary-white font-black uppercase"><?= htmlspecialchars($faqRow['category_name'] ?? 'Aucune') ?></span>
                            </div>

                            <div role="cell" class="xl:col-span-1 xl:p-4 flex justify-between xl:justify-center items-center xl:border-r xl:border-primary-orange border-dashed">
                                <span class="xl:hidden text-[12px] font-bold text-primary-orange uppercase">Ordre</span>
                                <span class="text-sm text-primary-white text-center"><?= (int)$faqRow['display_order'] ?></span>
                            </div>

                            <div role="cell" class="xl:col-span-2 xl:p-4 flex justify-between xl:justify-center items-center xl:border-r xl:border-primary-orange border-dashed">
                                <span class="xl:hidden text-[12px] font-bold text-primary-orange uppercase">Date</span>
                                <span class="text-sm text-primary-white text-center">
                                    <time datetime="<?= date('Y-m-d', strtotime($faqRow['created_at'])) ?>"><?= date('d/m/Y H:i', strtotime($faqRow['created_at'])) ?></time>
                                </span>
                            </div>

                            <div role="cell" class="xl:col-span-2 xl:p-4 flex justify-end xl:justify-center items-center gap-3">
                                <a href="view_faq.php?id=<?= $faqRow['id'] ?>" class="p-2 border border-primary-orange rounded text-primary-orange hover:bg-primary-orange hover:text-black transition-all" title="Voir" aria-label="Voir la question #<?= $faqRow['id'] ?>">
                                    <i class="ph ph-eye text-2xl" aria-hidden="true"></i>
                                </a>
                                <a href="edit_faq.php?id=<?= $faqRow['id'] ?>" class="p-2 border border-primary-orange rounded text-primary-orange hover:bg-primary-orange hover:text-black transition-all" title="Modifier" aria-label="Modifier la question #<?= $faqRow['id'] ?>">
                                    <i class="ph ph-pencil-simple text-2xl" aria-hidden="true"></i>
                                </a>
                                <form action="delete_faq.php" method="POST" class="delete-form inline">
                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                    <input type="hidden" name="faq_id" value="<?= $faqRow['id'] ?>">
                                    <button type="submit" class="p-2 border border-primary-orange rounded text-primary-orange hover:bg-red-600 transition-all hover:border-none hover:text-black cursor-pointer" title="Supprimer" aria-label="Supprimer la question #<?= $faqRow['id'] ?>">
                                        <i class="ph ph-trash text-2xl" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </main>

    <script src="../assets/js/admin-faq-management.js" defer></script>

</body>
</html>
