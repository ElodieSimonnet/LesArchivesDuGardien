<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons" defer></script>
    <link href="../assets/css/output.css" rel="stylesheet">
    <title>Ajouter un article | Admin - Les Archives du Gardien</title>
</head>
<body class="bg-black text-primary-white">
    <?php require __DIR__ . '/sidebar.php'; ?>

    <main id="main-content" class="flex-1 overflow-y-auto bg-[url(../images/lava_cave_mob.webp)] bg-cover bg-center bg-fixed md:bg-[url(../images/lava_cave_without_f2_tab.webp)] lg:bg-[url(../images/lava_cave_without_f2.webp)] p-4 xl:p-8 xl:ml-64">

        <div class="mb-8">
            <a href="news_management.php" class="text-primary-orange hover:text-amber-400 flex items-center gap-2 transition-colors uppercase text-xs font-bold tracking-widest">
                <i class="ph ph-arrow-left" aria-hidden="true"></i> Retour à la gestion
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl font-black uppercase tracking-widest mb-8 border-b-2 border-primary-orange pb-4 inline-block">
                Nouvel article
            </h1>

            <?php $flash = get_flash(); if ($flash): ?>
                <div id="flash-message" role="alert" class="mb-6 p-4 bg-red-500/10 border border-red-500 text-red-500 rounded-lg flex items-center gap-3">
                    <i class="ph ph-warning-circle text-2xl" aria-hidden="true"></i>
                    <span class="text-sm font-bold uppercase"><?= htmlspecialchars($flash['message']) ?></span>
                </div>
            <?php endif; ?>

            <form action="add_news.php" method="POST" class="bg-admin-dark border border-primary-orange rounded-lg p-6 lg:p-10 shadow-2xl">
                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label for="title" class="label-orange">Titre</label>
                        <input type="text" id="title" name="title" required
                               class="form-input">
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label for="content" class="label-orange">Contenu</label>
                        <textarea id="content" name="content" rows="8" required
                                  class="form-input resize-vertical"></textarea>
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label for="image" class="label-orange">URL de l'image</label>
                        <input type="text" id="image" name="image"
                               class="form-input">
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label for="source_news" class="label-orange">URL de la source</label>
                        <input type="url" id="source_news" name="source_news"
                               class="form-input">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="id_user" class="label-orange">Auteur</label>
                        <select id="id_user" name="id_user" required
                                class="form-input">
                            <option value="">-- Sélectionner un auteur --</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= (int)$user['id'] ?>"><?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

                <div class="mt-12 flex justify-center gap-4">
                    <a href="news_management.php" class="px-6 py-3 border border-primary-orange text-primary-orange font-bold uppercase text-xs rounded btn-orange-hover">
                        Annuler
                    </a>
                    <button type="submit" class="px-10 py-3 border border-primary-orange text-primary-orange font-black uppercase text-xs rounded shadow-lg btn-orange-hover">
                        Créer l'article
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>
