<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons" defer></script>
    <link href="../assets/css/output.css" rel="stylesheet">
    <title>Dashboard | Admin - Les Archives du Gardien</title>
</head>
<body class="bg-black">
    <?php require __DIR__ . '/sidebar.php'; ?>

    <main id="main-content" class="flex-1 overflow-y-auto bg-[url(../images/lava_cave_mob.webp)] bg-cover bg-center bg-fixed md:bg-[url(../images/lava_cave_without_f2_tab.webp)] lg:bg-[url(../images/lava_cave_without_f2.webp)] text-primary-white font-sans p-4 xl:p-8 lg:ml-64">

        <div class="mb-10 text-center">
            <h1 class="text-2xl font-black text-primary-orange uppercase">Archives Centrales</h1>
            <p class="text-primary-orange text-xs uppercase tracking-[0.3em]">Résumé de l'activité</p>
        </div>

        <section aria-label="Statistiques utilisateurs">
            <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-12">
                <div class="bg-admin-dark border-2 border-primary-white p-8 rounded-lg flex flex-col items-center">
                    <dt class="text-[10px] font-bold text-primary-white uppercase tracking-widest">Utilisateurs inscrits</dt>
                    <dd class="text-4xl font-black text-primary-white mt-1"><?= $totalUsers ?></dd>
                </div>

                <div class="bg-admin-dark border-2 border-green-500 p-8 rounded-lg flex flex-col items-center">
                    <dt class="text-[10px] font-bold text-green-500 uppercase tracking-widest">Âmes Actives</dt>
                    <dd class="text-4xl font-black text-green-500 mt-1"><?= $activeUsers ?></dd>
                </div>

                <div class="bg-admin-dark border-2 border-primary-orange p-8 rounded-lg flex flex-col items-center group hover:border-primary-orange transition-all">
                    <dt class="text-[10px] font-bold text-primary-orange uppercase tracking-widest">Âmes en Sursis</dt>
                    <dd class="text-4xl font-black text-primary-orange mt-1"><?= $suspendedUsers ?></dd>
                </div>

                <div class="bg-admin-dark border-2 border-red-500 p-8 rounded-lg flex flex-col items-center">
                    <dt class="text-[10px] font-bold text-red-500 uppercase tracking-widest">Âmes Exilés</dt>
                    <dd class="text-4xl font-black text-red-500 mt-1"><?= $bannedUsers ?></dd>
                </div>
            </dl>
        </section>

        <section aria-labelledby="last-entries-heading" class="bg-admin-dark border border-primary-orange rounded-lg">
            <div class="p-4 bg-amber-900/10 border-b border-primary-orange">
                <h2 id="last-entries-heading" class="text-xs font-black text-primary-orange uppercase tracking-[0.2em]">Dernières Entrées</h2>
            </div>
            <ul class="p-2">
                <?php foreach ($lastUsers as $lastUser): ?>
                <li class="flex justify-between items-center p-3 hover:bg-white/5 rounded transition-all">
                    <span class="font-bold text-primary-white capitalize"><?= htmlspecialchars($lastUser['username']) ?></span>
                    <span class="sm:text-sm md:text-lg text-primary-orange italic"><?= htmlspecialchars($lastUser['email']) ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
</body>
</html>
