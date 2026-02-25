<?php
require_once 'components/utils/db_connection.php';
require_once 'components/utils/is_admin.php';
restrictToAdmin();

$news_id = $_GET['id'] ?? null;

if (!$news_id) {
    header('Location: admin_news_gestion.php');
    exit;
}

$query = "SELECT adg_news.*, adg_users.username AS author FROM adg_news LEFT JOIN adg_users ON adg_news.id_user = adg_users.id WHERE adg_news.id = :id";
$stmt = $db->prepare($query);
$stmt->execute([':id' => (int)$news_id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    header('Location: admin_news_gestion.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Voir l'article | Admin - Les Archives du Gardien</title>
</head>
<body class="bg-black text-primary-white">
    <?php include 'components/admin_sidebar.php'; ?>

    <main id="main-content" class="flex-1 min-h-screen overflow-y-auto bg-[url(../images/lava_cave_mob.webp)] bg-cover bg-center bg-fixed md:bg-[url(../images/lava_cave_without_f2_tab.webp)] lg:bg-[url(../images/lava_cave_without_f2.webp)] p-4 xl:p-8 xl:ml-64">

        <div class="mb-8">
            <a href="admin_news_gestion.php" class="text-primary-orange hover:text-amber-400 flex items-center gap-2 transition-colors uppercase text-xs font-bold tracking-widest">
                <i class="ph ph-arrow-left"></i> Retour à la gestion
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl font-black uppercase tracking-widest border-b-2 border-primary-orange pb-4 inline-block">
                    Voir l'article
                </h1>
                <a href="edit_news.php?id=<?php echo $article['id']; ?>" class="px-6 py-3 border border-primary-orange text-primary-orange font-black uppercase text-xs rounded hover:bg-primary-orange hover:text-primary-black transition-all flex items-center gap-2">
                    <i class="ph ph-pencil-simple text-lg"></i> Modifier
                </a>
            </div>

            <div class="bg-[#1a0f0a] border border-primary-orange rounded-lg p-6 lg:p-10 shadow-2xl">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Titre</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white">
                            <?php echo htmlspecialchars($article['title']); ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Contenu</span>
                        <div class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white leading-relaxed space-y-4">
                            <?php
                                $paragraphs = preg_split('/\n\s*\n/', $article['content']);
                                foreach ($paragraphs as $paragraph):
                                    $paragraph = trim($paragraph);
                                    if (!empty($paragraph)):
                            ?>
                                <p><?php echo nl2br(htmlspecialchars($paragraph)); ?></p>
                            <?php
                                    endif;
                                endforeach;
                            ?>
                        </div>
                    </div>

                    <?php if (!empty($article['image_url'])): ?>
                    <div class="flex flex-col gap-2 md:col-span-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Image</span>
                        <div class="bg-black/60 border border-amber-900 rounded p-3 flex justify-center">
                            <img src="<?php echo htmlspecialchars($article['image_url']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" class="rounded max-h-64 object-cover">
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Auteur</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white">
                            <?php echo htmlspecialchars($article['author'] ?? 'Ancien membre'); ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Date de publication</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white">
                            <?php echo date('d/m/Y à H:i', strtotime($article['created_at'])); ?>
                        </span>
                    </div>

                    <?php if (!empty($article['source_news'])): ?>
                    <div class="flex flex-col gap-2 md:col-span-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Source</span>
                        <a href="<?php echo htmlspecialchars($article['source_news']); ?>" target="_blank" class="bg-black/60 border border-amber-900 rounded p-3 text-primary-orange hover:underline break-all">
                            <?php echo htmlspecialchars($article['source_news']); ?>
                        </a>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </main>

</body>
</html>
