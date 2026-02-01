<?php ?>

<?php include 'retrieveExpansions.php';?>
<?php include 'retrieveFactions.php';?>
<?php include 'retrieveSources.php';?>
<?php include 'retrieveTypes.php';?>
<?php include 'retrieveAllMounts.php';?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="assets/js/modal.js" defer></script>
    <script src="assets/js/burger-menu.js" defer></script>
    <script src="assets/js/wishlist-heart.js" defer></script>
    <script src="assets/js/card-clic.js" defer></script>
    <script src="assets/js/collection-filter-toggle.js" defer></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Liste des montures</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <main class="min-h-screen bg-[url(../images/lava_cave_mobile.jpg)] bg-cover bg-center
                 lg:bg-[url(../images/lava_cave.jpg)] text-primary-white font-sans p-4 md:p-10">
        <div class="max-w-7xl mx-auto">
    
            <h1 class="text-2xl md:text-3xl font-bold mb-6">Liste des montures</h1>

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div class="flex items-center gap-2 w-full md:max-w-md">
                    <div class="relative flex-grow h-10">
                        <span class="absolute inset-y-0 left-3 flex items-center text-primary-orange">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" placeholder="Rechercher une monture" class="w-full h-full bg-primary-brown border border-primary-orange rounded-md py-2 pl-10 pr-4 focus:outline-none focus:border-primary-orange italic text-sm">
                    </div>
                    <button class="md:hidden bg-primary-brown/80 border border-primary-orange p-2 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                    </button>
                </div>
                <div class="hidden md:flex items-center max-w-sm">
                    <div id="status-container" class="group relative flex items-center w-48 h-10 p-1.5 max-w-xs bg-primary-brown/60 border border-primary-orange rounded-lg cursor-pointer transition-all duration-500 mx-auto group-[.is-off]:border-zinc-600">
    
                        <div class="flex-1 flex items-center justify-center border-r border-primary-orange z-10">
                            <span id="status-text" class="uppercase font-bold text-primary-white transition-opacity duration-500 text-[0.65rem] tracking-widest group-[.is-off]:opacity-50">
                                Acquis
                            </span>
                        </div>

                        <div class="flex-1 h-full relative flex items-center justify-end">
                            <div id="toggle-btn" class="w-10 h-full bg-primary-orange rounded-lg shadow-[0_0_15px_rgba(249,177,98,0.4)] transition-all duration-500 ease-in-out group-[.is-off]:-translate-x-full group-[.is-off]:bg-zinc-600 group-[.is-off]:shadow-none">
                            </div>
                        </div>
                    </div> 
                </div>
            </div>

        <div class="hidden md:flex relative flex-wrap gap-12 mb-8 p-4 bg-primary-black/40 backdrop-blur-md border-t border-b border-t-primary-orange border-b-primary-orange z-[200]">
            
            <!-- Menu déroulant filtres types -->
            <div class="relative group flex-1">
                <button class="w-full bg-primary-brown/60 border border-primary-orange rounded-lg px-4 py-2 text-sm flex items-center justify-between hover:border-none hover:bg-primary-orange hover:text-primary-black transition-colors">
                    <span>Type</span>
                    <i class="ph-caret-down text-primary-orange group-hover:text-primary-black transition-colors"></i>
                </button>
                <div class="hidden absolute top-full left-0 w-full bg-primary-black border border-primary-orange mt-1 z-[100] p-2 shadow-2xl rounded-lg pointer-events-auto z-[100]">
                    <?php 
                        foreach ($types as $type) {
                            echo '<label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="type" value="'.$type["type"].'" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">'.$type["type"].'</span>
                    </label>';
                        }
                    ?>
                </div>
            </div>
            <!-- Menu déroulant filtres sources -->
            <div class="relative group flex-1">
                <button class="w-full bg-primary-brown/60 border border-primary-orange rounded-lg px-4 py-2 text-sm flex items-center justify-between hover:border-none hover:bg-primary-orange hover:text-primary-black transition-colors">
                    <span>Source</span>
                    <i class="ph-caret-down text-primary-orange group-hover:text-primary-black transition-colors"></i>
                </button>
                <div class="hidden absolute top-full left-0 w-full bg-primary-black border border-primary-orange mt-1 p-2 shadow-2xl rounded-lg pointer-events-auto z-[100]">
                    <?php 
                        foreach ($sources as $source) {
                            echo '<label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="source" value="'.$source["source"].'" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">'.$source["source"].'</span>
                    </label>';
                        }
                    ?>
                </div>
            </div>
            <!-- Menu déroulant filtres extensions -->
            <div class="relative group flex-1">
                <button class="w-full bg-primary-brown/60 border border-primary-orange rounded-lg px-4 py-2 text-sm flex items-center justify-between hover:border-none hover:bg-primary-orange hover:text-primary-black transition-colors">
                    <span>Extension</span>
                    <i class="ph-caret-down text-primary-orange group-hover:text-primary-black transition-colors"></i>
                </button>
                <div class="hidden absolute top-full left-0 w-full bg-primary-black border border-primary-orange mt-1 z-50 p-2 shadow-2xl rounded-lg">
                    <?php 
                        foreach ($expansions as $expansion) {
                            echo '<label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="expansion" value="'.$expansion["expansion"].'" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">'.$expansion["expansion"].'</span>
                    </label>';
                        }
                    ?>
                </div>
            </div>
            <!-- Menu déroulant filtres factions -->
            <div class="relative group flex-1">
                <button class="w-full bg-primary-brown/60 border border-primary-orange rounded-lg px-4 py-2 text-sm flex items-center justify-between hover:border-none hover:bg-primary-orange hover:text-primary-black transition-colors">
                    <span>Faction</span>
                    <i class="ph-caret-down text-primary-orange group-hover:text-primary-black transition-colors"></i>
                </button>
                <div class="hidden absolute top-full left-0 w-full bg-primary-black border border-primary-orange mt-1 z-50 p-2 shadow-2xl rounded-lg">
                    <?php 
                        foreach ($factions as $faction) {
                            echo '<label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="faction" value="'.$faction["faction"].'" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">'.$faction["faction"].'</span>
                    </label>';
                        }
                    ?>
                </div>
            </div>
        </div>

        <div id="active-filters-zone" class="flex flex-wrap items-center gap-3 mb-6">
            <span class="text-xs uppercase text-primary-orange/60 font-bold tracking-widest">Filtres actifs :</span>
    
            <div class="flex items-center gap-2 bg-primary-orange/10 border border-primary-orange/40 px-3 py-1 rounded-full group hover:border-primary-orange transition-all">
                <span class="text-xs text-primary-white">Extension: Dragonflight</span>
                <button class="text-primary-orange hover:text-white transition-colors">
                    <i class="ph-x-circle-bold"></i> </button>
            </div>

            <button class="text-xs text-zinc-500 hover:text-primary-orange underline underline-offset-4">Tout effacer</button>
        </div>

        <div class="flex flex-wrap -mx-3">
            <?php // Foreach ici pour parcourir les montures ($mounts) et à chaque monture faire un echo de tout le HTML d'une carte.?>
            <!-- CARTE 1 -->

            <?php 
            foreach ($mounts as $mount) {
                $difficultyColor = '';
                switch ($mount['difficulty']) {
                    case 'Argent Réel':
                        $difficultyColor = 'text-cyan-400';
                        break;
                    case 'Facile':
                        $difficultyColor = 'text-green-500';;
                        break;
                    case 'Moyen':
                        $difficultyColor = 'text-orange-500';
                        break;
                    case 'Difficile':
                        $difficultyColor = 'text-red-500';
                        break;
                }

                echo('<div class="w-full sm:w-1/2 lg:w-1/3 xl:w-1/4 px-3 mb-6 mount-item flex justify-center">
                <article data-statut="obtenu" data-type="'.$mount['type'].'" data-source="Vendeur" data-expansion="World of Warcraft" data-faction="Alliance" class="mount-card max-w-[380px] w-full h-full bg-primary-black border-2 border-primary-orange rounded-xl overflow-hidden flex flex-col hover:border-green-500 transition-all group shadow-2xl">
                    <div class="relative p-6 flex-grow flex flex-col items-center">
                        <span class="absolute top-4 left-4">
                            <img src="assets/images/mounts/'.$mount['type'].'.png" alt="Icône de type '.$mount['type'].'" class="w-12 h-12">
                        </span>
                        <button class="wishlist-btn group absolute top-4 right-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 transition-all duration-300
                            text-red-600 stroke-current fill-transparent group-[.is-favorite]:text-red-600 group-[.is-favorite]:fill-current" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </button>
                        <img src="'.$mount['image'].'" alt="Image de '.$mount['name'].'" class="w-full h-48 object-contain mt-12 transition-transform">
                        <h2 class="text-xs font-black uppercase text-center mt-auto tracking-widest">'.$mount['name'].'</h2>
                    </div>
                    <div class="bg-black border-t border-primary-orange py-3 flex items-center justify-center gap-2">
                        <span class="'.$difficultyColor.' text-lg">★</span>
                        <span class="'.$difficultyColor.' text-sm font-bold uppercase tracking-[0.2em]">'.$mount['difficulty'].'</span>
                        <span class="'.$difficultyColor.' text-lg">★</span>
                    </div>
                </article>
            </div>');
            }
            ?>

            <div class="w-full flex justify-center mt-12 mb-8">
                <nav class="flex items-center gap-2 md:gap-3" aria-label="Pagination">
        
                    <!-- <a href="#" class="flex items-center justify-center w-10 h-10 md:w-12 md:h-12 bg-primary-black border-2 border-primary-orange/70 rounded-xl text-primary-white hover:border-primary-orange transition-all group"> 
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>-->

                    <a href="#" class="flex items-center justify-center w-10 h-10 md:w-12 md:h-12 bg-primary-black border-2 border-primary-orange rounded-xl text-primary-white font-black text-lg md:text-xl shadow-[0_0_15px_rgba(249,115,22,0.4)]">
                        1
                    </a>

                    <a href="#" class="flex items-center justify-center w-10 h-10 md:w-12 md:h-12 bg-primary-black border-2 border-primary-orange/40 rounded-xl text-primary-white font-black text-lg md:text-xl hover:border-primary-orange transition-all">
                        2
                    </a>

                    <div class="flex items-end gap-1 px-1 h-10 md:h-12 pb-2">
                        <span class="w-2 h-2 bg-primary-orange/40 rounded-full"></span>
                        <span class="w-2 h-2 bg-primary-orange/40 rounded-full"></span>
                        <span class="w-2 h-2 bg-primary-orange/40 rounded-full"></span>
                    </div>

                    <a href="#" class="flex items-center justify-center w-10 h-10 md:w-12 md:h-12 bg-primary-black border-2 border-primary-orange/40 rounded-xl text-primary-white font-black text-lg md:text-xl hover:border-primary-orange transition-all">
                    15
                    </a>

                    <a href="#" class="flex items-center justify-center w-10 h-10 md:w-12 md:h-12 bg-primary-black border-2 border-primary-orange/40 rounded-xl text-primary-white hover:border-primary-orange transition-all group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                </nav>
            </div>

        </div>
    </div>
</main>

    <?php include 'components/footer.php'; ?>
    <?php include 'components/modals.php'; ?>

</body>
</html>