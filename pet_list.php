<?php include 'retrieveExpansions.php';?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/phosphor-icons"></script>
    <script src="assets/js/modal.js" defer></script>
    <script src="assets/js/wishlist-heart.js" defer></script>
    <script src="assets/js/collection-filter-toggle.js" defer></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Liste des mascottes</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <main class="min-h-screen bg-[url(../images/lava_cave_mobile.jpg)] bg-cover bg-center
                 lg:bg-[url(../images/lava_cave.jpg)] text-primary-white font-sans p-4 md:p-10">
        <div class="max-w-7xl mx-auto">
    
            <h1 class="text-2xl md:text-3xl font-bold mb-6">Liste des mascottes</h1>

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div class="flex items-center gap-2 w-full md:max-w-md">
                    <div class="relative flex-grow h-10">
                        <span class="absolute inset-y-0 left-3 flex items-center text-primary-orange">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" placeholder="Rechercher une mascotte" class="w-full h-full bg-primary-brown border border-primary-orange rounded-md py-2 pl-10 pr-4 focus:outline-none focus:border-primary-orange italic text-sm">
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
                            <span id="status-text" class="italic font-bold text-primary-white transition-opacity duration-500 text-xs tracking-tighter group-[.is-off]:opacity-50">
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
            
            <!-- Menu déroulant filtres familles -->
            <div class="relative group flex-1">
                <button class="w-full bg-primary-brown/60 border border-primary-orange rounded-lg px-4 py-2 text-sm flex items-center justify-between hover:border-none hover:bg-primary-orange hover:text-primary-black transition-colors">
                    <span>Famille</span>
                    <i class="ph-caret-down text-primary-orange group-hover:text-primary-black transition-colors"></i>
                </button>
                <div class="hidden absolute top-full left-0 w-full bg-primary-black border border-primary-orange mt-1 z-[100] p-2 shadow-2xl rounded-lg pointer-events-auto z-[100]">
                    <label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="type" value="terrestre" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">Humanoïde</span>
                    </label>
                    <label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="type" value="volante" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">Draconien</span>
                    </label>
                    <label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="type" value="aquatique" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">Aérien</span>
                    </label>
                    <label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="type" value="aquatique" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">Mort-vivant</span>
                    </label>
                    <label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="type" value="aquatique" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">Bestiole</span>
                    </label>
                    <label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="type" value="aquatique" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">Magique</span>
                    </label>
                    <label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="type" value="aquatique" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">Elémentaire</span>
                    </label>
                    <label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="type" value="aquatique" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">Bête</span>
                    </label>
                    <label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="type" value="aquatique" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">Aquatique</span>
                    </label>
                    <label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="type" value="aquatique" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">Machine</span>
                    </label>
                </div>
            </div>
            <!-- Menu déroulant filtres sources -->
            <div class="relative group flex-1">
                <button class="w-full bg-primary-brown/60 border border-primary-orange rounded-lg px-4 py-2 text-sm flex items-center justify-between hover:border-none hover:bg-primary-orange hover:text-primary-black transition-colors">
                    <span>Source</span>
                    <i class="ph-caret-down text-primary-orange group-hover:text-primary-black transition-colors"></i>
                </button>
                <div class="hidden absolute top-full left-0 w-full bg-primary-black border border-primary-orange mt-1 p-2 shadow-2xl rounded-lg pointer-events-auto z-[100]">
                    <label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="source" value="Butin" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">Butin</span>
                    </label>
                    <label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="source" value="Vendeur" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">Vendeur</span>
                    </label>
                    <label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="source" value="Quête" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">Quête</span>
                    </label>
                    <label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="source" value="Haut-fait" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">Haut-fait</span>
                    </label>
                    <label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="source" value="Métier" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">Métier</span>
                    </label>
                    <label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="source" value="Boutique" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">Boutique</span>
                    </label>
                    <label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="source" value="Comptoir" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">Comptoir</span>
                    </label>
                    <label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="source" value="Donjon" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">Donjon</span>
                    </label>
                    <label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="source" value="Raid" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">Raid</span>
                    </label>
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
                    <label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="faction" value="Alliance" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">Alliance</span>
                    </label>
                    <label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="faction" value="Horde" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">Horde</span>
                    </label>
                    <label class="flex items-center gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                        <input type="checkbox" data-filter="faction" value="Neutre" class="filter-checkbox accent-primary-orange w-4 h-4">
                        <span class="text-sm">Neutre</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap -mx-3">
            
            <!-- CARTE 1, corgi du magma -->
            <div class="w-full sm:w-1/2 lg:w-1/4 px-3 mb-6">
                <article class="h-full bg-primary-black border-2 border-primary-orange rounded-xl overflow-hidden flex flex-col transition-all group shadow-2xl">
                    <div class="relative p-6 flex-grow flex flex-col items-center">
                        <span class="absolute top-4 left-4">
                            <img src="assets/images/pets/elem.png" alt="Icône de mascotte élémentaire" class="w-12 h-12">
                        </span>
                        <button class="wishlist-btn group absolute top-4 right-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 transition-all duration-300
                            text-red-600 stroke-current fill-transparent group-[.is-favorite]:text-red-600 group-[.is-favorite]:fill-current" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </button>
                        <img src="assets/images/pets/corgidumagma.png" alt="Corgi du magma" class="w-full h-48 object-contain mt-12 group-hover:scale-110 transition-transform">
                    </div>
                    <div class="bg-black border-t border-primary-orange py-3 flex items-center justify-center gap-2">
                        
                        <h2 class="text-sm font-black text-primary-white uppercase text-center mt-auto tracking-widest">Corgi du magma</h2>
                        
                    </div>
                </article>
            </div>

            <!-- CARTE 2, tortois -->
            <div class="w-full sm:w-1/2 lg:w-1/4 px-3 mb-6">
                <article class="h-full bg-primary-black border-2 border-primary-orange rounded-xl overflow-hidden flex flex-col transition-all group shadow-2xl">
                    <div class="relative p-6 flex-grow flex flex-col items-center">
                        <span class="absolute top-4 left-4">
                            <img src="assets/images/pets/aquatic.png" alt="Icône de mascotte aquatique" class="w-12 h-12">
                        </span>
                        <button class="absolute top-4 right-4 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        </button>
                        <img src="assets/images/pets/tortois.png" alt="Tortois" class="w-full h-48 object-contain mt-12 group-hover:scale-110 transition-transform">
                    </div>
                    <div class="bg-black border-t border-primary-orange py-3 flex items-center justify-center gap-2">
                
                        <h2 class="text-sm font-black text-primary-white uppercase text-center mt-auto tracking-widest">Tortois</h2>
                        
                    </div>
                </article>
            </div>

           <!-- CARTE 3, plumot -->
            <div class="w-full sm:w-1/2 lg:w-1/4 px-3 mb-6">
                <article class="h-full bg-primary-black border-2 border-primary-orange rounded-xl overflow-hidden flex flex-col transition-all group shadow-2xl">
                    <div class="relative p-6 flex-grow flex flex-col items-center">
                        <span class="absolute top-4 left-4">
                            <img src="assets/images/pets/humanoid.png" alt="Icône de mascotte humanoïde" class="w-12 h-12">
                        </span>
                        <button class="absolute top-4 right-4 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        </button>
                        <img src="assets/images/pets/plumot.png" alt="Plumot" class="w-full h-48 object-contain mt-12 group-hover:scale-110 transition-transform">
                    </div>
                    <div class="bg-black border-t border-primary-orange py-3 flex items-center justify-center gap-2">
                
                        <h2 class="text-sm font-black text-primary-white uppercase text-center mt-auto tracking-widest">Plumot</h2>
                        
                    </div>
                </article>
            </div>

            
            <!-- CARTE 4, bleudou -->
            <div class="w-full sm:w-1/2 lg:w-1/4 px-3 mb-6">
                <article class="h-full bg-primary-black border-2 border-primary-orange rounded-xl overflow-hidden flex flex-col transition-all group shadow-2xl">
                    <div class="relative p-6 flex-grow flex flex-col items-center">
                        <span class="absolute top-4 left-4">
                            <img src="assets/images/pets/magic.png" alt="Icône de mascotte magique" class="w-12 h-12">
                        </span>
                        <button class="absolute top-4 right-4 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        </button>
                        <img src="assets/images/pets/bleudou.png" alt="Bleudou" class="w-full h-48 object-contain mt-12 group-hover:scale-110 transition-transform">
                    </div>
                    <div class="bg-black border-t border-primary-orange py-3 flex items-center justify-center gap-2">
                
                        <h2 class="text-sm font-black text-primary-white uppercase text-center mt-auto tracking-widest">Bleudou</h2>
                        
                    </div>
                </article>
            </div>

            <!-- CARTE 5, p'tit bling bling -->
            <div class="w-full sm:w-1/2 lg:w-1/4 px-3 mb-6">
                <article class="h-full bg-primary-black border-2 border-primary-orange rounded-xl overflow-hidden flex flex-col transition-all group shadow-2xl">
                    <div class="relative p-6 flex-grow flex flex-col items-center">
                        <span class="absolute top-4 left-4">
                            <img src="assets/images/pets/mechanical.png" alt="Icône de mascotte mécanique" class="w-12 h-12">
                        </span>
                        <button class="absolute top-4 right-4 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        </button>
                        <img src="assets/images/pets/ptitblingbling.png" alt="P'tit Bling-Bling" class="w-full h-48 object-contain mt-12 group-hover:scale-110 transition-transform">
                    </div>
                    <div class="bg-black border-t border-primary-orange py-3 flex items-center justify-center gap-2">
                
                        <h2 class="text-sm font-black text-primary-white uppercase text-center mt-auto tracking-widest">P'tit Bling-Bling</h2>
                        
                    </div>
                </article>
            </div>

           <!-- CARTE 6, miimii -->
            <div class="w-full sm:w-1/2 lg:w-1/4 px-3 mb-6">
                <article class="h-full bg-primary-black border-2 border-primary-orange rounded-xl overflow-hidden flex flex-col transition-all group shadow-2xl">
                    <div class="relative p-6 flex-grow flex flex-col items-center">
                        <span class="absolute top-4 left-4">
                            <img src="assets/images/pets/undead.png" alt="Icône de mascotte mort-vivant" class="w-12 h-12">
                        </span>
                        <button class="absolute top-4 right-4 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        </button>
                        <img src="assets/images/pets/miimii.png" alt="Miimii" class="w-full h-48 object-contain mt-12 group-hover:scale-110 transition-transform">
                    </div>
                    <div class="bg-black border-t border-primary-orange py-3 flex items-center justify-center gap-2">
                
                        <h2 class="text-sm font-black text-primary-white uppercase text-center mt-auto tracking-widest">Miimii</h2>
                        
                    </div>
                </article>
            </div>

           <!-- CARTE 7, tobias -->
            <div class="w-full sm:w-1/2 lg:w-1/4 px-3 mb-6">
                <article class="h-full bg-primary-black border-2 border-primary-orange rounded-xl overflow-hidden flex flex-col transition-all group shadow-2xl">
                    <div class="relative p-6 flex-grow flex flex-col items-center">
                        <span class="absolute top-4 left-4">
                            <img src="assets/images/pets/beast.png" alt="Icône de mascotte bête" class="w-12 h-12">
                        </span>
                        <button class="absolute top-4 right-4 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        </button>
                        <img src="assets/images/pets/tobias.png" alt="Tobias" class="w-full h-48 object-contain mt-12 group-hover:scale-110 transition-transform">
                    </div>
                    <div class="bg-black border-t border-primary-orange py-3 flex items-center justify-center gap-2">
                
                        <h2 class="text-sm font-black text-primary-white uppercase text-center mt-auto tracking-widest">Tobias</h2>
                        
                    </div>
                </article>
            </div>
            
            <!-- CARTE 8, aquamouche chatoyante -->
            <div class="w-full sm:w-1/2 lg:w-1/4 px-3 mb-6">
                <article class="h-full bg-primary-black border-2 border-primary-orange rounded-xl overflow-hidden flex flex-col transition-all group shadow-2xl">
                    <div class="relative p-6 flex-grow flex flex-col items-center">
                        <span class="absolute top-4 left-4">
                            <img src="assets/images/pets/flying.png" alt="Icône de mascotte volante" class="w-12 h-12">
                        </span>
                        <button class="absolute top-4 right-4 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        </button>
                        <img src="assets/images/pets/aquamouchechatoyante.png" alt="Aquamouche chatoyante" class="w-full h-48 object-contain mt-12 group-hover:scale-110 transition-transform">
                    </div>
                    <div class="bg-black border-t border-primary-orange py-3 flex items-center justify-center gap-2">
                
                        <h2 class="text-sm font-black text-primary-white uppercase text-center mt-auto tracking-widest">Aquamouche chatoyante</h2>
                        
                    </div>
                </article>
            </div>

            <!-- CARTE 9, genévrier -->
            <div class="w-full sm:w-1/2 lg:w-1/4 px-3 mb-6">
                <article class="h-full bg-primary-black border-2 border-primary-orange rounded-xl overflow-hidden flex flex-col transition-all group shadow-2xl">
                    <div class="relative p-6 flex-grow flex flex-col items-center">
                        <span class="absolute top-4 left-4">
                            <img src="assets/images/pets/critter.png" alt="Icône de mascotte bestiole" class="w-12 h-12">
                        </span>
                        <button class="absolute top-4 right-4 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        </button>
                        <img src="assets/images/pets/genevrier.png" alt="Genévrier" class="w-full h-48 object-contain mt-12 group-hover:scale-110 transition-transform">
                    </div>
                    <div class="bg-black border-t border-primary-orange py-3 flex items-center justify-center gap-2">
                
                        <h2 class="text-sm font-black text-primary-white uppercase text-center mt-auto tracking-widest">Genévrier</h2>
                        
                    </div>
                </article>
            </div>

            <!-- CARTE 10, mini tarecgosa -->
            <div class="w-full sm:w-1/2 lg:w-1/4 px-3 mb-6">
                <article class="h-full bg-primary-black border-2 border-primary-orange rounded-xl overflow-hidden flex flex-col transition-all group shadow-2xl">
                    <div class="relative p-6 flex-grow flex flex-col items-center">
                        <span class="absolute top-4 left-4">
                            <img src="assets/images/pets/dragonkin.png" alt="Icône de mascotte draconien" class="w-12 h-12">
                        </span>
                        <button class="absolute top-4 right-4 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        </button>
                        <img src="assets/images/pets/minitarecgosa.png" alt="Mini Tarecgosa" class="w-full h-48 object-contain mt-12 group-hover:scale-110 transition-transform">
                    </div>
                    <div class="bg-black border-t border-primary-orange py-3 flex items-center justify-center gap-2">
                
                        <h2 class="text-sm font-black text-primary-white uppercase text-center mt-auto tracking-widest">Mini Tarecgosa</h2>
                        
                    </div>
                </article>
            </div>

            <!-- CARTE 11, esprit du feu pandaren -->
            <div class="w-full sm:w-1/2 lg:w-1/4 px-3 mb-6">
                <article class="h-full bg-primary-black border-2 border-primary-orange rounded-xl overflow-hidden flex flex-col transition-all group shadow-2xl">
                    <div class="relative p-6 flex-grow flex flex-col items-center">
                        <span class="absolute top-4 left-4">
                            <img src="assets/images/pets/elem.png" alt="Icône de mascotte élémentaire" class="w-12 h-12">
                        </span>
                        <button class="absolute top-4 right-4 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        </button>
                        <img src="assets/images/pets/espritdufeupandaren.png" alt="Aquamouche chatoyante" class="w-full h-48 object-contain mt-12 group-hover:scale-110 transition-transform">
                    </div>
                    <div class="bg-black border-t border-primary-orange py-3 flex items-center justify-center gap-2">
                
                        <h2 class="text-sm font-black text-primary-white uppercase text-center mt-auto tracking-widest">Esprit du feu pandaren</h2>
                        
                    </div>
                </article>
            </div>

            <!-- CARTE 12, mini abominus -->
            <div class="w-full sm:w-1/2 lg:w-1/4 px-3 mb-6">
                <article class="h-full bg-primary-black border-2 border-primary-orange rounded-xl overflow-hidden flex flex-col transition-all group shadow-2xl">
                    <div class="relative p-6 flex-grow flex flex-col items-center">
                        <span class="absolute top-4 left-4">
                            <img src="assets/images/pets/humanoid.png" alt="Icône de mascotte humanoïde" class="w-12 h-12">
                        </span>
                        <button class="absolute top-4 right-4 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        </button>
                        <img src="assets/images/pets/miniabominus.png" alt="Mini Abominus" class="w-full h-48 object-contain mt-12 group-hover:scale-110 transition-transform">
                    </div>
                    <div class="bg-black border-t border-primary-orange py-3 flex items-center justify-center gap-2">
                
                        <h2 class="text-sm font-black text-primary-white uppercase text-center mt-auto tracking-widest">Mini Abominus</h2>
                        
                    </div>
                </article>
            </div>

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