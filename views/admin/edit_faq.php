<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons" defer></script>
    <link href="../assets/css/output.css" rel="stylesheet">
    <title>Modifier une question | Admin - Les Archives du Gardien</title>
</head>
<body class="bg-black text-primary-white">
    <?php require __DIR__ . '/sidebar.php'; ?>

    <main id="main-content" class="flex-1 overflow-y-auto bg-[url(../images/backgrounds/lava-cave-mob.webp)] bg-cover bg-center bg-fixed md:bg-[url(../images/backgrounds/lava-cave-without-f2-tab.webp)] lg:bg-[url(../images/backgrounds/lava-cave-without-f2.webp)] p-4 xl:p-8 lg:ml-64">

        <div class="mb-8">
            <a href="faq_management.php" class="text-primary-orange hover:text-amber-400 flex items-center gap-2 transition-colors uppercase text-xs font-bold tracking-widest">
                <i class="ph ph-arrow-left" aria-hidden="true"></i> Retour à la gestion
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl font-black uppercase tracking-widest mb-8 border-b-2 border-primary-orange pb-4 inline-block">
                Modifier la question
            </h1>

            <?php $flash = get_flash(); if ($flash): ?>
                <div id="flash-message" role="alert" class="mb-6 p-4 bg-red-500/10 border border-red-500 text-red-500 rounded-lg flex items-center gap-3">
                    <i class="ph ph-warning-circle text-2xl" aria-hidden="true"></i>
                    <span class="text-sm font-bold uppercase"><?= htmlspecialchars($flash['message']) ?></span>
                </div>
            <?php endif; ?>

            <form action="edit_faq.php" method="POST" class="bg-admin-dark border border-primary-orange rounded-lg p-6 lg:p-10 shadow-2xl">
                <input type="hidden" id="faq_id" name="faq_id" value="<?= $faq['id'] ?>">
                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label for="question" class="label-orange">Question</label>
                        <input type="text" id="question" name="question" required
                               value="<?= htmlspecialchars($faq['question']) ?>"
                               class="form-input">
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label for="answer" class="label-orange">Réponse</label>
                        <textarea id="answer" name="answer" rows="6" required
                                  class="form-input resize-vertical"><?= htmlspecialchars($faq['answer']) ?></textarea>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="id_category" class="label-orange">Catégorie</label>
                        <select id="id_category" name="id_category" required
                                class="form-input">
                            <option value="">-- Sélectionner une catégorie --</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= (int)$cat['id'] ?>" <?= $faq['id_category'] == $cat['id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="display_order" class="label-orange">Ordre d'affichage</label>
                        <input type="number" id="display_order" name="display_order" value="<?= (int)$faq['display_order'] ?>" min="0"
                               class="form-input">
                    </div>

                </div>

                <div class="mt-12 flex justify-center gap-4">
                    <a href="faq_management.php" class="px-6 py-3 border border-primary-orange text-primary-orange font-bold uppercase text-xs rounded btn-orange-hover">
                        Annuler
                    </a>
                    <button type="submit" class="px-10 py-3 border border-primary-orange text-primary-orange font-black uppercase text-xs rounded shadow-lg btn-orange-hover">
                        Modifier la question
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>
