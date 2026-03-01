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
    <script src="assets/js/toggle-collection.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="assets/css/output.css" rel="stylesheet">
    <title>Montures | Les Archives du Gardien</title>
    <meta name="description" content="Parcourez la liste complète des montures World of Warcraft. Filtrez par type, source, extension et faction pour retrouver vos montures.">
</head>
<body>
    <?php include 'components/header.php'; ?>
    
   <main id="main-content" class="min-h-screen bg-[url(../images/lava_cave_mob.webp)] bg-cover bg-center md:bg-[url(../images/lava_cave_without_f2_tab.webp)] lg:bg-[url(../images/lava_cave_without_f2.webp)] text-primary-white font-sans p-4 md:p-10">
    <div class="max-w-7xl mx-auto">
        
        <h1 class="text-2xl md:text-3xl font-bold mb-6 text-center">Liste des montures</h1>

        <div class="flex flex-col items-center mb-8 w-full gap-4">
            
            <div class="w-full flex items-center justify-center gap-2">
                <div class="relative w-full max-w-3xl h-12"> <span class="absolute inset-y-0 left-3 flex items-center text-primary-orange">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <label for="search-input" class="sr-only">Rechercher une monture</label>
                    <input type="text" id="search-input"
                           placeholder="Rechercher une monture par son nom"
                           class="w-full h-full bg-primary-brown border border-primary-orange rounded-md py-2 pl-10 pr-4 focus:outline-none focus:border-primary-orange italic text-sm text-white transition-all">
                </div>

                <button id="mobile-filter-trigger" aria-label="Ouvrir les filtres" class="md:hidden flex items-center justify-center h-12 px-3 bg-primary-brown/80 border border-primary-orange rounded-md transition-transform active:scale-95 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                </button>
            </div>

<div id="active-filters-zone" class="mb-6 w-full min-h-[40px] flex items-center">
    <div id="active-filters-content" class="hidden mx-auto md:mx-0 w-full">
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
                <?php if (isset($_SESSION['user_id'])): ?>
                <div class="relative flex-1 dropdown-container">
                    <button class="dropdown-button w-full bg-primary-brown border border-primary-orange rounded-lg px-4 py-2 text-sm flex items-center justify-between hover:bg-primary-orange hover:text-primary-black transition-colors group" aria-expanded="false" aria-haspopup="listbox">
                        <span id="current-status-label" class="truncate">Statut : Toutes</span>
                        <i class="ph-caret-down text-primary-orange transition-transform duration-300 pointer-events-none group-hover:text-primary-black"></i>
                    </button>
                    <div class="dropdown-content hidden absolute top-full left-0 w-full bg-primary-brown border border-primary-orange mt-1 z-[100] p-2 shadow-2xl rounded-lg">
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
                <?php endif; ?>

                <?php 
                $filterGroups = [
                    ['label' => 'Type', 'data' => $types, 'key' => 'type'],
                    ['label' => 'Source', 'data' => $sources, 'key' => 'source'],
                    ['label' => 'Extension', 'data' => $expansions, 'key' => 'expansion'],
                    ['label' => 'Faction', 'data' => $factions, 'key' => 'faction']
                ];
                foreach ($filterGroups as $group): ?>
                <div class="relative flex-1 dropdown-container">
                    <button class="dropdown-button w-full bg-primary-brown border border-primary-orange rounded-lg px-4 py-2 text-sm flex items-center justify-between hover:bg-primary-orange hover:text-primary-black transition-colors group" aria-expanded="false" aria-haspopup="listbox">
                        <span class="truncate"><?= $group['label'] ?></span>
                        <i class="ph-caret-down text-primary-orange transition-transform duration-300 pointer-events-none group-hover:text-primary-black"></i>
                    </button>
                    <div class="dropdown-content hidden absolute top-full left-0 w-full bg-primary-brown border border-primary-orange mt-1 z-[100] p-2 shadow-2xl rounded-lg overflow-y-auto max-h-60 custom-scrollbar">
                        <?php foreach ($group['data'] as $item): ?>
                            <label class="flex items-center w-full gap-3 p-2 hover:bg-primary-orange/10 cursor-pointer rounded">
                                <input type="checkbox" data-filter="<?= htmlspecialchars($group['key'], ENT_QUOTES, 'UTF-8') ?>" value="<?= htmlspecialchars($item[$group['key']], ENT_QUOTES, 'UTF-8') ?>" class="filter-checkbox accent-primary-orange w-4 h-4">
                                <span class="text-sm"><?= htmlspecialchars($item[$group['key']], ENT_QUOTES, 'UTF-8') ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 min-w-full">
                <?php 
                    foreach ($mounts as $mount) {
                        $difficultyColor = ''; $hoverColor = '';
                        switch (strtolower($mount['difficulty'])) {
                            case 'argent réel': $difficultyColor = 'text-cyan-400'; $hoverColor = 'hover:border-cyan-400'; break;
                            case 'facile':      $difficultyColor = 'text-green-500'; $hoverColor = 'hover:border-green-500'; break;
                            case 'moyen':       $difficultyColor = 'text-orange-500'; $hoverColor = 'hover:border-orange-500'; break;
                            case 'difficile':    $difficultyColor = 'text-red-500'; $hoverColor = 'hover:border-red-500'; break;
                            default:            $difficultyColor = 'text-a11y-gray'; $hoverColor = 'hover:border-gray-400'; break;
                        }

                        $statusValue = $mount['is_owned'] ? '1' : '0';

                        $eName = htmlspecialchars($mount['name'], ENT_QUOTES, 'UTF-8');
                        $eType = htmlspecialchars($mount['type'], ENT_QUOTES, 'UTF-8');
                        $eSource = htmlspecialchars($mount['source'], ENT_QUOTES, 'UTF-8');
                        $eExpansion = htmlspecialchars($mount['expansion'], ENT_QUOTES, 'UTF-8');
                        $eFaction = htmlspecialchars($mount['faction'], ENT_QUOTES, 'UTF-8');
                        $eImage = htmlspecialchars($mount['image'], ENT_QUOTES, 'UTF-8');
                        $eDifficulty = htmlspecialchars($mount['difficulty'], ENT_QUOTES, 'UTF-8');

                        $wishlistBtn = isset($_SESSION['user_id'])
                            ? '<button class="wishlist-btn group absolute top-4 right-4 z-10 ' . ($mount['is_wishlisted'] ? 'is-favorite' : '') . '" data-type="mount" data-id="' . $mount['id'] . '" data-csrf="' . $_SESSION['csrf_token'] . '" aria-label="' . ($mount['is_wishlisted'] ? 'Retirer ' . $eName . ' des favoris' : 'Ajouter ' . $eName . ' aux favoris') . '" aria-pressed="' . ($mount['is_wishlisted'] ? 'true' : 'false') . '"><svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 transition-all duration-300 text-red-600 stroke-current fill-transparent group-[.is-favorite]:text-red-600 group-[.is-favorite]:fill-current" viewBox="0 0 24 24" stroke-width="2"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></button>'
                            : '';

                        echo('
                        <li class="mount-item relative flex flex-col">
                            '.$wishlistBtn.'
                            <a href="mount_detail.php?id='.$mount['id'].'"
                                    data-owned="'.$statusValue.'"
                                    data-type="'.$eType.'"
                                    data-source="'.$eSource.'"
                                    data-expansion="'.$eExpansion.'"
                                    data-faction="'.$eFaction.'"
                                    aria-label="Voir la fiche de '.$eName.'"
                                    class="mount-card w-full h-full bg-[oklch(0.23_0.0316_24.1)] border-2 border-primary-orange rounded-xl overflow-hidden flex flex-col '.$hoverColor.' transition-all duration-300 group shadow-2xl '.(isset($_SESSION['user_id']) && !$mount['is_owned'] ? 'sepia hover:sepia-0' : '').'">

                                <div class="relative p-6 flex-grow flex flex-col items-center">
                                    <span class="absolute top-4 left-4"><img src="assets/images/mounts/'.$eType.'.webp" alt="Icône '.$eType.'" class="w-12 h-12" loading="lazy"></span>
                                    <img src="'.$eImage.'" alt="'.$eName.'" class="w-full h-48 object-contain mt-12 transition-transform group-hover:scale-105" loading="lazy">
                                    <h2 class="text-xs font-black uppercase text-center mt-auto tracking-widest text-white">'.$eName.'</h2>
                                </div>

                                <div class="bg-[oklch(0.23_0.0316_24.1)] border-t border-primary-orange py-3 flex items-center justify-center gap-2 relative">
                                    <span class="'.$difficultyColor.' text-lg">★</span>
                                    <span class="'.$difficultyColor.' text-sm font-bold uppercase tracking-[0.2em]">'.$eDifficulty.'</span>
                                    <span class="'.$difficultyColor.' text-lg">★</span>'
                                    .(isset($_SESSION['user_id']) ? '<span class="lock-badge absolute right-3 inset-y-0 flex items-center text-a11y-gray'.($mount['is_owned'] ? ' hidden' : '').'" aria-hidden="true"><i class="ph ph-lock-simple text-base"></i></span>' : '').'
                                </div>
                            </a>'
                            . (isset($_SESSION['user_id']) ? '
                            <button class="collection-toggle-btn w-full mt-2 py-2 flex items-center justify-center gap-2 rounded-xl border-2 font-bold uppercase text-xs tracking-widest transition-all duration-300 cursor-pointer bg-primary-brown '.($mount['is_owned'] ? 'is-owned border-primary-orange bg-primary-orange text-primary-black' : 'border-primary-orange text-primary-orange hover:bg-primary-orange hover:text-primary-black').'"
                                    data-type="mount" data-id="'.$mount['id'].'" data-csrf="'.$_SESSION['csrf_token'].'"
                                    aria-label="'.($mount['is_owned'] ? $eName.' - déjà obtenue' : 'Ajouter '.$eName.' à ma collection').'"
                                    aria-pressed="'.($mount['is_owned'] ? 'true' : 'false').'"
                                    >
                                <svg class="w-4 h-4 collection-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="'.($mount['is_owned'] ? 'M5 13l4 4L19 7' : 'M12 4v16m8-8H4').'" />
                                </svg>
                                <span class="collection-label">'.($mount['is_owned'] ? 'Obtenue' : 'Ajouter').'</span>
                            </button>' : '').'
                        </li>');
                    }
                ?>
            </ul>

            <div id="load-more-container" class="w-full flex flex-col items-center mt-12 mb-8 gap-4">
                <p id="load-more-count" class="w-full max-w-sm text-center text-sm text-primary-orange font-bold uppercase tracking-widest bg-primary-brown border border-primary-orange rounded-xl px-4 py-3 whitespace-nowrap"></p>
                <button id="load-more-btn" class="w-full max-w-sm text-center bg-primary-brown border border-primary-orange rounded-xl px-4 py-3 text-primary-white font-bold uppercase tracking-widest hover:bg-primary-orange hover:text-primary-black transition-all duration-300 shadow-[0_0_15px_rgba(249,115,22,0.2)]">
                    Charger plus
                </button>
            </div>

        </div>
    </main>

    <?php include 'components/footer.php'; ?>
    <?php include 'components/modals.php'; ?>
    <?php include 'components/filters-menu-mobile.php'; ?>
    <script>
        // Gestion aria-expanded sur les dropdowns de filtres
        document.querySelectorAll('.dropdown-button').forEach(btn => {
            btn.addEventListener('click', function() {
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', isExpanded ? 'false' : 'true');
            });
        });
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown-container')) {
                document.querySelectorAll('.dropdown-button[aria-expanded="true"]').forEach(btn => {
                    btn.setAttribute('aria-expanded', 'false');
                });
            }
        });
    </script>
</body>
</html>