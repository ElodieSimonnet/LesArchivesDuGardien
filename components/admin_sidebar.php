<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
<div class="min-h-screen flex flex-col">

    <header class="sticky top-0 z-50 flex justify-between items-center p-4 bg-[#1a0f0a] border-b border-primary-orange/70 w-full h-30 shrink-0">
        <div class="flex items-center gap-3">
            <!-- Burger - visible en dessous de lg -->
            <button id="admin-burger" class="lg:hidden flex flex-col justify-center items-center w-8 h-8 gap-1.5 text-primary-orange cursor-pointer" aria-label="Ouvrir le menu de navigation">
                <span class="block w-6 h-0.5 bg-current"></span>
                <span class="block w-6 h-0.5 bg-current"></span>
                <span class="block w-6 h-0.5 bg-current"></span>
            </button>
            <img src="assets/images/home_icons/dragon_logo.png" alt="Logo" class="h-30 w-auto hidden lg:block">
            <div class="flex flex-col text-[10px] uppercase font-bold text-amber-800 md:text-sm">
                <span>Les Archives Du Gardien</span>
                <?php
                    $sidebarLabel = match($currentPage) {
                        'admin_mount_gestion.php' => 'MONTURES',
                        'admin_user_gestion.php' => 'UTILISATEURS',
                        'admin_pet_gestion.php' => 'MASCOTTES',
                        'admin_news_gestion.php' => 'ACTUALITÉS',
                        'admin_faq_gestion.php' => 'F.A.Q',
                        'dashboard_admin.php' => 'TABLEAU DE BORD',
                        default => 'ADMINISTRATION',
                    };
                ?>
                <span class="text-amber-600">/ <?php echo $sidebarLabel; ?></span>
            </div>
        </div>

        <div class="flex items-center gap-6">
            <div class="flex flex-col items-end">
                <span class="text-[10px] text-amber-600/60 uppercase tracking-widest font-bold">Admin.</span>
                <span class="font-bold text-sm text-primary-orange md:text-lg leading-tight capitalize">
                    <?php echo htmlspecialchars($_SESSION['username']); ?>
                </span>
            </div>

            <div class="h-8 w-px bg-primary-orange/30"></div>

            <a href="logout.php" class="flex items-center justify-center text-primary-orange hover:text-red-500 transition-all group" title="Se déconnecter">
                <i class="ph ph-sign-out text-3xl xl:text-4xl group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </header>

    <!-- Overlay backdrop (mobile/tablet) -->
    <div id="admin-overlay" class="fixed inset-0 bg-black/60 z-[55] hidden"></div>

    <div class="flex flex-1 overflow-hidden">

      <aside id="admin-sidebar" class="flex w-64 flex-col bg-[#1a0f0a] border-r border-primary-orange/70 fixed top-30 bottom-0 z-[60] -translate-x-full lg:translate-x-0 transition-transform duration-300">

<div class="p-6 flex flex-col items-center">
          <nav class="w-full space-y-8 mt-4">
            <a href="dashboard_admin.php" class="flex items-center gap-3 p-3 <?php echo ($currentPage === 'dashboard_admin.php') ? 'bg-amber-900/20 text-primary-orange border-l-4 border-primary-orange' : 'text-amber-600/60 hover:text-primary-orange transition-all'; ?> uppercase text-xs font-bold tracking-widest">
              <span class="w-5 h-5 <?php echo ($currentPage === 'dashboard_admin.php') ? 'bg-primary-orange' : 'bg-amber-900/20'; ?> rounded-sm"></span> Tableau de bord
            </a>
            <a href="admin_user_gestion.php" class="flex items-center gap-3 p-3 <?php echo ($currentPage === 'admin_user_gestion.php') ? 'bg-amber-900/20 text-primary-orange border-l-4 border-primary-orange' : 'text-amber-600/60 hover:text-primary-orange transition-all'; ?> uppercase text-xs font-bold tracking-widest">
              <span class="w-5 h-5 <?php echo ($currentPage === 'admin_user_gestion.php') ? 'bg-primary-orange' : 'bg-amber-900/20'; ?> rounded-sm"></span> Utilisateurs
            </a>
            <a href="admin_mount_gestion.php" class="flex items-center gap-3 p-3 <?php echo ($currentPage === 'admin_mount_gestion.php') ? 'bg-amber-900/20 text-primary-orange border-l-4 border-primary-orange' : 'text-amber-600/60 hover:text-primary-orange transition-all'; ?> uppercase text-xs font-bold tracking-widest">
              <span class="w-5 h-5 <?php echo ($currentPage === 'admin_mount_gestion.php') ? 'bg-primary-orange' : 'bg-amber-900/20'; ?> rounded-sm"></span> Montures
            </a>
            <a href="admin_pet_gestion.php" class="flex items-center gap-3 p-3 <?php echo ($currentPage === 'admin_pet_gestion.php') ? 'bg-amber-900/20 text-primary-orange border-l-4 border-primary-orange' : 'text-amber-600/60 hover:text-primary-orange transition-all'; ?> uppercase text-xs font-bold tracking-widest">
              <span class="w-5 h-5 <?php echo ($currentPage === 'admin_pet_gestion.php') ? 'bg-primary-orange' : 'bg-amber-900/20'; ?> rounded-sm"></span> Mascottes
            </a>
            <a href="admin_news_gestion.php" class="flex items-center gap-3 p-3 <?php echo ($currentPage === 'admin_news_gestion.php') ? 'bg-amber-900/20 text-primary-orange border-l-4 border-primary-orange' : 'text-amber-600/60 hover:text-primary-orange transition-all'; ?> uppercase text-xs font-bold tracking-widest">
              <span class="w-5 h-5 <?php echo ($currentPage === 'admin_news_gestion.php') ? 'bg-primary-orange' : 'bg-amber-900/20'; ?> rounded-sm"></span> Nouveautés
            </a>
            <a href="admin_faq_gestion.php" class="flex items-center gap-3 p-3 <?php echo ($currentPage === 'admin_faq_gestion.php') ? 'bg-amber-900/20 text-primary-orange border-l-4 border-primary-orange' : 'text-amber-600/60 hover:text-primary-orange transition-all'; ?> uppercase text-xs font-bold tracking-widest">
              <span class="w-5 h-5 <?php echo ($currentPage === 'admin_faq_gestion.php') ? 'bg-primary-orange' : 'bg-amber-900/20'; ?> rounded-sm"></span> F.A.Q
            </a>
          </nav>
        </div>
      </aside>

