<?php
    $currentFamilies = isset($_GET['family']) ? (array) $_GET['family'] : [];
    $currentPetSources = isset($_GET['source']) ? (array) $_GET['source'] : [];
    $currentPetExpansions = isset($_GET['expansion']) ? (array) $_GET['expansion'] : [];
    $currentPetFactions = isset($_GET['faction']) ? (array) $_GET['faction'] : [];
?>

<div id="filter-mobile-overlay" class="fixed inset-0 bg-primary-black/80 backdrop-blur-sm z-[500] hidden opacity-0 transition-opacity duration-300" aria-hidden="true"></div>

<div id="filter-mobile-menu" role="dialog" aria-modal="true" aria-label="Filtres" aria-hidden="true" class="fixed z-[501] inset-0 m-auto w-[90%] md:w-[500px] h-[85vh] opacity-0 pointer-events-none transform translate-y-8
    transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)]
    flex flex-col border-2 border-primary-orange bg-primary-black shadow-2xl rounded-2xl">

    <div class="flex justify-between items-center px-8 h-24 border-b border-primary-orange bg-primary-black shrink-0 lg:rounded-t-2xl">
        <span class="text-primary-orange font-bold uppercase tracking-widest text-xl">Filtres</span>
        <button id="close-filters" class="text-primary-orange p-2 border-2 border-primary-orange rounded-xl hover:bg-primary-orange hover:text-primary-black transition-all" aria-label="Fermer les filtres">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto px-6 py-8">
        <form id="filterForm" class="space-y-4">

            <div class="filter-section border border-primary-orange rounded-xl overflow-hidden bg-primary-brown">
                <button type="button" class="mobile-accordion-header active w-full px-6 py-5 flex justify-between items-center group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-orange focus-visible:ring-inset">
                    <h3 class="text-primary-orange uppercase font-bold tracking-widest text-base flex items-center gap-3">Famille</h3>
                    <svg class="w-6 h-6 text-primary-orange transition-transform duration-300 pointer-events-none rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="mobile-accordion-content px-6 pb-6 space-y-3">
                    <label class="flex items-center justify-between p-4 bg-primary-orange/20 border-l-4 border-primary-orange rounded-r-lg cursor-pointer transition-all text-sm font-bold uppercase text-primary-orange">
                        Tout sélectionner
                        <input type="checkbox" class="select-all accent-primary-orange w-6 h-6">
                    </label>
                    <?php foreach ($all_families as $familyItem): ?>
                    <label class="flex items-center justify-between p-4 bg-amber-500/15 border-l-4 border-primary-orange rounded-r-lg cursor-pointer active:bg-amber-500/30 transition-all text-sm font-bold uppercase italic text-primary-white">
                        <?php echo htmlspecialchars($familyItem['family']); ?>
                        <input type="checkbox" name="family[]" value="<?php echo htmlspecialchars($familyItem['family']); ?>" <?php echo in_array(strtolower($familyItem['family']), array_map('strtolower', $currentFamilies)) ? 'checked' : ''; ?> class="filter-checkbox accent-primary-orange w-6 h-6">
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="filter-section border border-primary-orange rounded-xl overflow-hidden bg-primary-brown">
                <button type="button" class="mobile-accordion-header w-full px-6 py-5 flex justify-between items-center group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-orange focus-visible:ring-inset">
                    <h3 class="text-primary-orange uppercase font-bold tracking-widest text-base flex items-center gap-3">Source</h3>
                    <svg class="w-6 h-6 text-primary-orange transition-transform duration-300 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="mobile-accordion-content hidden px-6 pb-6 space-y-3">
                    <label class="flex items-center justify-between p-4 bg-primary-orange/20 border-l-4 border-primary-orange rounded-r-lg cursor-pointer transition-all text-sm font-bold uppercase text-primary-orange">
                        Tout sélectionner
                        <input type="checkbox" class="select-all accent-primary-orange w-6 h-6">
                    </label>
                    <?php foreach ($all_pet_sources as $sourceItem): ?>
                    <label class="flex items-center justify-between p-4 bg-amber-500/15 border-l-4 border-primary-orange rounded-r-lg cursor-pointer transition-all text-sm font-bold uppercase italic text-primary-white">
                        <?php echo htmlspecialchars($sourceItem['source']); ?>
                        <input type="checkbox" name="source[]" value="<?php echo htmlspecialchars($sourceItem['source']); ?>" <?php echo in_array(strtolower($sourceItem['source']), array_map('strtolower', $currentPetSources)) ? 'checked' : ''; ?> class="filter-checkbox accent-primary-orange w-6 h-6">
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="filter-section border border-primary-orange rounded-xl overflow-hidden bg-primary-brown">
                <button type="button" class="mobile-accordion-header w-full px-6 py-5 flex justify-between items-center group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-orange focus-visible:ring-inset">
                    <h3 class="text-primary-orange uppercase font-bold tracking-widest text-base flex items-center gap-3">Extension</h3>
                    <svg class="w-6 h-6 text-primary-orange transition-transform duration-300 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="mobile-accordion-content hidden px-6 pb-6 space-y-3">
                    <label class="flex items-center justify-between p-4 bg-primary-orange/20 border-l-4 border-primary-orange rounded-r-lg cursor-pointer transition-all text-sm font-bold uppercase text-primary-orange">
                        Tout sélectionner
                        <input type="checkbox" class="select-all accent-primary-orange w-6 h-6">
                    </label>
                    <?php foreach ($all_pet_expansions as $expansionItem): ?>
                    <label class="flex items-center justify-between p-4 bg-amber-500/15 border-l-4 border-primary-orange rounded-r-lg cursor-pointer transition-all text-sm font-bold uppercase italic text-primary-white">
                        <?php echo htmlspecialchars($expansionItem['expansion']); ?>
                        <input type="checkbox" name="expansion[]" value="<?php echo htmlspecialchars($expansionItem['expansion']); ?>" <?php echo in_array(strtolower($expansionItem['expansion']), array_map('strtolower', $currentPetExpansions)) ? 'checked' : ''; ?> class="filter-checkbox accent-primary-orange w-6 h-6">
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="filter-section border border-primary-orange rounded-xl overflow-hidden bg-primary-brown">
                <button type="button" class="mobile-accordion-header w-full px-6 py-5 flex justify-between items-center group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-orange focus-visible:ring-inset">
                    <h3 class="text-primary-orange uppercase font-bold tracking-widest text-base flex items-center gap-3">Faction</h3>
                    <svg class="w-6 h-6 text-primary-orange transition-transform duration-300 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="mobile-accordion-content hidden px-6 pb-6 space-y-3">
                    <label class="flex items-center justify-between p-4 bg-primary-orange/20 border-l-4 border-primary-orange rounded-r-lg cursor-pointer transition-all text-sm font-bold uppercase text-primary-orange">
                        Tout sélectionner
                        <input type="checkbox" class="select-all accent-primary-orange w-6 h-6">
                    </label>
                    <?php foreach ($all_pet_factions as $factionItem): ?>
                    <label class="flex items-center justify-between p-4 bg-amber-500/15 border-l-4 border-primary-orange rounded-r-lg cursor-pointer transition-all text-sm font-bold uppercase italic text-primary-white">
                        <?php echo htmlspecialchars($factionItem['faction']); ?>
                        <input type="checkbox" name="faction[]" value="<?php echo htmlspecialchars($factionItem['faction']); ?>" <?php echo in_array(strtolower($factionItem['faction']), array_map('strtolower', $currentPetFactions)) ? 'checked' : ''; ?> class="filter-checkbox accent-primary-orange w-6 h-6">
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="pt-6 pb-12">
                <button type="submit" class="w-full py-5 bg-primary-orange text-primary-black font-black uppercase tracking-[0.2em] rounded-xl shadow-[0_0_20px_rgba(249,115,22,0.3)] active:scale-95 transition-all text-lg">
                    Appliquer
                </button>
            </div>
        </form>
    </div>
</div>
