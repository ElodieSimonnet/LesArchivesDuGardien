<div id="filter-mobile-overlay" class="fixed inset-0 bg-primary-black/80 backdrop-blur-sm z-[500] hidden md:hidden transition-opacity duration-300 opacity-0"></div>

<div id="filter-mobile-menu" class="fixed inset-y-0 right-0 z-[501] w-full md:hidden bg-primary-black transform translate-x-full transition-transform duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] flex flex-col border-l border-primary-orange shadow-2xl">

    <div class="flex justify-between items-center px-8 h-28 border-b border-primary-orange bg-primary-black shrink-0">
        <span class="text-primary-orange font-bold uppercase tracking-widest text-xl">Filtres</span>
        <button id="close-filters" class="text-primary-orange p-2 border-2 border-primary-orange rounded-xl hover:bg-primary-orange hover:text-primary-black transition-all">
            <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto px-6 py-8">

        <div class="space-y-4">
            <?php if (isset($_SESSION['user_id'])): ?>
            <div class="filter-section border border-primary-orange rounded-xl overflow-hidden bg-primary-brown/10">
                <button class="mobile-accordion-header active w-full px-6 py-5 flex justify-between items-center group">
                    <h3 class="text-primary-orange uppercase font-bold tracking-widest text-base flex items-center gap-3">
                        <i class="fas fa-eye"></i> État de collection
                    </h3>
                    <svg class="w-6 h-6 text-primary-orange transition-transform duration-300 pointer-events-none" style="transform: rotate(180deg);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="mobile-accordion-content px-6 pb-6 space-y-3">
                    <label class="flex items-center justify-between p-4 bg-amber-500/15 border-l-4 border-primary-orange rounded-r-lg cursor-pointer active:bg-amber-500/30 transition-all text-sm font-bold uppercase italic text-primary-white">
                        Toutes
                        <input type="radio" name="filter-status-mobile" value="all" checked class="status-radio-mobile accent-primary-orange w-6 h-6">
                    </label>
                    <label class="flex items-center justify-between p-4 bg-amber-500/15 border-l-4 border-primary-orange rounded-r-lg cursor-pointer active:bg-amber-500/30 transition-all text-sm font-bold uppercase italic text-primary-white">
                        Acquises
                        <input type="radio" name="filter-status-mobile" value="1" class="status-radio-mobile accent-primary-orange w-6 h-6">
                    </label>
                    <label class="flex items-center justify-between p-4 bg-amber-500/15 border-l-4 border-primary-orange rounded-r-lg cursor-pointer active:bg-amber-500/30 transition-all text-sm font-bold uppercase italic text-primary-white">
                        Manquantes
                        <input type="radio" name="filter-status-mobile" value="0" class="status-radio-mobile accent-primary-orange w-6 h-6">
                    </label>
                </div>
            </div>
            <?php endif; ?>

            <div class="filter-section border border-primary-orange rounded-xl overflow-hidden bg-primary-brown/10">
                <button class="mobile-accordion-header w-full px-6 py-5 flex justify-between items-center group">
                    <h3 class="text-primary-orange uppercase font-bold tracking-widest text-base flex items-center gap-3">
                        <i class="fas fa-paw"></i> Famille de mascotte
                    </h3>
                    <svg class="w-6 h-6 text-primary-orange transition-transform duration-300 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="mobile-accordion-content hidden px-6 pb-6 space-y-3">
                    <?php foreach ($families as $family): ?>
                        <label class="flex items-center justify-between p-4 bg-amber-500/15 border-l-4 border-primary-orange rounded-r-lg cursor-pointer active:bg-amber-500/30 transition-all text-sm font-bold uppercase italic text-primary-white">
                            <?= htmlspecialchars($family['family'], ENT_QUOTES, 'UTF-8') ?>
                            <input type="checkbox" data-filter="family" value="<?= htmlspecialchars($family['family'], ENT_QUOTES, 'UTF-8') ?>" class="filter-checkbox accent-primary-orange w-6 h-6">
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="filter-section border border-primary-orange rounded-xl overflow-hidden bg-primary-brown/10">
                <button class="mobile-accordion-header w-full px-6 py-5 flex justify-between items-center group">
                    <h3 class="text-primary-orange uppercase font-bold tracking-widest text-base flex items-center gap-3">
                        <i class="fas fa-map-marked-alt"></i> Source
                    </h3>
                    <svg class="w-6 h-6 text-primary-orange transition-transform duration-300 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="mobile-accordion-content hidden px-6 pb-6 space-y-3">
                    <?php foreach ($sources as $source): ?>
                        <label class="flex items-center justify-between p-4 bg-amber-500/15 border-l-4 border-primary-orange rounded-r-lg cursor-pointer active:bg-amber-500/30 transition-all text-sm font-bold uppercase italic text-primary-white">
                            <?= htmlspecialchars($source['source'], ENT_QUOTES, 'UTF-8') ?>
                            <input type="checkbox" data-filter="source" value="<?= htmlspecialchars($source['source'], ENT_QUOTES, 'UTF-8') ?>" class="filter-checkbox accent-primary-orange w-6 h-6">
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="filter-section border border-primary-orange rounded-xl overflow-hidden bg-primary-brown/10">
                <button class="mobile-accordion-header w-full px-6 py-5 flex justify-between items-center group">
                    <h3 class="text-primary-orange uppercase font-bold tracking-widest text-base flex items-center gap-3">
                        <i class="fas fa-history"></i> Extension
                    </h3>
                    <svg class="w-6 h-6 text-primary-orange transition-transform duration-300 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="mobile-accordion-content hidden px-6 pb-6 space-y-3">
                    <?php foreach ($expansions as $expansion): ?>
                        <label class="flex items-center justify-between p-4 bg-amber-500/15 border-l-4 border-primary-orange rounded-r-lg cursor-pointer active:bg-amber-500/30 transition-all text-sm font-bold uppercase italic text-primary-white">
                            <?= htmlspecialchars($expansion['expansion'], ENT_QUOTES, 'UTF-8') ?>
                            <input type="checkbox" data-filter="expansion" value="<?= htmlspecialchars($expansion['expansion'], ENT_QUOTES, 'UTF-8') ?>" class="filter-checkbox accent-primary-orange w-6 h-6">
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="filter-section border border-primary-orange rounded-xl overflow-hidden bg-primary-brown/10">
                <button class="mobile-accordion-header w-full px-6 py-5 flex justify-between items-center group">
                    <h3 class="text-primary-orange uppercase font-bold tracking-widest text-base flex items-center gap-3">
                        <i class="fas fa-flag"></i> Faction
                    </h3>
                    <svg class="w-6 h-6 text-primary-orange transition-transform duration-300 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="mobile-accordion-content hidden px-6 pb-6 space-y-3">
                    <?php foreach ($factions as $faction): ?>
                        <label class="flex items-center justify-between p-4 bg-amber-500/15 border-l-4 border-primary-orange rounded-r-lg cursor-pointer active:bg-amber-500/30 transition-all text-sm font-bold uppercase italic text-primary-white">
                            <?= htmlspecialchars($faction['faction'], ENT_QUOTES, 'UTF-8') ?>
                            <input type="checkbox" data-filter="faction" value="<?= htmlspecialchars($faction['faction'], ENT_QUOTES, 'UTF-8') ?>" class="filter-checkbox accent-primary-orange w-6 h-6">
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="pt-6 pb-12">
                <button id="apply-mobile-filters" class="w-full py-5 bg-primary-orange text-primary-black font-black uppercase tracking-[0.2em] rounded-xl shadow-[0_0_20px_rgba(249,115,22,0.3)] active:scale-95 transition-all text-lg">
                    Appliquer
                </button>
            </div>

        </div>
    </div>
</div>