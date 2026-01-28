<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="assets/js/modal.js" defer></script>
    <script src="assets/js/burger-menu.js" defer></script>
    <script src="assets/js/faq-accordion.js" defer></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>F.A.Q</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <main class="min-h-screen bg-[url(../images/lava_cave_mobile.jpg)] bg-cover bg-center bg-fixed
                 lg:bg-[url(../images/lava_cave.jpg)] text-primary-white font-sans p-4 md:p-10">
        <section class="max-w-4xl mx-auto">
            <header class="border-2 border-primary-orange bg-primary-brown rounded-lg p-4 mb-8 text-center shadow-lg">
                <h1 class="text-2xl md:text-4xl font-bold uppercase tracking-widest text-primary-orange">
                    Foire aux Questions
                </h1>
            </header>

            <dl class="space-y-4">
            
                <div class="group border-2 border-primary-orange rounded-lg overflow-hidden shadow-xl transition-all duration-300">
                    <dt>
                        <button type="button"aria-expanded="false" aria-controls="faq-content-1"class="faq-trigger w-full flex justify-between items-center p-4 text-left bg-primary-brown hover:brightness-110 focus:outline-none focus-visible:ring-4 focus-visible:ring-inset focus-visible:ring-primary-orange transition-all duration-300">
                            <span class="text-base md:text-lg font-semibold text-primary-orange pr-4 transition-colors duration-300 group-[.is-active]:text-primary-black">
                                Q. Quel est le but de ce site ?
                            </span>
                            <svg class="arrow-icon w-6 h-6 text-primary-orange group-[.is-active]:text-primary-black transition-transform duration-300 flex-shrink-0" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </dt>
                    <dd id="faq-content-1"role="region" class="faq-content max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-primary-brown">
                        <div class="p-4 text-primary-white leading-relaxed text-sm md:text-base">
                           R. Ce site a pour objectif de répertorier de manière exhaustive les montures, mascottes de combat et apparences  de World of Warcraft. Les filtres permettent de trouver facilement ce que le joueur cherche. Notre but est d'aider les collectionneurs à suivre leur progression et à découvrir de nouveaux objets. 
                        </div>
                    </dd>
                </div>

                <div class="group border-2 border-primary-orange rounded-lg overflow-hidden shadow-xl transition-all duration-300">
                    <dt>
                        <button type="button"aria-expanded="false" aria-controls="faq-content-2"class="faq-trigger w-full flex justify-between items-center p-4 text-left bg-primary-brown hover:brightness-110 focus:outline-none focus-visible:ring-4 focus-visible:ring-inset focus-visible:ring-primary-orange transition-all duration-300">
                            <span class="text-base md:text-lg font-semibold text-primary-orange pr-4 transition-colors duration-300 group-[.is-active]:text-primary-black">
                                Q. A quelle fréquence les données sont-elles mises à jour ?
                            </span>
                            <svg class="arrow-icon w-6 h-6 text-primary-orange group-[.is-active]:text-primary-black transition-transform duration-300 flex-shrink-0" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </dt>
                    <dd id="faq-content-2"role="region" class="faq-content max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-primary-brown">
                        <div class="p-4 text-primary-white leading-relaxed text-sm md:text-base">
                           R. Nous nous efforçons de mettre à jour les données aussitôt que possible après chaque patch majeur ou mineur de WoW, et généralement quelques jours après la sortie sur les serveurs Live. 
                        </div>
                    </dd>
                </div>

                <div class="group border-2 border-primary-orange rounded-lg overflow-hidden shadow-xl transition-all duration-300">
                    <dt>
                        <button type="button"aria-expanded="false" aria-controls="faq-content-3"class="faq-trigger w-full flex justify-between items-center p-4 text-left bg-primary-brown hover:brightness-110 focus:outline-none focus-visible:ring-4 focus-visible:ring-inset focus-visible:ring-primary-orange transition-all duration-300">
                            <span class="text-base md:text-lg font-semibold text-primary-orange pr-4 transition-colors duration-300 group-[.is-active]:text-primary-black">
                                Q. Quels sont les principaux critères de filtrage disponibles ?
                            </span>
                            <svg class="arrow-icon w-6 h-6 text-primary-orange group-[.is-active]:text-primary-black transition-transform duration-300 flex-shrink-0" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </dt>
                    <dd id="faq-content-3"role="region" class="faq-content max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-primary-brown">
                        <div class="p-4 text-primary-white leading-relaxed text-sm md:text-base">
                           R. Vous pouvez filtrer par type (monture, mascotte, apparences), source (raid, donjon, quête, vendeur, métier, haut fait, etc.), extension, faction (horde/alliance/neutre), et plus encore ! 
                        </div>
                    </dd>
                </div>

                
                <div class="group border-2 border-primary-orange rounded-lg overflow-hidden shadow-xl transition-all duration-300">
                    <dt>
                        <button type="button"aria-expanded="false" aria-controls="faq-content-4"class="faq-trigger w-full flex justify-between items-center p-4 text-left bg-primary-brown hover:brightness-110 focus:outline-none focus-visible:ring-4 focus-visible:ring-inset focus-visible:ring-primary-orange transition-all duration-300">
                            <span class="text-base md:text-lg font-semibold text-primary-orange pr-4 transition-colors duration-300 group-[.is-active]:text-primary-black">
                                Q. Puis-je utiliser le site sur mobile pendant que je joue ?
                            </span>
                            <svg class="arrow-icon w-6 h-6 text-primary-orange group-[.is-active]:text-primary-black transition-transform duration-300 flex-shrink-0" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </dt>
                    <dd id="faq-content-4"role="region" class="faq-content max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-primary-brown">
                        <div class="p-4 text-primary-white leading-relaxed text-sm md:text-base">
                           R. Absolument. Notre interface est entièrement "responsive". Vous pouvez garder votre téléphone ou votre tablette à côté de votre clavier pour consulter les sources de butin et cocher vos objets obtenus en temps réel sans avoir à faire de Alt-Tab. 
                        </div>
                    </dd>
                </div>

                <div class="group border-2 border-primary-orange rounded-lg overflow-hidden shadow-xl transition-all duration-300">
                    <dt>
                        <button type="button"aria-expanded="false" aria-controls="faq-content-5"class="faq-trigger w-full flex justify-between items-center p-4 text-left bg-primary-brown hover:brightness-110 focus:outline-none focus-visible:ring-4 focus-visible:ring-inset focus-visible:ring-primary-orange transition-all duration-300">
                            <span class="text-base md:text-lg font-semibold text-primary-orange pr-4 transition-colors duration-300 group-[.is-active]:text-primary-black">
                                Q. Prenez-vous en compte les mascottes de combat et leurs niveaux ?
                            </span>
                            <svg class="arrow-icon w-6 h-6 text-primary-orange group-[.is-active]:text-primary-black transition-transform duration-300 flex-shrink-0" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </dt>
                    <dd id="faq-content-5"role="region" class="faq-content max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-primary-brown">
                        <div class="p-4 text-primary-white leading-relaxed text-sm md:text-base">
                           R. Nous listons toutes les mascottes de combat du jeu. Pour l'instant, nous nous concentrons sur l'aspect "collection" (possédé ou non). La gestion détaillée des niveaux et des statistiques de combat est prévue pour une future mise à jour. 
                        </div>
                    </dd>
                </div>

                <div class="group border-2 border-primary-orange rounded-lg overflow-hidden shadow-xl transition-all duration-300">
                    <dt>
                        <button type="button"aria-expanded="false" aria-controls="faq-content-6"class="faq-trigger w-full flex justify-between items-center p-4 text-left bg-primary-brown hover:brightness-110 focus:outline-none focus-visible:ring-4 focus-visible:ring-inset focus-visible:ring-primary-orange transition-all duration-300">
                            <span class="text-base md:text-lg font-semibold text-primary-orange pr-4 transition-colors duration-300 group-[.is-active]:text-primary-black">
                                Q. Est-il possible de synchroniser automatiquement ma collection avec mon compte de jeu ?
                            </span>
                            <svg class="arrow-icon w-6 h-6 text-primary-orange group-[.is-active]:text-primary-black transition-transform duration-300 flex-shrink-0" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </dt>
                    <dd id="faq-content-6"role="region" class="faq-content max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-primary-brown">
                        <div class="p-4 text-primary-white leading-relaxed text-sm md:text-base">
                           R. Oui, tout à fait ! Nous avons conçu le site pour vous éviter la saisie manuelle. En connectant votre compte via le système sécurisé de Blizzard, le site scanne instantanément vos montures, mascottes et apparences débloquées pour mettre à jour votre profil en quelques secondes.
                        </div>
                    </dd>
                </div>

                <div class="group border-2 border-primary-orange rounded-lg overflow-hidden shadow-xl transition-all duration-300">
                    <dt>
                        <button type="button"aria-expanded="false" aria-controls="faq-content-7"class="faq-trigger w-full flex justify-between items-center p-4 text-left bg-primary-brown hover:brightness-110 focus:outline-none focus-visible:ring-4 focus-visible:ring-inset focus-visible:ring-primary-orange transition-all duration-300">
                            <span class="text-base md:text-lg font-semibold text-primary-orange pr-4 transition-colors duration-300 group-[.is-active]:text-primary-black">
                                Q. Comment puis-je lancer la synchronisation de mes données ?
                            </span>
                            <svg class="arrow-icon w-6 h-6 text-primary-orange group-[.is-active]:text-primary-black transition-transform duration-300 flex-shrink-0" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </dt>
                    <dd id="faq-content-7"role="region" class="faq-content max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-primary-brown">
                        <div class="p-4 text-primary-white leading-relaxed text-sm md:text-base">
                           R. Une fois votre compte créé, rendez-vous sur votre Tableau de Bord et cliquez sur le bouton "Synchroniser avec Battle.net". Vous serez redirigé vers le portail officiel de Blizzard pour valider l'accès en lecture. Une fois l'autorisation donnée, vous reviendrez ici et votre collection sera intégralement à jour.
                        </div>
                    </dd>
                </div>
            </dl>
        </section>
    </main>
    <?php include 'components/footer.php'; ?>
    <?php include 'components/modals.php'; ?>
</body>
</html>