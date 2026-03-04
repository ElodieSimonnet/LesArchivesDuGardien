<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <link href="../assets/css/output.css" rel="stylesheet">
    <title>Voir la question | Admin - Les Archives du Gardien</title>
</head>
<body class="bg-black text-primary-white">
    <?php require __DIR__ . '/sidebar.php'; ?>

    <main id="main-content" class="flex-1 min-h-screen overflow-y-auto bg-[url(../images/lava_cave_mob.webp)] bg-cover bg-center bg-fixed md:bg-[url(../images/lava_cave_without_f2_tab.webp)] lg:bg-[url(../images/lava_cave_without_f2.webp)] p-4 xl:p-8 xl:ml-64">

        <div class="mb-8">
            <a href="faq_gestion.php" class="text-primary-orange hover:text-amber-400 flex items-center gap-2 transition-colors uppercase text-xs font-bold tracking-widest">
                <i class="ph ph-arrow-left" aria-hidden="true"></i> Retour à la gestion
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl font-black uppercase tracking-widest border-b-2 border-primary-orange pb-4 inline-block">
                    Voir la question
                </h1>
                <a href="edit_faq.php?id=<?= (int)$faq['id'] ?>" class="px-6 py-3 border border-primary-orange text-primary-orange font-black uppercase text-xs rounded hover:bg-primary-orange hover:text-primary-black transition-all flex items-center gap-2">
                    <i class="ph ph-pencil-simple text-lg" aria-hidden="true"></i> Modifier
                </a>
            </div>

            <div class="bg-[#1a0f0a] border border-primary-orange rounded-lg p-6 lg:p-10 shadow-2xl">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Question</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white">
                            <?= htmlspecialchars($faq['question']) ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Réponse</span>
                        <div class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white leading-relaxed">
                            <?= nl2br(htmlspecialchars($faq['answer'])) ?>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Catégorie</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white">
                            <?= htmlspecialchars($faq['category_name'] ?? 'Aucune') ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Ordre d'affichage</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white">
                            <?= (int)$faq['display_order'] ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Date de création</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white">
                            <?= date('d/m/Y à H:i', strtotime($faq['created_at'])) ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Dernière modification</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white">
                            <?= date('d/m/Y à H:i', strtotime($faq['updated_at'])) ?>
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </main>

</body>
</html>
