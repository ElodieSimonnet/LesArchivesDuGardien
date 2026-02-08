<header class="bg-primary-black border-primary-orange border-b px-8 py-8">
    <nav class="max-w-full mx-auto flex items-center justify-between" aria-label="Navigation principale">
        
        <div class="flex items-center gap-8">
            <a href="index.php" class="flex-shrink-0">
                <img src="assets/images/home_icons/dragon_logo.png" alt="Logo" class="h-24 w-24 md:h-30 md:w-30">
            </a>

            <ul class="hidden lg:flex items-center gap-12 text-primary-white font-semibold uppercase text-lg tracking-wider">
                <li><a href="mount_list.php" class="hover:text-primary-orange transition-colors">Montures</a></li>
                <li><a href="pet_list.php" class="hover:text-primary-orange transition-colors">Mascottes</a></li>
            </ul>
        </div>

        <div class="flex items-center gap-4">
            
            <div class="hidden lg:flex gap-8 items-center">
                <?php if (isset($_SESSION['username'])): ?>
                    <span class="text-primary-white text-xl font-bold">
                        Bienvenue, 
                        <a href="profile.php" class="text-primary-orange hover:underline uppercase transition-all">
                            <?php echo htmlspecialchars($_SESSION['username']); ?>
                        </a>
                    </span>
                    <form action="logout.php" method="POST" class="inline">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <button type="submit" class="bg-primary-orange text-primary-black font-bold py-2 px-6 rounded uppercase text-lg hover:bg-amber-500 transition-all shadow-md">
                            Déconnexion
                        </button>
                    </form>
                <?php else: ?>
                    <a href="#" onclick="toggleModal('loginModal')" class="border-2 border-primary-orange text-primary-orange font-bold py-2 px-6 rounded uppercase text-lg hover:bg-primary-orange hover:text-primary-black transition-colors">Connexion</a>
                    <a href="#" onclick="toggleModal('registerModal')" class="border-2 border-primary-orange text-primary-orange font-bold py-2 px-6 rounded uppercase text-lg hover:bg-primary-orange hover:text-primary-black transition-colors">Inscription</a>
                <?php endif; ?>
            </div>

            <button id="open-menu" type="button" class="lg:hidden bg-primary-orange p-2 rounded-xl text-primary-black" aria-label="Menu">
                <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

    </nav>
</header>


<div id="mobile-menu" class="fixed inset-y-0 right-0 z-[300] w-full bg-primary-black transform translate-x-full transition-transform duration-300 ease-in-out lg:hidden border-l border-primary-orange shadow-2xl flex flex-col">
    
    <div class="flex justify-between items-center px-8 h-28 border-b border-primary-orange">
        <span class="text-primary-orange font-bold uppercase tracking-widest text-xl">Menu</span>
        <button id="close-menu" class="text-primary-orange p-2 border-2 border-primary-orange rounded-xl hover:bg-primary-orange hover:text-primary-black transition-all">
            <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto px-8 py-10 flex flex-col">
        <ul class="flex flex-col gap-6 mt-4 text-primary-white font-bold uppercase tracking-wider">
            <li>
                <a href="mount_list.php" class="flex items-center justify-between p-4 bg-amber-500/15 border-l-4 border-primary-orange rounded-r-lg">
                    <div class="flex items-center gap-4">
                        <i class="fas fa-dragon text-primary-orange text-xl"></i>
                        <span class="text-xl">Montures</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="pet_list.php" class="flex items-center justify-between p-4 bg-amber-500/15 border-l-4 border-primary-orange rounded-r-lg">
                    <div class="flex items-center gap-4">
                        <i class="fas fa-paw text-primary-orange text-xl"></i>
                        <span class="text-xl">Mascottes</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="news.php" class="flex items-center gap-4 p-4 bg-amber-500/15 border-l-4 border-primary-orange rounded-r-lg">
                    <i class="fas fa-bullhorn text-primary-orange text-xl"></i>
                    <span class="text-xl">Nouveautés</span>
                </a>
            </li>
            <li>
                <a href="faq.php" class="flex items-center gap-4 p-4 bg-amber-500/15 border-l-4 border-primary-orange rounded-r-lg">
                    <i class="fas fa-question-circle text-primary-orange text-xl"></i>
                    <span class="text-xl">F.A.Q</span>
                </a>
            </li>
        </ul>

        <div class="flex flex-col gap-6 mt-12">
            <?php if (isset($_SESSION['username'])): ?>
                <div class="flex flex-col gap-4">
                    <a href="profile.php" class="bg-primary-orange text-primary-black text-center py-4 rounded font-bold uppercase text-lg flex items-center justify-center gap-3">
                        <i class="fas fa-user-circle"></i>
                        Mon Profil
                    </a>
                    <form action="logout.php" method="POST" class="w-full">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <button type="submit" class="w-full bg-red-600 text-primary-white text-center py-4 rounded font-bold uppercase text-lg">
                            Déconnexion
                        </button>
                    </form>
                </div>
            <?php else: ?>
                <div class="flex flex-col gap-4">
                    <a href="#" onclick="toggleModal('loginModal')" class="bg-primary-orange text-primary-black text-center py-4 rounded font-bold uppercase text-lg">Connexion</a>
                    <a href="#" onclick="toggleModal('registerModal')" class="border-2 border-primary-orange text-primary-orange text-center py-4 rounded font-bold uppercase text-lg">Inscription</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>