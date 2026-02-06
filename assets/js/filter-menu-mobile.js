/**
 * Gestion du menu de filtres mobile et synchronisation des radios
 */
document.addEventListener('DOMContentLoaded', () => {
    // Éléments du DOM
    const openBtn = document.getElementById('mobile-filter-trigger');
    const overlay = document.getElementById('filter-mobile-overlay');
    const menu = document.getElementById('filter-mobile-menu');
    const closeBtn = document.getElementById('close-filters');
    const applyBtn = document.getElementById('apply-mobile-filters');

    // Radios pour la synchronisation
    const desktopRadios = document.querySelectorAll('.status-radio');
    const mobileRadios = document.querySelectorAll('.status-radio-mobile');

    if (!openBtn || !menu || !overlay) return;

    // --- LOGIQUE D'OUVERTURE / FERMETURE ---

    const openMobileFilters = () => {
        overlay.classList.remove('hidden');
        setTimeout(() => {
            overlay.classList.replace('opacity-0', 'opacity-100');
            menu.classList.remove('translate-x-full');
        }, 10);
        document.body.style.overflow = 'hidden';
    };

    const closeMobileFilters = () => {
        menu.classList.add('translate-x-full');
        overlay.classList.replace('opacity-100', 'opacity-0');
        setTimeout(() => {
            overlay.classList.add('hidden');
        }, 500);
        document.body.style.overflow = '';
    };

    // --- LOGIQUE DE SYNCHRONISATION DES RADIOS ---

    function syncStatusFilters(value) {
        // Cocher le bon bouton sur Desktop
        desktopRadios.forEach(r => r.checked = (r.value === value));
        // Cocher le bon bouton sur Mobile
        mobileRadios.forEach(r => r.checked = (r.value === value));
        
        // Mettre à jour le texte du bouton dropdown Desktop si présent
        const label = document.getElementById('current-status-label');
        if (label) {
            const textMap = { 'all': 'Statut : Toutes', '1': 'Statut : Acquises', '0': 'Statut : Manquantes' };
            label.textContent = textMap[value];
        }

        // DÉCLENCHER LE FILTRAGE GLOBAL
        // Si tu as une fonction globale de filtrage (ex: filterMounts()), appelle-la ici :
        // if (typeof filterMounts === "function") filterMounts();
    }

    // Écouteurs d'événements
    openBtn.addEventListener('click', openMobileFilters);
    closeBtn?.addEventListener('click', closeMobileFilters);
    overlay.addEventListener('click', closeMobileFilters);
    applyBtn?.addEventListener('click', closeMobileFilters);

    // Synchronisation au changement Mobile
    mobileRadios.forEach(radio => {
        radio.addEventListener('change', (e) => syncStatusFilters(e.target.value));
    });

    // Synchronisation au changement Desktop
    desktopRadios.forEach(radio => {
        radio.addEventListener('change', (e) => syncStatusFilters(e.target.value));
    });
});