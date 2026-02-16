<?php
require_once 'components/utils/db_connection.php';
require_once 'components/utils/is_admin.php';
restrictToAdmin();
?>
<?php include 'retrieveAllNewsData.php';?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="assets/js/admin-messages.js" defer></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Gestion des actualités | Admin - Les Archives du Gardien</title>
</head>
<body class="bg-black">
    <?php include 'components/admin_sidebar.php'; ?>

    <main class="flex-1 min-h-screen overflow-y-auto bg-row-dark text-primary-white font-sans p-4 xl:p-8 xl:ml-64">

        <div class="flex justify-center mb-10 mt-4">
            <h2 class="px-8 lg:px-16 py-3 border-2 border-primary-orange bg-[#1a0f0a] text-primary-orange font-bold uppercase tracking-[0.2em] shadow-2xl rounded-lg text-center">
                Gestion des Actualit&eacute;s
            </h2>
        </div>

        <section class="max-w-full mx-auto w-full px-4">

            <?php if (isset($_GET['success']) && $_GET['success'] === '1'): ?>
                <div id="success-message-edit" class="mb-6 p-4 bg-green-500/10 border border-green-500 text-green-500 rounded-lg flex items-center gap-3 animate-pulse">
                    <i class="ph ph-check-circle text-2xl"></i>
                    <span class="text-sm font-bold uppercase">Article mis &agrave; jour avec succ&egrave;s !</span>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['success']) && $_GET['success'] === 'news_deleted'): ?>
                <div id="success-message-user" class="mb-6 p-4 bg-green-500/10 border border-green-500 text-green-500 rounded-lg flex items-center gap-3 animate-pulse">
                    <i class="ph ph-check-circle text-2xl"></i>
                    <span class="text-sm font-bold uppercase">Article supprim&eacute; avec succ&egrave;s !</span>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['success']) && $_GET['success'] === 'news_added'): ?>
                <div id="success-message-user-added" class="mb-6 p-4 bg-green-500/10 border border-green-500 text-green-500 rounded-lg flex items-center gap-3 animate-pulse">
                    <i class="ph ph-check-circle text-2xl"></i>
                    <span class="text-sm font-bold uppercase">Article cr&eacute;&eacute; avec succ&egrave;s !</span>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div id="error-message" class="mb-6 p-4 bg-red-500/10 border border-red-500 text-red-500 rounded-lg flex items-center gap-3">
                    <i class="ph ph-warning-circle text-2xl"></i>
                    <span class="text-sm font-bold uppercase">Une erreur est survenue.</span>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 xl:grid-cols-12 gap-4 mb-6 bg-[#1a0f0a] p-3 border-t border-b border-primary-orange">
                <div class="xl:col-span-9 relative">
                    <span class="absolute left-3 top-2.5 text-primary-orange">
                        <i class="ph ph-magnifying-glass text-xl"></i>
                    </span>
                    <input type="text" id="search-news" placeholder="Rechercher un article" class="w-full bg-black/40 border border-amber-900/70 rounded-md py-2 pl-10 pr-4 text-sm focus:outline-none focus:border-primary-orange text-amber-100">
                </div>

                <a href="add_news.php" class="xl:col-span-3 bg-amber-500 hover:bg-amber-400 text-black font-black py-2 rounded uppercase text-xs tracking-tighter flex items-center justify-center gap-2 transition-transform active:scale-95 shadow-lg shadow-amber-500/20">
                    <span class="text-lg">+</span> NOUVEL ARTICLE
                </a>
            </div>

            <div role="table" class="w-full border border-primary-orange rounded-lg bg-[#1a0f0a] overflow-hidden">

                <div role="rowgroup" class="hidden xl:block border-b border-primary-orange bg-[#1a0f0a]">
                    <div role="row" class="grid grid-cols-12 py-4 text-[11px] font-black uppercase tracking-widest text-primary-orange">
                        <div role="columnheader" class="col-span-1 text-center">ID</div>
                        <div role="columnheader" class="col-span-4 text-center">Titre</div>
                        <div role="columnheader" class="col-span-2 text-center">Auteur</div>
                        <div role="columnheader" class="col-span-3 text-center">Date</div>
                        <div role="columnheader" class="col-span-2 text-center">Actions</div>
                    </div>
                </div>

                <div role="rowgroup" class="flex flex-col divide-y divide-amber-900/20">
                    <?php foreach ($all_news as $newsRow) : ?>
                        <div role="row" data-name="<?php echo htmlspecialchars(strtolower($newsRow['title'])); ?>" class="news-row flex flex-col xl:grid xl:grid-cols-12 bg-row-dark xl:items-stretch border-b border-primary-orange gap-3 xl:gap-0 p-5 xl:p-0 hover:bg-amber-500/5 transition-all group">

                            <div role="cell" class="xl:col-span-1 xl:p-4 flex justify-between xl:justify-center items-center xl:border-r xl:border-primary-orange border-dashed">
                                <span class="xl:hidden text-[12px] font-bold text-primary-orange uppercase">ID</span>
                                <span class="font-bold text-primary-white">#<?php echo htmlspecialchars($newsRow['id']); ?></span>
                            </div>

                            <div role="cell" class="xl:col-span-4 xl:p-4 flex justify-between xl:justify-center items-center xl:border-r xl:border-primary-orange border-dashed">
                                <span class="xl:hidden text-[12px] font-bold text-primary-orange uppercase">Titre</span>
                                <span class="font-bold text-primary-white text-sm"><?php echo htmlspecialchars($newsRow['title']); ?></span>
                            </div>

                            <div role="cell" class="xl:col-span-2 xl:p-4 flex justify-between xl:justify-center items-center xl:border-r xl:border-primary-orange border-dashed">
                                <span class="xl:hidden text-[12px] font-bold text-primary-orange uppercase">Auteur</span>
                                <span class="text-sm text-primary-white font-black uppercase"><?php echo htmlspecialchars($newsRow['author']); ?></span>
                            </div>

                            <div role="cell" class="xl:col-span-3 xl:p-4 flex justify-between xl:justify-center items-center xl:border-r xl:border-primary-orange border-dashed">
                                <span class="xl:hidden text-[12px] font-bold text-primary-orange uppercase">Date</span>
                                <span class="text-sm text-primary-white text-center">
                                    <?php echo date('d/m/Y H:i', strtotime($newsRow['created_at'])); ?>
                                </span>
                            </div>

                            <div role="cell" class="xl:col-span-2 xl:p-4 flex justify-end xl:justify-center items-center gap-3">
                                <a href="view_news.php?id=<?php echo $newsRow['id']; ?>" class="p-2 border border-primary-orange rounded text-primary-orange hover:bg-primary-orange hover:text-black transition-all" title="Voir">
                                    <i class="ph ph-eye text-2xl"></i>
                                </a>
                                <a href="edit_news.php?id=<?php echo $newsRow['id']; ?>" class="p-2 border border-primary-orange rounded text-primary-orange hover:bg-primary-orange hover:text-black transition-all" title="Modifier">
                                    <i class="ph ph-pencil-simple text-2xl"></i>
                                </a>
                                <form action="delete_news.php" method="POST" onsubmit="return confirm('Supprimer cet article ?')" class="inline">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <input type="hidden" name="news_id" value="<?php echo $newsRow['id']; ?>">
                                    <button type="submit" class="p-2 border border-primary-orange rounded text-primary-orange hover:bg-red-600 transition-all hover:border-none hover:text-black cursor-pointer" title="Supprimer">
                                        <i class="ph ph-trash text-2xl"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>

    <script>
    document.getElementById('search-news').addEventListener('input', function() {
        const search = this.value.toLowerCase();
        document.querySelectorAll('.news-row').forEach(row => {
            const name = row.dataset.name || '';
            row.style.display = name.includes(search) ? '' : 'none';
        });
    });
    </script>

</body>
</html>
