<?php require_once 'components/utils/db_connection.php'; ?>
<?php include 'retrieveAllNews.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="assets/js/modal.js" defer></script>
    <script src="assets/js/burger-menu.js" defer></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Nouveautés | Les Archives du Gardien</title>
    <meta name="description" content="Retrouvez les dernières actualités et nouveautés de World of Warcraft : mises à jour, événements et guides.">
</head>
<body>
    <?php include 'components/header.php'; ?>

    <main id="main-content" class="min-h-screen bg-[url(../images/lava_cave_mobile.jpg)] bg-cover bg-center
                 lg:bg-[url(../images/lava_cave.jpg)] text-primary-white font-sans p-4 md:p-10">
        <section class="max-w-6xl mx-auto mt-8 lg:mt-16">

        <div class="border-2 border-primary-orange rounded-xl p-3 mb-8 lg:mb-12 bg-black/40 backdrop-blur-sm">
            <h1 class="text-center uppercase tracking-[0.2em] font-bold text-primary-orange text-base md:text-2xl">
                Dernières Nouvelles World of Warcraft
            </h1>
        </div>

        <?php if (empty($carousel_news)): ?>
            <p class="text-center text-zinc-400 text-lg italic">Aucun article pour le moment.</p>
        <?php else: ?>

        <!-- ========== CAROUSEL - 3 dernières news ========== -->
        <h2 class="sr-only">Actualités récentes</h2>
        <div class="relative flex items-center group">

            <button id="btn-prev" class="hidden lg:flex absolute -left-8 z-10 bg-primary-brown border-2 border-primary-orange p-3 rounded-lg text-primary-orange hover:bg-primary-orange hover:text-primary-black transition-all shadow-[0_0_15px_rgba(255,165,0,0.3)]" aria-label="Précédent">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <div id="news-carousel" class="w-full" role="region" aria-live="polite">
                <?php foreach ($carousel_news as $index => $article): ?>
                <article class="news-slide bg-primary-brown border-2 border-primary-orange rounded-xl overflow-hidden shadow-2xl flex flex-col lg:flex-row w-full backdrop-blur-md lg:h-[500px] <?= $index === 0 ? '' : 'hidden' ?>">

                    <?php if (!empty($article['image_url'])): ?>
                    <figure class="w-full lg:w-1/2 p-4 lg:p-6 flex-shrink-0">
                        <div class="overflow-hidden rounded-xl border border-zinc-800 h-80 sm:h-96 lg:h-full w-full relative">
                            <img src="<?= htmlspecialchars($article['image_url'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8') ?>" class="absolute inset-0 w-full h-full object-cover hover:scale-105 transition-transform duration-500 block">
                        </div>
                    </figure>
                    <div class="hidden lg:block lg:py-6">
                        <hr class="border-primary-orange border-t-0 border-l lg:h-full">
                    </div>
                    <?php endif; ?>

                    <div class="p-6 lg:p-10 flex flex-col justify-between overflow-y-auto <?= !empty($article['image_url']) ? 'lg:w-[55%]' : 'w-full' ?>">
                        <div>
                            <header>
                                <h3 class="text-primary-orange font-black uppercase text-xl lg:text-2xl leading-tight mb-2">
                                    <?= htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8') ?>
                                </h3>
                            </header>

                            <div class="text-zinc-300 text-base lg:text-lg leading-relaxed space-y-6 mt-4">
                                <?php
                                    $paragraphs = preg_split('/\n\s*\n/', $article['content']);
                                    foreach ($paragraphs as $paragraph):
                                        $paragraph = trim($paragraph);
                                        if (!empty($paragraph)):
                                ?>
                                    <p><?= nl2br(htmlspecialchars($paragraph, ENT_QUOTES, 'UTF-8')) ?></p>
                                <?php
                                        endif;
                                    endforeach;
                                ?>
                            </div>
                        </div>

                        <footer class="mt-8 pt-6 border-t border-zinc-800/50 flex flex-col items-center gap-2">
                            <p class="text-primary-orange/90 text-sm lg:text-base italic">
                                Publié le <?= date('d/m/Y à H:i', strtotime($article['created_at'])) ?> par <span class="font-bold uppercase tracking-wide text-primary-white"><?= htmlspecialchars($article['author'] ?? 'Ancien membre', ENT_QUOTES, 'UTF-8') ?></span>
                            </p>
                            <?php if (!empty($article['source_news'])): ?>
                            <a href="<?= htmlspecialchars($article['source_news'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer" class="text-primary-orange text-xs font-bold uppercase tracking-wider hover:underline">
                                Source de l'article &rarr;
                            </a>
                            <?php endif; ?>
                        </footer>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>

            <button id="btn-next" class="hidden lg:flex absolute -right-8 z-10 bg-primary-brown border-2 border-primary-orange p-3 rounded-lg text-primary-orange hover:bg-primary-orange hover:text-primary-black transition-all shadow-[0_0_15px_rgba(255,165,0,0.3)]" aria-label="Suivant">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        <!-- Pagination carousel -->
        <div class="w-full flex justify-center mt-12 mb-8" id="news-pagination">
            <nav class="flex items-center gap-2 md:gap-3" aria-label="Pagination carousel">
                <div id="page-numbers" class="flex items-center gap-2 md:gap-3"></div>
            </nav>
        </div>

        <?php endif; ?>

        <!-- ========== ARCHIVES - Liste paginée ========== -->
        <?php if (!empty($list_news)): ?>
        <div class="mt-16">
            <div class="border-2 border-primary-orange rounded-xl p-3 mb-8 lg:mb-12 bg-black/40 backdrop-blur-sm">
                <h2 class="text-center uppercase tracking-[0.2em] font-bold text-primary-orange text-base md:text-2xl">
                    Archives
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                <?php foreach ($list_news as $article): ?>
                <a href="news_detail.php?id=<?= (int)$article['id'] ?>" class="group">
                    <article class="bg-primary-brown border-2 border-primary-orange rounded-xl overflow-hidden shadow-2xl flex flex-col h-full transition-all duration-300 hover:shadow-[0_0_25px_rgba(255,165,0,0.2)] hover:border-primary-orange/80">

                        <?php if (!empty($article['image_url'])): ?>
                        <div class="overflow-hidden h-48 w-full relative">
                            <img src="<?= htmlspecialchars($article['image_url'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8') ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                        </div>
                        <?php endif; ?>

                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="text-primary-orange font-black uppercase text-sm lg:text-base leading-tight mb-3">
                                <?= htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8') ?>
                            </h3>

                            <p class="text-zinc-300 text-sm leading-relaxed flex-grow">
                                <?php
                                    $excerpt = strip_tags($article['content']);
                                    echo htmlspecialchars(mb_strlen($excerpt) > 150 ? mb_substr($excerpt, 0, 150) . '...' : $excerpt, ENT_QUOTES, 'UTF-8');
                                ?>
                            </p>

                            <span class="text-primary-orange text-xs font-bold uppercase tracking-wider mt-3 group-hover:underline">
                                Lire la suite &rarr;
                            </span>

                            <footer class="mt-4 pt-3 border-t border-zinc-800/50 flex justify-between items-center">
                                <p class="text-primary-orange/70 text-xs italic">
                                    <?= date('d/m/Y', strtotime($article['created_at'])) ?> — <span class="font-bold uppercase text-primary-white/70"><?= htmlspecialchars($article['author'] ?? 'Ancien membre', ENT_QUOTES, 'UTF-8') ?></span>
                                </p>
                                <?php if (!empty($article['source_news'])): ?>
                                <span class="text-primary-orange/70 text-xs font-bold uppercase hover:underline">Source</span>
                                <?php endif; ?>
                            </footer>
                        </div>
                    </article>
                </a>
                <?php endforeach; ?>
            </div>

        </div>
        <?php endif; ?>

    </section>
</main>

    <?php include 'components/footer.php'; ?>
    <?php include 'components/modals.php'; ?>

    <script>
    (function() {
        const slides = document.querySelectorAll('.news-slide');
        if (slides.length === 0) return;

        let current = 0;
        const total = slides.length;
        const btnPrev = document.getElementById('btn-prev');
        const btnNext = document.getElementById('btn-next');
        const pageNumbers = document.getElementById('page-numbers');
        const pagination = document.getElementById('news-pagination');

        // Masquer la pagination s'il n'y a qu'un seul article
        if (total <= 1) {
            if (pagination) pagination.style.display = 'none';
            if (btnPrev) btnPrev.style.display = 'none';
            if (btnNext) btnNext.style.display = 'none';
        }

        function showSlide(index) {
            slides.forEach(s => s.classList.add('hidden'));
            slides[index].classList.remove('hidden');
            current = index;
            renderPageNumbers();
        }

        function prev() {
            showSlide(current > 0 ? current - 1 : total - 1);
        }

        function next() {
            showSlide(current < total - 1 ? current + 1 : 0);
        }

        function renderPageNumbers() {
            if (!pageNumbers) return;
            pageNumbers.innerHTML = '';

            for (let i = 0; i < total; i++) {
                const btn = document.createElement('button');
                btn.textContent = i + 1;
                btn.className = 'flex items-center justify-center w-10 h-10 md:w-12 md:h-12 bg-primary-brown border-2 rounded-xl text-primary-white font-black text-lg md:text-xl ' +
                    (i === current ? 'border-primary-orange' : 'border-primary-orange/40');
                btn.addEventListener('click', () => showSlide(i));
                pageNumbers.appendChild(btn);
            }
        }

        if (btnPrev) btnPrev.addEventListener('click', prev);
        if (btnNext) btnNext.addEventListener('click', next);

        renderPageNumbers();
    })();
    </script>

</body>
</html>
