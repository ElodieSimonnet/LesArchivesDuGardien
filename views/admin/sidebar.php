<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
<a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:z-[999] focus:bg-primary-orange focus:text-primary-black focus:px-4 focus:py-2 focus:font-bold">Aller au contenu principal</a>
<div class="h-screen flex flex-col overflow-hidden">

    <header class="sticky top-0 z-50 flex justify-between items-center p-4 bg-admin-dark border-b border-primary-orange/70 w-full h-30 shrink-0">
        <div class="flex items-center gap-3">
            <button type="button" id="admin-burger" class="lg:hidden flex flex-col justify-center items-center w-8 h-8 gap-1.5 text-primary-orange cursor-pointer" aria-label="Ouvrir le menu de navigation" aria-expanded="false" aria-controls="admin-sidebar">
                <span class="block w-6 h-0.5 bg-current" aria-hidden="true"></span>
                <span class="block w-6 h-0.5 bg-current" aria-hidden="true"></span>
                <span class="block w-6 h-0.5 bg-current" aria-hidden="true"></span>
            </button>
            <img src="../assets/images/home_icons/dragon_logo.png" alt="Les Archives du Gardien" class="h-30 w-auto hidden lg:block">
            <div class="flex flex-col text-[10px] uppercase font-bold text-amber-800 md:text-sm">
                <span>Les Archives Du Gardien</span>
                <?php
                    $sidebarLabel = match($currentPage) {
                        'mount_management.php' => 'MONTURES',
                        'user_management.php'  => 'UTILISATEURS',
                        'pet_management.php'   => 'MASCOTTES',
                        'news_management.php'  => 'ACTUALITÉS',
                        'faq_management.php'   => 'F.A.Q',
                        'dashboard.php'     => 'TABLEAU DE BORD',
                        default                   => 'ADMINISTRATION',
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

            <a href="../index.php" class="flex items-center justify-center text-primary-orange hover:text-amber-400 hover:scale-125 transition-all" aria-label="Retour au site">
                <i class="ph ph-house text-3xl xl:text-4xl" aria-hidden="true"></i>
            </a>
        </div>
    </header>

    <div id="admin-overlay" class="fixed inset-0 bg-black/60 z-[55] hidden" aria-hidden="true"></div>

    <div class="flex flex-1 overflow-hidden">

      <aside id="admin-sidebar" class="flex w-64 flex-col bg-admin-dark border-r border-primary-orange/70 fixed top-30 bottom-0 z-[60] -translate-x-full lg:translate-x-0 transition-transform duration-300">

        <div class="p-6 flex flex-col items-center">
          <nav class="w-full space-y-8 mt-4" aria-label="Navigation administration">
            <a href="dashboard.php" <?php echo ($currentPage === 'dashboard.php') ? 'aria-current="page"' : ''; ?> class="flex items-center gap-3 p-3 <?php echo ($currentPage === 'dashboard.php') ? 'bg-amber-900/20 text-primary-orange border-l-4 border-primary-orange' : 'text-amber-600/60 hover:text-primary-orange transition-all'; ?> uppercase text-xs font-bold tracking-widest">
              <span class="w-5 h-5 <?php echo ($currentPage === 'dashboard.php') ? 'bg-primary-orange' : 'bg-amber-900/20'; ?> rounded-sm"></span> Tableau de bord
            </a>
            <a href="user_management.php" <?php echo ($currentPage === 'user_management.php') ? 'aria-current="page"' : ''; ?> class="flex items-center gap-3 p-3 <?php echo ($currentPage === 'user_management.php') ? 'bg-amber-900/20 text-primary-orange border-l-4 border-primary-orange' : 'text-amber-600/60 hover:text-primary-orange transition-all'; ?> uppercase text-xs font-bold tracking-widest">
              <span class="w-5 h-5 <?php echo ($currentPage === 'user_management.php') ? 'bg-primary-orange' : 'bg-amber-900/20'; ?> rounded-sm"></span> Utilisateurs
            </a>
            <a href="mount_management.php" <?php echo ($currentPage === 'mount_management.php') ? 'aria-current="page"' : ''; ?> class="flex items-center gap-3 p-3 <?php echo ($currentPage === 'mount_management.php') ? 'bg-amber-900/20 text-primary-orange border-l-4 border-primary-orange' : 'text-amber-600/60 hover:text-primary-orange transition-all'; ?> uppercase text-xs font-bold tracking-widest">
              <span class="w-5 h-5 <?php echo ($currentPage === 'mount_management.php') ? 'bg-primary-orange' : 'bg-amber-900/20'; ?> rounded-sm"></span> Montures
            </a>
            <a href="pet_management.php" <?php echo ($currentPage === 'pet_management.php') ? 'aria-current="page"' : ''; ?> class="flex items-center gap-3 p-3 <?php echo ($currentPage === 'pet_management.php') ? 'bg-amber-900/20 text-primary-orange border-l-4 border-primary-orange' : 'text-amber-600/60 hover:text-primary-orange transition-all'; ?> uppercase text-xs font-bold tracking-widest">
              <span class="w-5 h-5 <?php echo ($currentPage === 'pet_management.php') ? 'bg-primary-orange' : 'bg-amber-900/20'; ?> rounded-sm"></span> Mascottes
            </a>
            <a href="news_management.php" <?php echo ($currentPage === 'news_management.php') ? 'aria-current="page"' : ''; ?> class="flex items-center gap-3 p-3 <?php echo ($currentPage === 'news_management.php') ? 'bg-amber-900/20 text-primary-orange border-l-4 border-primary-orange' : 'text-amber-600/60 hover:text-primary-orange transition-all'; ?> uppercase text-xs font-bold tracking-widest">
              <span class="w-5 h-5 <?php echo ($currentPage === 'news_management.php') ? 'bg-primary-orange' : 'bg-amber-900/20'; ?> rounded-sm"></span> Nouveautés
            </a>
            <a href="faq_management.php" <?php echo ($currentPage === 'faq_management.php') ? 'aria-current="page"' : ''; ?> class="flex items-center gap-3 p-3 <?php echo ($currentPage === 'faq_management.php') ? 'bg-amber-900/20 text-primary-orange border-l-4 border-primary-orange' : 'text-amber-600/60 hover:text-primary-orange transition-all'; ?> uppercase text-xs font-bold tracking-widest">
              <span class="w-5 h-5 <?php echo ($currentPage === 'faq_management.php') ? 'bg-primary-orange' : 'bg-amber-900/20'; ?> rounded-sm"></span> F.A.Q
            </a>
          </nav>
        </div>

        <div class="mt-8 p-6 border-t border-primary-orange/30">
            <form action="logout.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <button type="submit" class="w-full flex items-center justify-center gap-3 py-3.5 px-4 bg-primary-orange hover:bg-red-600 text-primary-black hover:text-primary-white font-bold rounded-lg uppercase text-xs tracking-widest transition-all active:scale-[0.98]">
                    <i class="ph ph-sign-out text-base" aria-hidden="true"></i> Déconnexion
                </button>
            </form>
        </div>
      </aside>
    <script src="../assets/js/flash-messages.js" defer></script>
    <script src="../assets/js/admin-mobile-sidebar.js" defer></script>
