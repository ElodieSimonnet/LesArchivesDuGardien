<?php
    $currentStatus = isset($_GET['status']) ? $_GET['status'] : 'all';
    $currentRole = isset($_GET['role']) ? $_GET['role'] : 'all';
?>

<div id="filter-mobile-overlay" class="fixed inset-0 bg-primary-black/80 backdrop-blur-sm z-[500] hidden opacity-0 transition-opacity duration-300"></div>

<div id="filter-mobile-menu" class="fixed z-[501] inset-0 m-auto w-[90%] md:w-[500px] h-[85vh] opacity-0 pointer-events-none transform translate-y-8
    transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)]
    flex flex-col border-2 border-primary-orange bg-primary-black shadow-2xl rounded-2xl">


    <div class="flex justify-between items-center px-8 h-24 border-b border-primary-orange bg-primary-black shrink-0 lg:rounded-t-2xl">
        <span class="text-primary-orange font-bold uppercase tracking-widest text-xl">Filtres</span>
        <button id="close-filters" class="text-primary-orange p-2 border-2 border-primary-orange rounded-xl hover:bg-primary-orange hover:text-primary-black transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto px-6 py-8">
        <form id="filterForm" class="space-y-4">

            <div class="filter-section border border-primary-orange rounded-xl overflow-hidden bg-primary-brown">
                <button type="button" class="mobile-accordion-header active w-full px-6 py-5 flex justify-between items-center group">
                    <h3 class="text-primary-orange uppercase font-bold tracking-widest text-base flex items-center gap-3">
                        <i class="fas fa-user-shield"></i> Statut du compte
                    </h3>
                    <svg class="w-6 h-6 text-primary-orange transition-transform duration-300 pointer-events-none rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="mobile-accordion-content px-6 pb-6 space-y-3">
                    <label class="flex items-center justify-between p-4 bg-amber-500/15 border-l-4 border-primary-orange rounded-r-lg cursor-pointer active:bg-amber-500/30 transition-all text-sm font-bold uppercase italic text-primary-white">
                        Tous <input type="radio" name="status" value="all" <?php echo $currentStatus === 'all' ? 'checked' : ''; ?> class="accent-primary-orange w-6 h-6">
                    </label>
                    <label class="flex items-center justify-between p-4 bg-amber-500/15 border-l-4 border-primary-orange rounded-r-lg cursor-pointer active:bg-amber-500/30 transition-all text-sm font-bold uppercase italic text-primary-white">
                        Actifs <input type="radio" name="status" value="actif" <?php echo $currentStatus === 'actif' ? 'checked' : ''; ?> class="accent-primary-orange w-6 h-6">
                    </label>
                    <label class="flex items-center justify-between p-4 bg-amber-500/15 border-l-4 border-primary-orange rounded-r-lg cursor-pointer active:bg-amber-500/30 transition-all text-sm font-bold uppercase italic text-primary-white">
                        Suspendus <input type="radio" name="status" value="suspendu" <?php echo $currentStatus === 'suspendu' ? 'checked' : ''; ?> class="accent-primary-orange w-6 h-6">
                    </label>
                    <label class="flex items-center justify-between p-4 bg-amber-500/15 border-l-4 border-primary-orange rounded-r-lg cursor-pointer active:bg-amber-500/30 transition-all text-sm font-bold uppercase italic text-primary-white">
                        Bannis <input type="radio" name="status" value="banni" <?php echo $currentStatus === 'banni' ? 'checked' : ''; ?> class="accent-primary-orange w-6 h-6">
                    </label>
                </div>
            </div>

            <div class="filter-section border border-primary-orange rounded-xl overflow-hidden bg-primary-brown">
                <button type="button" class="mobile-accordion-header w-full px-6 py-5 flex justify-between items-center group">
                    <h3 class="text-primary-orange uppercase font-bold tracking-widest text-base flex items-center gap-3">
                        <i class="fas fa-crown"></i> Rôles
                    </h3>
                    <svg class="w-6 h-6 text-primary-orange transition-transform duration-300 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="mobile-accordion-content hidden px-6 pb-6 space-y-3">
                    <label class="flex items-center justify-between p-4 bg-amber-500/15 border-l-4 border-primary-orange rounded-r-lg cursor-pointer transition-all text-sm font-bold uppercase italic text-primary-white">
                        Tous les rôles <input type="radio" name="role" value="all" <?php echo $currentRole === 'all' ? 'checked' : ''; ?> class="accent-primary-orange w-6 h-6">
                    </label>

                    <label class="flex items-center justify-between p-4 bg-amber-500/15 border-l-4 border-primary-orange rounded-r-lg cursor-pointer transition-all text-sm font-bold uppercase italic text-primary-white">
                        Administrateur <input type="radio" name="role" value="admin" <?php echo $currentRole === 'admin' ? 'checked' : ''; ?> class="accent-primary-orange w-6 h-6">
                    </label>

                    <label class="flex items-center justify-between p-4 bg-amber-500/15 border-l-4 border-primary-orange rounded-r-lg cursor-pointer transition-all text-sm font-bold uppercase italic text-primary-white">
                        Utilisateur <input type="radio" name="role" value="user" <?php echo $currentRole === 'user' ? 'checked' : ''; ?> class="accent-primary-orange w-6 h-6">
                    </label>
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