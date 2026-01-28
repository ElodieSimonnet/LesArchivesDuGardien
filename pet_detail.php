<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="assets/js/modal.js" defer></script>
    <script src="assets/js/burger-menu.js" defer></script>
    <script src="assets/js/wishlist-heart.js" defer></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Détails des mascottes</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <main class="bg-[url(../images/lava_cave_mobile.jpg)] bg-cover bg-center pt-16 pb-36
                 lg:bg-[url(../images/lava_cave.jpg)]">
        <div class="lg:max-w-5xl lg:mx-auto px-4 lg:px-12">
            <section class="bg-primary-brown rounded-xl border-2 border-primary-orange w-4/5 mx-auto
                            lg:w-full mb-8">
                <h1 class="text-xl font-semibold text-center uppercase text-primary-orange pt-4
                       md:text-3xl">corgi du magma
                </h1>
                <p class="text-lg font-semibold text-justify text-primary-white p-4
                      lg:text-xl">Il adore surveiller les troupeaux de diablotins, batifoler dans la lave et recevoir des gratouilles des seigneurs élémentaires.
                </p>
            </section>
        
            <div class="lg:grid lg:grid-cols-2 lg:gap-12">
                <article class="relative bg-primary-brown rounded-xl border-2 border-primary-orange w-4/5 mx-auto mt-4 
                                lg:w-full lg:mx-0 flex flex-col">
            
                    <header class="flex px-4 py-2">
                        <img src="assets/images/pets/elem.png" alt="logo de mascotte élémentaire" class="w-20 h-auto pt-1">
                        <button class="wishlist-btn group absolute top-4 right-4 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 transition-all duration-300
                            text-red-600 stroke-current fill-transparent group-[.is-favorite]:text-red-600 group-[.is-favorite]:fill-current" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </button>
                    </header>

                    <div class="flex flex-col justify-center items-center flex-grow">
                        <img src="assets/images/pets/corgidumagma.png" alt="Image du Corgi du magma" class="w-3/5 h-auto">
                    </div>

                    <hr class="bg-primary-orange h-0.5 border-none w-full mx-auto">

                    <footer class="flex justify-center items-center h-16
                                   lg:h-20">
                        <h2 class="text-center text-xl text-primary-orange font-bold uppercase w-3/5 h-auto">Corgi du magma</h2>
                    </footer>
                </article>
                <aside class="bg-primary-brown rounded-xl pt-2 border-2 border-primary-orange w-4/5 mx-auto mt-4
                              lg:w-full lg:mx-0">
                    <h3 class="text-2xl font-semibold text-center text-primary-orange pt-2
                               lg:text-3xl">Informations</h3>
                    <hr class="my-6 bg-primary-orange h-0.5 border-none w-full mx-auto">
                 
                    <dl class="space-y-4
                               lg:px-12 flex-grow lg:space-y-6">
                        <div class="flex flex-col lg:flex-row items-center lg:items-start mt-8">
                            <dt class="font-semibold text-xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Source :</dt>
                            <dd class="text-xl text-primary-white text-center">Haut-Fait</dd>
                            <hr class="my-6 bg-primary-orange h-0.5 border-none w-2/5 mx-auto
                                       lg:hidden">
                        </div>
                        <div class="flex flex-col lg:flex-row items-center lg:items-start">
                            <dt class="font-semibold text-xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Vendeur :</dt>
                            <dd class="text-xl text-primary-white text-center">Commerçant Réginald</dd>
                            <hr class="my-6 bg-primary-orange h-0.5 border-none w-4/5 mx-auto
                                       lg:hidden">
                        </div>
                        <div class="flex flex-col lg:flex-row items-center lg:items-start">
                            <dt class="font-semibold text-xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Prix :</dt>
                            <dd class="text-xl text-primary-white text-center">100 insignes distordus</dd>
                            <hr class="my-6 bg-primary-orange h-0.5 border-none w-2/5 mx-auto
                                       lg:hidden">
                        </div>
                        <div class="flex flex-col lg:flex-row items-center lg:items-start">
                            <dt class="font-semibold text-xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Chance :</dt>
                            <dd class="text-xl text-primary-white text-center">N/A</dd>
                            <hr class="my-6 bg-primary-orange h-0.5 border-none w-4/5 mx-auto
                                       lg:hidden">
                        </div>
                        <div class="flex flex-col lg:flex-row items-center lg:items-start">
                            <dt class="font-semibold text-xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Extension :</dt>
                            <dd class="text-xl text-primary-white text-center">Warlords of Draenor</dd>
                            <hr class="my-6 bg-primary-orange h-0.5 border-none w-2/5 mx-auto
                                       lg:hidden">
                        </div>
                        <div class="flex flex-col lg:flex-row items-center lg:items-start mb-8">
                            <dt class="font-semibold text-xl text-primary-orange text-center
                                       lg:text-left lg:w-2/5">Zone :</dt>
                            <dd class="text-xl text-primary-white text-center">Tanaris</dd>
                        </div>  
                    </dl>
                </aside>
            </div>
            
            <section class="mt-8 bg-primary-brown rounded-xl border-2 border-primary-orange w-4/5 mx-auto lg:w-full p-4 lg:p-6 shadow-xl" aria-label="Capacités de la mascotte">
                <h3 class="sr-only">Liste des sorts</h3> 
                <ul class="flex flex-wrap justify-around gap-3 md:gap-4 lg:gap-6">
                    <li class="relative group">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20 lg:w-24 lg:h-24 bg-black border-2 border-primary-orange rounded-lg 
                        flex items-center justify-center cursor-pointer hover:scale-110 hover:border-white transition-all duration-300 
                        shadow-inner overflow-hidden">
                
                            <img src="assets/images/pets/placeholder.png" alt="image du sort 1" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                
                            <div class="absolute inset-0 bg-primary-orange/10 opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity"></div>
                        </div>
                    </li>

                    <li class="relative group">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20 lg:w-24 lg:h-24 bg-black border-2 border-primary-orange rounded-lg flex items-center justify-center cursor-pointer hover:scale-110 hover:border-white transition-all duration-300 shadow-inner overflow-hidden">
                            <img src="assets/images/pets/placeholder.png" alt="image du sort 2" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                        </div>
                    </li>

                    <li class="relative group">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20 lg:w-24 lg:h-24 bg-black border-2 border-primary-orange rounded-lg flex items-center justify-center cursor-pointer hover:scale-110 hover:border-white transition-all duration-300 shadow-inner overflow-hidden">
                            <img src="assets/images/pets/placeholder.png" alt="image du sort 3" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                        </div>
                    </li>

                    <li class="relative group">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20 lg:w-24 lg:h-24 bg-black border-2 border-primary-orange rounded-lg flex items-center justify-center cursor-pointer hover:scale-110 hover:border-white transition-all duration-300 shadow-inner overflow-hidden">
                            <img src="assets/images/pets/placeholder.png" alt="image du sort 4" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                        </div>
                    </li>

                    <li class="relative group">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20 lg:w-24 lg:h-24 bg-black border-2 border-primary-orange rounded-lg flex items-center justify-center cursor-pointer hover:scale-110 hover:border-white transition-all duration-300 shadow-inner overflow-hidden">
                            <img src="assets/images/pets/placeholder.png" alt="image du sort 5" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                        </div>
                    </li>

                    <li class="relative group">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20 lg:w-24 lg:h-24 bg-black border-2 border-primary-orange rounded-lg flex items-center justify-center cursor-pointer hover:scale-110 hover:border-white transition-all duration-300 shadow-inner overflow-hidden">
                            <img src="assets/images/pets/placeholder.png" alt="image du sort 6" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                        </div>
                    </li>

                </ul>
            </section>
    </main>

    <?php include 'components/footer.php'; ?>
    <?php include 'components/modals.php'; ?>

</body>
</html>