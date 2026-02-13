<?php
require_once 'components/utils/db_connection.php';
require_once 'components/utils/is_admin.php';
restrictToAdmin();
?>
<?php include 'retrieveAllUsersData.php';?>
<?php include 'retrieveDashboardData.php';?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Dashboard</title>
</head>
<body class="bg-black">
    <?php include 'components/admin_sidebar.php'; ?>

    <main class="flex-1 min-h-screen overflow-y-auto bg-[url(../images/lava_cave_mobile.jpg)] bg-cover bg-center lg:bg-[url(../images/lava_cave.jpg)] bg-fixed text-primary-white font-sans p-4 xl:p-8 xl:ml-64">
        
        <div class="mb-10 text-center">
            <h2 class="text-2xl font-black text-primary-orange uppercase">Archives Centrales</h2>
            <p class="text-primary-orange text-xs uppercase tracking-[0.3em]">Résumé de l'activité</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-12">
            <div class="bg-[#1a0f0a] border-2 border-primary-white p-8 rounded-lg flex flex-col items-center">
                <span class="text-4xl font-black text-primary-white mb-1"><?php echo $totalUsers; ?></span>
                <span class="text-[10px] font-bold text-primary-white uppercase tracking-widest">Utilisateurs inscrits</span>
            </div>

            <div class="bg-[#1a0f0a] border-2 border-green-500 p-8 rounded-lg flex flex-col items-center">
                <span class="text-4xl font-black text-green-500 mb-1"><?php echo $activeUsers; ?></span>
                <span class="text-[10px] font-bold text-green-500 uppercase tracking-widest">Âmes Actives</span>
            </div>

            <div class="bg-[#1a0f0a] border-2 border-primary-orange p-8 rounded-lg flex flex-col items-center group hover:border-primary-orange transition-all">
                <span class="text-4xl font-black text-primary-orange mb-1"><?php echo $suspendedUsers; ?></span>
                <span class="text-[10px] font-bold text-primary-orange uppercase tracking-widest">Âmes en Sursis</span>
            </div>

            <div class="bg-[#1a0f0a] border-2 border-red-500 p-8 rounded-lg flex flex-col items-center">
                <span class="text-4xl font-black text-red-500 mb-1"><?php echo $bannedUsers; ?></span>
                <span class="text-[10px] font-bold text-red-500 uppercase tracking-widest">Âmes Exilés</span>
            </div>
        </div>

        <div class="bg-[#1a0f0a] border border-primary-orange rounded-lg">
            <div class="p-4 bg-amber-900/10 border-b border-primary-orange">
                <h3 class="text-xs font-black text-primary-orange uppercase tracking-[0.2em]">Dernières Entrées</h3>
            </div>
            <div class="p-2">
                <?php foreach($lastUsers as $user): ?>
                <div class="flex justify-between items-center p-3 hover:bg-white/5 rounded transition-all">
                    <span class="font-bold text-primary-white capitalize"><?php echo htmlspecialchars($user['username']); ?></span>
                    <span class="sm:text-sm md:text-lg text-primary-orange italic"><?php echo htmlspecialchars($user['email']); ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
</body>
</html>