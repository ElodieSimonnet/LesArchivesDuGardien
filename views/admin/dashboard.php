<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="../assets/js/admin-sidebar.js" defer></script>
    <link href="../assets/css/output.css" rel="stylesheet">
    <title>Dashboard | Admin - Les Archives du Gardien</title>
</head>
<body class="bg-black">
    <?php require __DIR__ . '/sidebar.php'; ?>

    <main class="flex-1 min-h-screen overflow-y-auto bg-[url(../images/lava_cave_mob.webp)] bg-cover bg-center bg-fixed md:bg-[url(../images/lava_cave_without_f2_tab.webp)] lg:bg-[url(../images/lava_cave_without_f2.webp)] text-primary-white font-sans p-4 xl:p-8 lg:ml-64">

        <div class="mb-10 text-center">
            <h1 class="text-2xl font-black text-primary-orange uppercase">Archives Centrales</h1>
            <p class="text-primary-orange text-xs uppercase tracking-[0.3em]">Résumé de l'activité</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-12">
            <div class="bg-[#1a0f0a] border-2 border-primary-white p-8 rounded-lg flex flex-col items-center">
                <span class="text-4xl font-black text-primary-white mb-1"><?= $totalUsers ?></span>
                <span class="text-[10px] font-bold text-primary-white uppercase tracking-widest">Utilisateurs inscrits</span>
            </div>

            <div class="bg-[#1a0f0a] border-2 border-green-500 p-8 rounded-lg flex flex-col items-center">
                <span class="text-4xl font-black text-green-500 mb-1"><?= $activeUsers ?></span>
                <span class="text-[10px] font-bold text-green-500 uppercase tracking-widest">Âmes Actives</span>
            </div>

            <div class="bg-[#1a0f0a] border-2 border-primary-orange p-8 rounded-lg flex flex-col items-center group hover:border-primary-orange transition-all">
                <span class="text-4xl font-black text-primary-orange mb-1"><?= $suspendedUsers ?></span>
                <span class="text-[10px] font-bold text-primary-orange uppercase tracking-widest">Âmes en Sursis</span>
            </div>

            <div class="bg-[#1a0f0a] border-2 border-red-500 p-8 rounded-lg flex flex-col items-center">
                <span class="text-4xl font-black text-red-500 mb-1"><?= $bannedUsers ?></span>
                <span class="text-[10px] font-bold text-red-500 uppercase tracking-widest">Âmes Exilés</span>
            </div>
        </div>

        <div class="bg-[#1a0f0a] border border-primary-orange rounded-lg">
            <div class="p-4 bg-amber-900/10 border-b border-primary-orange">
                <h2 class="text-xs font-black text-primary-orange uppercase tracking-[0.2em]">Dernières Entrées</h2>
            </div>
            <div class="p-2">
                <?php foreach ($lastUsers as $lastUser): ?>
                <div class="flex justify-between items-center p-3 hover:bg-white/5 rounded transition-all">
                    <span class="font-bold text-primary-white capitalize"><?= htmlspecialchars($lastUser['username']) ?></span>
                    <span class="sm:text-sm md:text-lg text-primary-orange italic"><?= htmlspecialchars($lastUser['email']) ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
</body>
</html>
