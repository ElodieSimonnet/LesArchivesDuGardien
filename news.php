<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="./script.js" defer></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Nouveautés</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    
    <main class="min-h-screen bg-[url(../images/lava_cave_mobile.jpg)] bg-cover bg-center
                 lg:bg-[url(../images/lava_cave.jpg)] text-primary-white font-sans p-4 md:p-10">
        <section class="max-w-6xl mx-auto mt-8 lg:mt-16">
        
        <div class="border-2 border-primary-orange rounded-xl p-3 mb-8 lg:mb-12 bg-black/40 backdrop-blur-sm">
            <h2 class="text-center uppercase tracking-[0.2em] font-bold text-primary-orange text-base md:text-2xl">
                Dernières Nouvelles World of Warcraft
            </h2>
        </div>

        <div class="relative flex items-center group">
            
            <button class="hidden lg:flex absolute -left-8 z-10 bg-primary-brown border-2 border-primary-orange p-3 rounded-lg text-primary-orange hover:bg-primary-orange hover:text-primary-black transition-all shadow-[0_0_15px_rgba(255,165,0,0.3)]" aria-label="Précédent">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <article class="bg-primary-brown border-2 border-primary-orange rounded-xl overflow-hidden shadow-2xl flex flex-col lg:flex-row w-full backdrop-blur-md">
                
                <figure class="w-full lg:w-1/2 p-4 lg:p-6 flex-shrink-0">
                    <div class="overflow-hidden rounded-xl border border-zinc-800 h-80 sm:h-96 lg:h-full w-full relative">
                        <img src="assets/images/housing.jpg" alt="Aperçu du système de Logis" class="absolute inset-0 w-full h-full object-cover hover:scale-105 transition-transform duration-500 block">
                    </div>
                </figure>
                <div class="px-8 lg:px-0 lg:py-6">
                    <hr class="border-primary-orange border-t lg:border-t-0 lg:border-l lg:h-full">
                </div>
                <div class="p-6 lg:p-10 flex flex-col justify-between lg:w-[55%]">
                    <div>
                        <header>
                            <h3 class="text-primary-orange hover:text-yellow-300 transition-colors font-black uppercase text-xl lg:text-2xl leading-tight mb-2">
                               <a href="#">
                                    MIDNIGHT : <span>guide complet du Logis</span>
                                </a>
                            </h3>   
                        </header>

                        <div class="text-zinc-300 text-base lg:text-lg leading-relaxed space-y-6 mt-4">
                            <p>
                                Le Logis, <span class="text-primary-orange font-semibold">21 ans</span> après le lancement de World of Warcraft, arrive dans 
                                <span class="text-white italic">The War Within</span> avec un accès anticipé dès le 3 décembre en Europe.
                            </p>
                            <p>
                                Ce nouveau système pose enfin les bases d'un vrai logement personnel dans WoW, entre terrain à aménager, bâtiments à construire et nombreuses options décoratives.
                            </p>
                            <p>
                                Ce guide vous accompagne pas à pas, du premier accès à votre nid douillet jusqu'aux fonctionnalités avancées.
                            </p>
                        </div>
                    </div>

                    <footer class="mt-8 pt-6 border-t border-zinc-800/50 flex justify-center">
                        <p class="text-primary-orange/90 text-sm lg:text-base italic">
                            Publié aujourd'hui à 16:53 par <span class="font-bold uppercase tracking-wide text-primary-white">Zora</span>
                        </p>
                    </footer>
                </div>
            </article>

            <button class="hidden lg:flex absolute -right-8 z-10 bg-primary-brown border-2 border-primary-orange p-3 rounded-lg text-primary-orange hover:bg-primary-orange hover:text-primary-black transition-all shadow-[0_0_15px_rgba(255,165,0,0.3)]" aria-label="Suivant">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </section>
    <div class="w-full flex justify-center mt-12 mb-8 lg:hidden">
        <nav class="flex items-center gap-2 md:gap-3" aria-label="Pagination">
        
            <!-- <a href="#" aria-label="Page précédente" class="flex items-center justify-center w-10 h-10 md:w-12 md:h-12 bg-primary-brown border-2 border-primary-orange/70 rounded-xl text-primary-white"> 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>-->

                <a href="#" aria-current="page" class="flex items-center justify-center w-10 h-10 md:w-12 md:h-12 bg-primary-brown border-2 border-primary-orange rounded-xl text-primary-white font-black text-lg md:text-xl">
                    1
                </a>

                <a href="#" class="flex items-center justify-center w-10 h-10 md:w-12 md:h-12 bg-primary-brown border-2 border-primary-orange/40 rounded-xl text-primary-white font-black text-lg md:text-xl">
                    2
                </a>

                <div class="flex items-end gap-1 px-1 h-10 md:h-12 pb-2">
                    <span class="w-2 h-2 bg-primary-orange/40 rounded-full"></span>
                    <span class="w-2 h-2 bg-primary-orange/40 rounded-full"></span>
                    <span class="w-2 h-2 bg-primary-orange/40 rounded-full"></span>
                </div>

                <a href="#" class="flex items-center justify-center w-10 h-10 md:w-12 md:h-12 bg-primary-brown border-2 border-primary-orange/40 rounded-xl text-primary-white font-black text-lg md:text-xl">
                    15
                </a>

                <a href="#" aria-label="Page suivante" class="flex items-center justify-center w-10 h-10 md:w-12 md:h-12 bg-primary-brown border-2 border-primary-orange/40 rounded-xl text-primary-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

        </nav>
    </div>
</main>

    <?php include 'components/footer.php'; ?>
    <?php include 'components/modals.php'; ?>

</body>
</html>   
