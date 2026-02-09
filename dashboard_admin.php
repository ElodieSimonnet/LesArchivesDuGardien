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
<body>
    <div class="min-h-screen flex flex-col">

    <header class="sticky top-0 z-50 flex justify-between items-center p-4 bg-[#1a0f0a] border-b border-primary-orange/70 w-full h-30 shrink-0">
        <div class="flex items-center">
            <img src="assets/images/home_icons/dragon_logo.png" alt="Logo" class="h-30 w-auto">
            <div class="flex flex-col text-[10px] uppercase font-bold text-amber-800 md:text-sm">
                <span>Les Archives Du Gardien</span> 
                <span class="text-amber-600">/ UTILISATEURS</span>
            </div>
        </div>

        <div class="flex items-center gap-6">
            <div class="flex flex-col items-end">
                <span class="text-[10px] text-amber-600/60 uppercase tracking-widest font-bold">Administrateur</span>
                <span class="font-bold text-sm text-primary-orange md:text-lg leading-tight capitalize">
                    <?php echo htmlspecialchars($_SESSION['username']); ?>
                </span>
            </div>

            <div class="h-8 w-px bg-primary-orange/30"></div>

            <a href="logout.php" class="flex items-center justify-center text-primary-orange hover:text-red-500 transition-all group" title="Se déconnecter">
                <i class="ph ph-sign-out text-3xl lg:text-4xl group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </header>

    <div class="flex flex-1 overflow-hidden">
      
      <aside class="hidden lg:flex w-64 flex-col bg-[#1a0f0a] border-r border-primary-orange/70 fixed h-full">
        <div class="p-6 flex flex-col items-center">
          <nav class="w-full space-y-8 mt-4">
            <a href="dashboard_admin.php" class="flex items-center gap-3 p-3 text-amber-600/60 hover:text-primary-orange uppercase text-xs font-bold tracking-widest transition-all">
              <span class="w-5 h-5 bg-amber-900/20 rounded-sm"></span> Tableau de bord
            </a>
            <a href="admin_user_gestion.php" class="flex items-center gap-3 p-3 bg-amber-900/20 text-primary-orange border-l-4 border-primary-orange uppercase text-xs font-bold tracking-widest">
              <span class="w-5 h-5 bg-primary-orange rounded-sm"></span> Utilisateurs
            </a>
            <a href="#" class="flex items-center gap-3 p-3 text-amber-600/60 hover:text-primary-orange uppercase text-xs font-bold tracking-widest transition-all">
              <span class="w-5 h-5 bg-amber-900/20 rounded-sm"></span> Montures
            </a>
            <a href="#" class="flex items-center gap-3 p-3 text-amber-600/60 hover:text-primary-orange uppercase text-xs font-bold tracking-widest transition-all">
              <span class="w-5 h-5 bg-amber-900/20 rounded-sm"></span> Mascottes
            </a>
            <a href="#" class="flex items-center gap-3 p-3 text-amber-600/60 hover:text-primary-orange uppercase text-xs font-bold tracking-widest transition-all">
              <span class="w-5 h-5 bg-amber-900/20 rounded-sm"></span> Nouveautés
            </a>
            <a href="#" class="flex items-center gap-3 p-3 text-amber-600/60 hover:text-primary-orange uppercase text-xs font-bold tracking-widest transition-all">
              <span class="w-5 h-5 bg-amber-900/20 rounded-sm"></span> F.A.Q
            </a>
          </nav>
        </div>
      </aside>

    <main class="flex-1 overflow-y-auto bg-[url(../images/lava_cave_mobile.jpg)] bg-cover bg-center lg:bg-[url(../images/lava_cave.jpg)] bg-fixed text-primary-white font-sans p-4 lg:p-8 lg:ml-64">
        
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