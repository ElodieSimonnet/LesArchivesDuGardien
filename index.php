<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="./script.js" defer></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Les Archives Du Gardien</title>
</head>
<body class="min-h-screen flex flex-col">
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
                <a href="/">
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



    <main class="bg-[url(../images/lava_cave_mobile.jpg)] bg-cover bg-center pt-16 flex-grow px-16
                 lg:bg-[url(../images/lava_cave.jpg)]">
        <div class="mx-auto max-w-xl  
                    md:bg-primary-brown md:rounded-lg md:border-2 md:border-primary-orange md:p-6 md:max-w-4xl
                    lg:max-w-5xl">
            <header class="text-center">
                <h1 class="text-primary-orange text-3xl p-5 
                           md:text-4xl">Les Archives Du Gardien</h1>
                <h2 class="text-primary-white text-xl p-5 
                           md:text-2xl">"Un lieu sûr pour suivre et conserver vos trésors d'Azeroth"</h2>
            </header>
        </div>
        <section class="md:mt-16 md:mb-16">
            <ul class="grid grid-cols-1 gap-8 py-4 mx-auto
                      md:grid-cols-2 md:max-w-4xl
                      lg:grid-cols-3 lg:gap-x-14 lg:max-w-5xl lg:mx-auto">
                <li class="mx-auto max-w-[16rem] 
                          md:mx-auto md:max-w-none
                          lg:mx-auto lg:max-w-sm">
                    <a href="mounts.html" class="block bg-primary-brown rounded-xl shadow-md p-4 border-2 border-primary-orange">
                        <figure class="flex flex-col items-center">
                            <img src="assets/images/home_icons/dragon_icon.png" alt="icône de dragon doré représentant la catégorie monture">
                            <figcaption class="text-center font-bold text-lg text-primary-orange">MONTURES</figcaption>
                        </figure>
                        
                    </a>
                </li>
                <li class="mx-auto max-w-[16rem] 
                          md:mx-auto md:max-w-none
                          lg:mx-auto lg:max-w-md">
                    <a href="pets.html" class="block bg-primary-brown rounded-xl p-4 border-2 border-primary-orange">
                        <figure class="flex flex-col items-center">
                            <img src="assets/images/home_icons/cat_icon.png" alt="icône de chat doré représentant la catégorie mascottes">
                            <figcaption class="text-center font-bold text-lg text-primary-orange">MASCOTTES</figcaption>
                        </figure>
                        
                    </a>
                </li>
                <li class="mx-auto max-w-[16rem] 
                          md:col-span-2 md:w-full md:max-w-[calc(50%-1rem)] md:mt-8
                          lg:col-span-1 lg:mx-auto lg:max-w-none lg:mt-0">
                    <a href="transmo.html" class="block bg-primary-brown rounded-xl p-4 border-2 border-primary-orange">
                        <figure class="flex flex-col items-center">
                            <img src="assets/images/home_icons/transmo_icon.png" alt="icône de casque doré représentant la catégorie apparences">
                            <figcaption class="text-center font-bold text-lg text-primary-orange">APPARENCES</figcaption>
                        </figure>
                        
                    </a>
                </li>
            </ul>
        </section>
    </main>
    
    <footer class="bg-primary-black text-primary-white border-t border-primary-orange py-8 px-4">
        <div class="max-w-6xl mx-auto flex flex-col items-center gap-12 lg:flex-row lg:justify-between lg:gap-4">
            <nav>
                <ul class="flex flex-row items-center gap-10 text-sm font-bold tracking-wide md:gap-20 md:text-base lg:text-lg">
                    <li>
                        <a href="#" class="hover:text-primary-orange uppercase">Nouveautés</a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-primary-orange uppercase">F.A.Q</a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-primary-orange uppercase">Mentions Légales</a>
                    </li>
                </ul>
            </nav>
        <div class="flex flex-col items-center gap-4 lg:flex-row lg:gap-6">
            <span class="text-primary-orange font-extrabold uppercase tracking-widest text-base lg:text-lg">
                Suivez-nous :
            </span>
            <div class="flex items-center gap-8">
                <a href="#" target="_blank" class="w-10 h-10 bg-primary-white rounded-full flex items-center justify-center hover:bg-primary-orange group" aria-label="Discord">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/discord.svg" class="w-6 h-6" alt="logo discord">
                </a>
                <a href="#" target="_blank" class="w-10 h-10 bg-primary-white rounded-full flex items-center justify-center hover:bg-primary-orange group" aria-label="Twitch">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/twitch.svg" class="w-6 h-6" alt="logo twitch">
                </a>
                <a href="#" target="_blank" class="w-10 h-10 bg-primary-white rounded-full flex items-center justify-center hover:bg-primary-orange group" aria-label="YouTube">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/youtube.svg" class="w-6 h-6" alt="logo youtube">
                </a>
            </div>
        </div>
    </footer>
    
    <?php include 'modals.php'; ?>

</body>
</html>