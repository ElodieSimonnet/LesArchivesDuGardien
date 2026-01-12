<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="./script.js" defer></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Détails des montures</title>
</head>
<body>
    <header class="bg-primary-black border-primary-orange border-b px-8 py-8">
        <nav class="max-w-full mx-auto flex items-center" aria-label="Navigation principale">
            <div class="flex items-center lg:flex-1">
                <button type="button" class="lg:hidden bg-primary-orange p-2 rounded-xl text-primary-black" aria-label="Menu">
                    <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <a href="index.html" class="hidden lg:block flex-shrink-0">
                    <img src="assets/images/home_icons/dragon_logo.png" alt="Logo" class="h-30 w-30">
                </a>
                <ul class="hidden lg:flex items-center gap-12 ml-8 text-primary-white font-semibold uppercase text-lg tracking-wider">
                    <li><a href="#" class="hover:text-primary-orange">Montures</a></li>
                    <li><a href="#" class="hover:text-primary-orange">Mascottes</a></li>
                    <li><a href="#" class="hover:text-primary-orange">Apparences</a></li>
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
    <main class="bg-[url(../images/lava_cave_mobile.jpg)] bg-cover bg-center pt-16 pb-36
                 lg:bg-[url(../images/lava_cave.jpg)]">
        <div class="lg:max-w-5xl lg:mx-auto px-4 lg:px-12">
            <section class="bg-primary-brown rounded-xl border-2 border-primary-orange w-4/5 mx-auto
                            lg:w-full mb-8">
                <h1 class="text-xl font-semibold text-center uppercase text-primary-orange pt-4
                       md:text-3xl">charognard des dunes capturé
                </h1>
                <p class="text-lg font-semibold text-justify text-primary-white p-4
                      lg:text-xl">"Ces charognards très résistants peuvent survivre plusieurs mois dans le désert de Vol'dun avec très peu d'eau ou de nourriture."
                </p>
            </section>
        
            <div class="lg:grid lg:grid-cols-2 lg:gap-12">
                <article class="bg-primary-brown rounded-xl border-2 border-primary-orange w-4/5 mx-auto mt-4 
                                lg:w-full lg:mx-0 flex flex-col">
            
                    <header class="flex px-4 py-2">
                        <img src="assets/images/mounts/horsehoe.png" alt="logo de fer à cheval doré pour les montures terrestres" class="w-20 h-auto pt-1">
                        <i class="ph-bold ph-heart text-7xl text-red-500 pr-2 pt-2 ml-auto"></i>
                        <i class="ph-fill ph-heart-straight absolute hidden"></i> 
                    </header>

                    <div class="flex flex-col justify-center items-center flex-grow">
                        <img src="assets/images/mounts/hyène.png" alt="Image du Charognard des Dunes" class="w-3/5 h-auto">
                        <h2 class="text-base text-primary-white text-center pb-4 uppercase mt-0 mb-0
                                   md:text-2xl">
                        charognard des dunes capturé
                        </h2>
                    </div>

                    

                    <hr class="bg-primary-orange h-0.5 border-none w-full mx-auto">

                    <footer class="flex justify-center items-center h-16
                                   lg:h-20">
                        <span class="text-right text-red-500 text-3xl w-1/5 h-auto leading-none">★</span>
                        <span class="text-center text-xl text-red-500 font-bold uppercase w-3/5 h-auto">difficile</span>
                        <span class="text-left text-red-500 text-3xl w-1/5 h-auto">★</span>
                    </footer>
                </article>
                <aside class="bg-primary-brown rounded-xl pt-2 border-2 border-primary-orange w-4/5 mx-auto mt-4
                              lg:w-full lg:mx-0">
                    <h3 class="text-2xl font-semibold text-center text-primary-orange pt-2
                               lg:text-3xl">Informations</h3>
                    <hr class="my-6 bg-primary-orange h-0.5 border-none w-full mx-auto">
                 
                    <dl class="space-y-4
                               lg:px-12 flex-grow lg:space-y-8">
                        <div class="flex flex-col lg:flex-row items-center lg:items-start">
                            <dt class="font-semibold text-2xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Source :</dt>
                            <dd class="text-2xl text-primary-white text-center">Butin</dd>
                            <hr class="my-6 bg-primary-orange h-0.5 border-none w-2/5 mx-auto
                                       lg:hidden">
                        </div>
                        <div class="flex flex-col lg:flex-row items-center lg:items-start">
                            <dt class="font-semibold text-2xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Chance :</dt>
                            <dd class="text-2xl text-primary-white text-center">0,1 %</dd>
                            <hr class="my-6 bg-primary-orange h-0.5 border-none w-4/5 mx-auto
                                       lg:hidden">
                        </div>
                        <div class="flex flex-col lg:flex-row items-center lg:items-start">
                            <dt class="font-semibold text-2xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Extension :</dt>
                            <dd class="text-2xl text-primary-white text-center">Battle For Azeroth</dd>
                            <hr class="my-6 bg-primary-orange h-0.5 border-none w-2/5 mx-auto
                                       lg:hidden">
                        </div>
                        <div class="flex flex-col lg:flex-row items-center lg:items-start">
                            <dt class="font-semibold text-2xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Zone :</dt>
                            <dd class="text-2xl text-primary-white text-center">Vol'dun</dd>
                            <hr class="my-6 bg-primary-orange h-0.5 border-none w-4/5 mx-auto
                                       lg:hidden">
                        </div>
                        <div class="flex flex-col lg:flex-row items-center lg:items-start mb-4">
                            <dt class="font-semibold text-2xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Cible :</dt>
                            <dd class="text-2xl text-primary-white text-center">Sephraks</dd>
                        </div>
                    </dl>
            
                <hr class="bg-primary-orange h-0.5 border-none w-full mx-auto">
                <footer class="flex justify-center items-center h-16
                               lg:h-20">
                    <i class="ph ph-user text-primary-orange text-5xl"></i>
                </footer>
            </aside>
        </div>
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
</body>
</html>