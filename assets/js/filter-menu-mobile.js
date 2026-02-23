/**
 * Gestion du menu de filtres mobile et synchronisation des radios
 */
document.addEventListener('DOMContentLoaded', () => {
    const openBtn = document.getElementById('mobile-filter-trigger');
    const overlay = document.getElementById('filter-mobile-overlay');
    const menu = document.getElementById('filter-mobile-menu');
    const closeBtn = document.getElementById('close-filters');
    const applyBtn = document.getElementById('apply-mobile-filters');

    const desktopRadios = document.querySelectorAll('.status-radio');
    const mobileRadios = document.querySelectorAll('.status-radio-mobile');

    if (!openBtn || !menu || !overlay) return;

    let _filterLastFocus = null;

    // Éléments focusables dans le panneau
    function getFocusable() {
        return Array.from(menu.querySelectorAll(
            'button:not([disabled]), input:not([disabled]), [tabindex]:not([tabindex="-1"])'
        )).filter(el => el.offsetParent !== null);
    }

    // --- OUVERTURE ---
    const openMobileFilters = () => {
        _filterLastFocus = document.activeElement;

        overlay.classList.remove('hidden');
        setTimeout(() => {
            overlay.classList.replace('opacity-0', 'opacity-100');
            menu.classList.remove('translate-x-full');
            menu.setAttribute('aria-hidden', 'false');
            openBtn.setAttribute('aria-expanded', 'true');
            const first = getFocusable()[0];
            if (first) first.focus();
        }, 10);
        document.body.style.overflow = 'hidden';
    };

    // --- FERMETURE ---
    const closeMobileFilters = () => {
        menu.classList.add('translate-x-full');
        menu.setAttribute('aria-hidden', 'true');
        openBtn.setAttribute('aria-expanded', 'false');
        overlay.classList.replace('opacity-100', 'opacity-0');
        setTimeout(() => overlay.classList.add('hidden'), 500);
        document.body.style.overflow = '';
        if (_filterLastFocus) _filterLastFocus.focus();
    };

    // --- PIÈGE DE FOCUS + ÉCHAP ---
    menu.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeMobileFilters();
            return;
        }
        if (e.key === 'Tab') {
            const focusable = getFocusable();
            const first = focusable[0];
            const last = focusable[focusable.length - 1];
            if (e.shiftKey && document.activeElement === first) {
                e.preventDefault();
                last.focus();
            } else if (!e.shiftKey && document.activeElement === last) {
                e.preventDefault();
                first.focus();
            }
        }
    });

    // --- ACCORDÉONS ---
    menu.querySelectorAll('.mobile-accordion-header').forEach(btn => {
        btn.addEventListener('click', () => {
            const content = btn.nextElementSibling;
            const isOpen = !content.classList.contains('hidden');
            content.classList.toggle('hidden', isOpen);
            btn.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
            const arrow = btn.querySelector('svg');
            if (arrow) arrow.style.transform = isOpen ? '' : 'rotate(180deg)';
        });
    });

    // --- ÉCOUTEURS ---
    openBtn.addEventListener('click', openMobileFilters);
    closeBtn?.addEventListener('click', closeMobileFilters);
    overlay.addEventListener('click', closeMobileFilters);
    applyBtn?.addEventListener('click', closeMobileFilters);

    // --- SYNCHRONISATION RADIOS ---
    function syncStatusFilters(value) {
        desktopRadios.forEach(r => r.checked = (r.value === value));
        mobileRadios.forEach(r => r.checked = (r.value === value));
        const label = document.getElementById('current-status-label');
        if (label) {
            const textMap = { 'all': 'Statut : Toutes', '1': 'Statut : Acquises', '0': 'Statut : Manquantes' };
            label.textContent = textMap[value];
        }
    }

    mobileRadios.forEach(radio => {
        radio.addEventListener('change', (e) => syncStatusFilters(e.target.value));
    });
    desktopRadios.forEach(radio => {
        radio.addEventListener('change', (e) => syncStatusFilters(e.target.value));
    });
});
