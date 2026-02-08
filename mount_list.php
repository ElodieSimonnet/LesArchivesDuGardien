<?php require_once 'components/utils/db_connection.php'; ?>
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
    <script src="assets/js/filter-menu-mobile.js" defer></script>
    <script src="assets/js/collection-filter-toggle.js" defer></script>
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Liste des montures</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    
   <main class="min-h-screen bg-[url(../images/lava_cave_mobile.jpg)] bg-cover bg-center lg:bg-[url(../images/lava_cave.jpg)] text-primary-white font-sans p-4 md:p-10">
    <div class="max-w-7xl mx-auto">
        
        <h1 class="text-2xl md:text-3xl font-bold mb-6 text-center">Liste des montures</h1>

        <div class="flex flex-col items-center mb-8 w-full gap-4">
            
            <div class="w-full flex items-center justify-center gap-2">
                <div class="relative w-full max-w-3xl h-12"> <span class="absolute inset-y-0 left-3 flex items-center text-primary-orange">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" 
                           placeholder="Rechercher une monture par son nom" 
                           class="w-full h-full bg-primary-brown/60 border border-primary-orange rounded-md py-2 pl-10 pr-4 focus:outline-none focus:border-primary-orange italic text-sm text-white transition-all">
                </div>

                <button id="mobile-filter-trigger" class="md:hidden flex items-center justify-center h-12 px-3 bg-primary-brown/80 border border-primary-orange rounded-md transition-transform active:scale-95 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                </button>
            </div>

<div id="active-filters-zone" class="mb-6 w-full">
    <div class="mx-auto md:mx-0 w-full sm:max-w-none sm:grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <div class="col-span-full flex flex-wrap items-center gap-3">
            <span class="text-xs uppercase text-primary-orange/60 font-bold tracking-widest">Filtres actifs :</span>
            <div id="badges-dynamic-container" class="flex flex-wrap gap-2"></div>
            <button id="clear-all-filters" class="flex items-center gap-2 bg-primary-orange/10 border border-primary-orange/40 px-3 py-1 rounded-full group hover:border-primary-orange transition-all">
                <span class="text-[10px] md:text-xs text-primary-white uppercase font-bold tracking-tight">
                    Tout effacer
                </span>
                <div class="text-primary-orange group-hover:text-white transition-colors">
                   <i class="ph-x-circle-bold text-lg"></i> 
                </div>
            </button>
        </div>
    </div>
</div>

            <div class="hidden md:flex relative items-center w-full gap-4 mb-12 z-[200]">
                <div class="relative flex-1 dropdown-container">
                    <button class="dropdown-button w-full bg-primary-brown/60 border border-primary-orange rounded-lg px-4 py-2 text-sm flex items-center justify-between hover:bg-primary-orange hover:text-primary-black transition-colors group">
                        <span id="current-status-label" class="truncate">Statut : Toutes</span>
                        <i class="ph-caret-down text-primary-orange transition-transform duration-300 pointer-events-none group-hover:text-primary-black"></i>
                    </button>
                    <div class="dropdown-content hidden absolute top-full left-0 w-full bg-primary-black border border-primary-orange mt-1 z-[100] p-2 shadow-2xl rounded-lg">
                        <label class="flex items-center w-full gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                            <input type="radio" name="filter-status" value="all" checked class="status-radio accent-primary-orange w-4 h-4">
                            <span class="text-sm">Toutes</span>
                        </label>
                        <label class="flex items-center w-full gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                            <input type="radio" name="filter-status" value="1" class="status-radio accent-primary-orange w-4 h-4">
                            <span class="text-sm">Acquises</span>
                        </label>
                        <label class="flex items-center w-full gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                            <input type="radio" name="filter-status" value="0" class="status-radio accent-primary-orange w-4 h-4">
                            <span class="text-sm">Manquantes</span>
                        </label>
                    </div>
                </div>

                <?php 
                $filterGroups = [
                    ['label' => 'Type', 'data' => $types, 'key' => 'type'],
                    ['label' => 'Source', 'data' => $sources, 'key' => 'source'],
                    ['label' => 'Extension', 'data' => $expansions, 'key' => 'expansion'],
                    ['label' => 'Faction', 'data' => $factions, 'key' => 'faction']
                ];
                foreach ($filterGroups as $group): ?>
                <div class="relative flex-1 dropdown-container">
                    <button class="dropdown-button w-full bg-primary-brown/60 border border-primary-orange rounded-lg px-4 py-2 text-sm flex items-center justify-between hover:bg-primary-orange hover:text-primary-black transition-colors group">
                        <span class="truncate"><?= $group['label'] ?></span>
                        <i class="ph-caret-down text-primary-orange transition-transform duration-300 pointer-events-none group-hover:text-primary-black"></i>
                    </button>
                    <div class="dropdown-content hidden absolute top-full left-0 w-full bg-primary-black border border-primary-orange mt-1 z-[100] p-2 shadow-2xl rounded-lg overflow-y-auto max-h-60 custom-scrollbar">
                        <?php foreach ($group['data'] as $item): ?>
                            <label class="flex items-center w-full gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                                <input type="checkbox" data-filter="<?= $group['key'] ?>" value="<?= $item[$group['key']] ?>" class="filter-checkbox accent-primary-orange w-4 h-4">
                                <span class="text-sm"><?= $item[$group['key']] ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 min-w-full">
                <?php 
                    foreach ($mounts as $mount) {
                        $difficultyColor = ''; $hoverColor = '';
                        switch ($mount['difficulty']) {
                            case 'Argent Réel': $difficultyColor = 'text-cyan-400'; $hoverColor = 'hover:border-cyan-400'; break;
                            case 'Facile':      $difficultyColor = 'text-green-500'; $hoverColor = 'hover:border-green-500'; break;
                            case 'Moyen':       $difficultyColor = 'text-orange-500'; $hoverColor = 'hover:border-orange-500'; break;
                            case 'Difficile':    $difficultyColor = 'text-red-500'; $hoverColor = 'hover:border-red-500'; break;
                            default:            $difficultyColor = 'text-gray-400'; $hoverColor = 'hover:border-gray-400'; break;
                        }

                        $is_owned = ($mount['id'] % 2 == 0); 
                        $statusValue = $is_owned ? '1' : '0';

                        echo('
                        <div class="mount-item flex justify-center">
                            <article data-owned="'.$statusValue.'" 
                                    data-type="'.$mount['type'].'" 
                                    data-source="'.$mount['source'].'" 
                                    data-expansion="'.$mount['expansion'].'" 
                                    data-faction="'.$mount['faction'].'" 
                                    class="mount-card w-full h-full bg-primary-black border-2 border-primary-orange rounded-xl overflow-hidden flex flex-col '.$hoverColor.' transition-all duration-300 group shadow-2xl">
                                
                                <div class="relative p-6 flex-grow flex flex-col items-center">
                                    <span class="absolute top-4 left-4"><img src="assets/images/mounts/'.$mount['type'].'.png" class="w-12 h-12"></span>
                                    <button class="wishlist-btn group absolute top-4 right-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 transition-all duration-300 text-red-600 stroke-current fill-transparent group-[.is-favorite]:text-red-600 group-[.is-favorite]:fill-current" viewBox="0 0 24 24" stroke-width="2">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                    </button>
                                    <img src="'.$mount['image'].'" alt="'.$mount['name'].'" class="w-full h-48 object-contain mt-12 transition-transform group-hover:scale-105">
                                    <h2 class="text-xs font-black uppercase text-center mt-auto tracking-widest text-white">'.$mount['name'].'</h2>
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
            </div>

            <div class="w-full flex justify-center mt-12 mb-8">
                <nav class="flex items-center gap-2 md:gap-3" aria-label="Pagination">
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
    </main>

    <?php include 'components/footer.php'; ?>
    <?php include 'components/modals.php'; ?>
    <?php include 'components/filters-menu-mobile.php'; ?>
</body>
</html>