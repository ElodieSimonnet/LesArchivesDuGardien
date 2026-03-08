<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons" defer></script>
    <link href="../assets/css/output.css" rel="stylesheet">
    <title>Voir l'article | Admin - Les Archives du Gardien</title>
</head>
<body class="bg-black text-primary-white">
    <?php require __DIR__ . '/sidebar.php'; ?>

    <main id="main-content" class="flex-1 overflow-y-auto bg-[url(../images/backgrounds/lava-cave-mob.webp)] bg-cover bg-center bg-fixed md:bg-[url(../images/backgrounds/lava-cave-without-f2-tab.webp)] lg:bg-[url(../images/backgrounds/lava-cave-without-f2.webp)] p-4 xl:p-8 lg:ml-64">

        <div class="mb-8">
            <a href="news_management.php" class="text-primary-orange hover:text-amber-400 flex items-center gap-2 transition-colors uppercase text-xs font-bold tracking-widest">
                <i class="ph ph-arrow-left" aria-hidden="true"></i> Retour à la gestion
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl font-black uppercase tracking-widest border-b-2 border-primary-orange pb-4 inline-block">
                    Voir l'article
                </h1>
                <a href="edit_news.php?id=<?= (int)$article['id'] ?>" class="px-6 py-3 border border-primary-orange text-primary-orange font-black uppercase text-xs rounded btn-orange-hover flex items-center gap-2">
                    <i class="ph ph-pencil-simple text-lg" aria-hidden="true"></i> Modifier
                </a>
            </div>

            <div class="bg-admin-dark border border-primary-orange rounded-lg p-6 lg:p-10 shadow-2xl">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <span class="label-orange">Titre</span>
                        <span class="form-field">
                            <?= htmlspecialchars($article['title']) ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <span class="label-orange">Contenu</span>
                        <div class="form-field leading-relaxed space-y-4">
                            <?php
                                $paragraphs = preg_split('/\n\s*\n/', $article['content']);
                                foreach ($paragraphs as $paragraph):
                                    $paragraph = trim($paragraph);
                                    if (!empty($paragraph)):
                            ?>
                                <p><?= nl2br(htmlspecialchars($paragraph)) ?></p>
                            <?php
                                    endif;
                                endforeach;
                            ?>
                        </div>
                    </div>

                    <?php if (!empty($article['image_url'])): ?>
                    <div class="flex flex-col gap-2 md:col-span-2">
                        <span class="label-orange">Image</span>
                        <div class="bg-black/60 border border-primary-orange rounded p-3 flex justify-center">
                            <img src="../<?= htmlspecialchars($article['image_url']) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="rounded max-h-64 object-cover">
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="flex flex-col gap-2">
                        <span class="label-orange">Auteur</span>
                        <span class="form-field">
                            <?= htmlspecialchars($article['author'] ?? 'Ancien membre') ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="label-orange">Date de publication</span>
                        <span class="form-field">
                            <time datetime="<?= date('Y-m-d\TH:i', strtotime($article['created_at'])) ?>"><?= date('d/m/Y à H:i', strtotime($article['created_at'])) ?></time>
                        </span>
                    </div>

                    <?php if (!empty($article['source_news'])): ?>
                    <div class="flex flex-col gap-2 md:col-span-2">
                        <span class="label-orange">Source</span>
                        <a href="<?= htmlspecialchars($article['source_news']) ?>" target="_blank" rel="noopener noreferrer" class="bg-black/60 border border-primary-orange rounded p-3 text-primary-orange hover:underline break-all">
                            <?= htmlspecialchars($article['source_news']) ?>
                        </a>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </main>

</body>
</html>
