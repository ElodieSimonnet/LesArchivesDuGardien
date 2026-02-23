<?php require_once 'components/utils/db_connection.php'; ?>
<?php include 'retrieveAllFaq.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="assets/js/modal.js" defer></script>
    <script src="assets/js/burger-menu.js" defer></script>
    <script src="assets/js/faq-accordion.js" defer></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>F.A.Q | Les Archives du Gardien</title>
    <meta name="description" content="Foire aux questions sur Les Archives du Gardien : fonctionnement du site, collections, filtres et synchronisation.">
</head>
<body>
    <?php include 'components/header.php'; ?>
    <main id="main-content" class="min-h-screen bg-[url(../images/lava_cave_mobile.jpg)] bg-cover bg-center bg-fixed
                 lg:bg-[url(../images/lava_cave.jpg)] text-primary-white font-sans p-4 md:p-10">
        <section class="max-w-4xl mx-auto">
            <header class="border-2 border-primary-orange bg-primary-brown rounded-lg p-4 mb-8 text-center shadow-lg">
                <h1 class="text-2xl md:text-4xl font-bold uppercase tracking-widest text-primary-orange">
                    Foire aux Questions
                </h1>
            </header>

            <?php if (empty($faq_by_category)): ?>
                <p class="text-center text-zinc-400 text-lg italic">Aucune question pour le moment.</p>
            <?php else: ?>
                <?php foreach ($faq_by_category as $category => $faqs): ?>

                <div class="mb-10 border-2 border-primary-orange rounded-xl bg-black/40 backdrop-blur-sm p-4 md:p-6 shadow-2xl">
                    <h2 class="text-center uppercase tracking-[0.2em] font-bold text-primary-orange text-base md:text-xl mb-6">
                        <?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?>
                    </h2>

                    <dl class="space-y-4">
                        <?php foreach ($faqs as $faq): ?>
                        <div class="group border-2 border-primary-orange rounded-lg overflow-hidden shadow-xl transition-all duration-300">
                            <dt>
                                <button type="button" aria-expanded="false" aria-controls="faq-content-<?= (int)$faq['id'] ?>" class="faq-trigger w-full flex justify-between items-center p-4 text-left bg-primary-brown hover:brightness-110 focus:outline-none focus-visible:ring-4 focus-visible:ring-inset focus-visible:ring-primary-orange transition-all duration-300">
                                    <span class="text-base md:text-lg font-semibold text-primary-orange pr-4 transition-colors duration-300 group-[.is-active]:text-primary-black">
                                        Q. <?= htmlspecialchars($faq['question'], ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                    <svg class="arrow-icon w-6 h-6 text-primary-orange group-[.is-active]:text-primary-black transition-transform duration-300 flex-shrink-0" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </dt>
                            <dd id="faq-content-<?= (int)$faq['id'] ?>" class="faq-content max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-primary-brown">
                                <div class="p-4 text-primary-white leading-relaxed text-sm md:text-base">
                                    R. <?= htmlspecialchars($faq['answer'], ENT_QUOTES, 'UTF-8') ?>
                                </div>
                            </dd>
                        </div>
                        <?php endforeach; ?>
                    </dl>
                </div>

                <?php endforeach; ?>
            <?php endif; ?>

        </section>
    </main>
    <?php include 'components/footer.php'; ?>
    <?php include 'components/modals.php'; ?>
</body>
</html>
