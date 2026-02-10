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
                <i class="ph ph-sign-out text-3xl xl:text-4xl group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </header>

    <div class="flex flex-1 overflow-hidden">
      
      <aside class="hidden xl:flex w-64 flex-col bg-[#1a0f0a] border-r border-primary-orange/70 fixed h-full">
        <div class="p-6 flex flex-col items-center">
          <nav class="w-full space-y-8 mt-4">
            <a href="dashboard_admin.php" class="flex items-center gap-3 p-3 text-amber-600/60 hover:text-primary-orange uppercase text-xs font-bold tracking-widest transition-all">
              <span class="w-5 h-5 bg-amber-900/20 rounded-sm"></span> Tableau de bord
            </a>
            <a href="#" class="flex items-center gap-3 p-3 bg-amber-900/20 text-primary-orange border-l-4 border-primary-orange uppercase text-xs font-bold tracking-widest">
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