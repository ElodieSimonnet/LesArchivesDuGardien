document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('filter-mobile-overlay');
    const menu = document.getElementById('filter-mobile-menu');
    const openBtn = document.getElementById('open-filters-btn');
    const closeBtn = document.getElementById('close-filters');
    const filterForm = document.getElementById('filterForm');

    if (!overlay || !menu || !openBtn) return;

    const openFilters = () => {
        // 1. On affiche le conteneur
        overlay.classList.remove('hidden');
        
        setTimeout(() => {
            // 2. On anime l'apparition : opaque + remonte à sa place + devient cliquable
            overlay.classList.add('opacity-100');
            menu.classList.remove('opacity-0', 'translate-y-8', 'pointer-events-none');
            menu.classList.add('opacity-100', 'translate-y-0');
        }, 10);

        document.body.style.overflow = 'hidden';
    };

    const closeFilters = () => {
        // 1. On anime la disparition
        overlay.classList.remove('opacity-100');
        menu.classList.remove('opacity-100', 'translate-y-0');
        menu.classList.add('opacity-0', 'translate-y-8', 'pointer-events-none');

        setTimeout(() => {
            // 2. On cache tout après l'anim
            overlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 500);
    };

    // Listeners
    openBtn.addEventListener('click', openFilters);
    if (closeBtn) closeBtn.addEventListener('click', closeFilters);
    overlay.addEventListener('click', closeFilters);

    // Echap
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !overlay.classList.contains('hidden')) closeFilters();
    });

    // Accordéons (inchangé)
    document.querySelectorAll('.mobile-accordion-header').forEach(header => {
        header.addEventListener('click', () => {
            const content = header.nextElementSibling;
            const svg = header.querySelector('svg');
            if (!content || !svg) return;
            const isHidden = content.classList.contains('hidden');
            document.querySelectorAll('.mobile-accordion-content').forEach(c => c.classList.add('hidden'));
            document.querySelectorAll('.mobile-accordion-header svg').forEach(s => s.classList.remove('rotate-180'));
            if (isHidden) {
                content.classList.remove('hidden');
                svg.classList.add('rotate-180');
            }
        });
    });

    // Submit
    if (filterForm) {
        filterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            console.log("Filtres appliqués !");
            closeFilters();
            // Ici tu pourras ajouter ta redirection PHP ou AJAX
        });
    }
});