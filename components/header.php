<header class="bg-primary-black border-primary-orange border-b px-8 py-8">
        <nav class="max-w-full mx-auto flex items-center" aria-label="Navigation principale">
            <div class="flex items-center lg:flex-1">
                <button type="button" class="lg:hidden bg-primary-orange p-2 rounded-xl text-primary-black" aria-label="Menu">
                    <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <a href="index.php" class="hidden lg:block flex-shrink-0">
                    <img src="assets/images/home_icons/dragon_logo.png" alt="Logo" class="h-30 w-30">
                </a>
                <ul class="hidden lg:flex items-center gap-12 ml-8 text-primary-white font-semibold uppercase text-lg tracking-wider">
                    <li><a href="mount_list.php" class="hover:text-primary-orange">Montures</a></li>
                    <li><a href="pet_list.php" class="hover:text-primary-orange">Mascottes</a></li>
                    <li><a href="transmo_list.php" class="hover:text-primary-orange">Apparences</a></li>
                </ul>
            </div>
            <div class="lg:hidden flex-1 flex justify-center">
                <a href="index.php">
                    <img src="assets/images/home_icons/dragon_logo.png" alt="Logo" class="h-30 w-30">
                </a>
            </div>
            <div class="flex items-center justify-end gap-4 lg:flex-none">
                <div class="hidden lg:flex gap-6">
                    <a href="#" onclick="toggleModal('loginModal')" class="bg-primary-orange text-primary-black font-bold py-2 px-6 rounded uppercase text-lg">Connexion</a>
                    <a href="#" onclick="toggleModal('registerModal')" class="bg-primary-orange text-primary-black font-bold py-2 px-6 rounded uppercase text-lg">Inscription</a>
                </div>
                <button type="button" class="lg:hidden p-2 border-2 border-primary-orange rounded-xl text-primary-orange" aria-label="Profil">
                    <svg class="w-9 h-9" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </button>
            </div>
        </nav>
    </header>