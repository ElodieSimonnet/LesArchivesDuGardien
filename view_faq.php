<?php
require_once 'components/utils/db_connection.php';
require_once 'components/utils/is_admin.php';
restrictToAdmin();

$faq_id = $_GET['id'] ?? null;

if (!$faq_id) {
    header('Location: admin_faq_gestion.php');
    exit;
}

$query = "SELECT adg_faq.*, adg_faq_categories.name AS category_name FROM adg_faq LEFT JOIN adg_faq_categories ON adg_faq.id_category = adg_faq_categories.id WHERE adg_faq.id = :id";
$stmt = $db->prepare($query);
$stmt->execute([':id' => (int)$faq_id]);
$faq = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$faq) {
    header('Location: admin_faq_gestion.php');
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
    <title>Voir la question | Admin - Les Archives du Gardien</title>
</head>
<body class="bg-black text-primary-white">
    <?php include 'components/admin_sidebar.php'; ?>

    <main id="main-content" class="flex-1 min-h-screen overflow-y-auto bg-[url(../images/lava_cave_mob.webp)] bg-cover bg-center bg-fixed md:bg-[url(../images/lava_cave_without_f2_tab.webp)] lg:bg-[url(../images/lava_cave_without_f2.webp)] p-4 xl:p-8 xl:ml-64">

        <div class="mb-8">
            <a href="admin_faq_gestion.php" class="text-primary-orange hover:text-amber-400 flex items-center gap-2 transition-colors uppercase text-xs font-bold tracking-widest">
                <i class="ph ph-arrow-left"></i> Retour à la gestion
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl font-black uppercase tracking-widest border-b-2 border-primary-orange pb-4 inline-block">
                    Voir la question
                </h1>
                <a href="edit_faq.php?id=<?php echo $faq['id']; ?>" class="px-6 py-3 border border-primary-orange text-primary-orange font-black uppercase text-xs rounded hover:bg-primary-orange hover:text-primary-black transition-all flex items-center gap-2">
                    <i class="ph ph-pencil-simple text-lg"></i> Modifier
                </a>
            </div>

            <div class="bg-[#1a0f0a] border border-primary-orange rounded-lg p-6 lg:p-10 shadow-2xl">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Question</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white">
                            <?php echo htmlspecialchars($faq['question']); ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">R&eacute;ponse</span>
                        <div class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white leading-relaxed">
                            <?php echo nl2br(htmlspecialchars($faq['answer'])); ?>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Cat&eacute;gorie</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white">
                            <?php echo htmlspecialchars($faq['category_name'] ?? 'Aucune'); ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Ordre d'affichage</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white">
                            <?php echo (int)$faq['display_order']; ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Date de cr&eacute;ation</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white">
                            <?php echo date('d/m/Y à H:i', strtotime($faq['created_at'])); ?>
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-black uppercase text-primary-orange tracking-widest">Derni&egrave;re modification</span>
                        <span class="bg-black/60 border border-amber-900 rounded p-3 text-primary-white">
                            <?php echo date('d/m/Y à H:i', strtotime($faq['updated_at'])); ?>
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </main>

</body>
</html>
