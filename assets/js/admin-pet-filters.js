document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('filter-mobile-overlay');
    const menu = document.getElementById('filter-mobile-menu');
    const openBtn = document.getElementById('open-filters-btn');
    const closeBtn = document.getElementById('close-filters');
    const filterForm = document.getElementById('filterForm');

    // Recherche en temps réel
    const searchInput = document.getElementById('search-pet');
    if (searchInput) {
        const rows = document.querySelectorAll('.pet-row');

        searchInput.addEventListener('input', () => {
            const term = searchInput.value.toLowerCase().trim();

            rows.forEach(row => {
                const name = row.dataset.name || '';
                row.style.display = term.length < 2 || name.includes(term) ? '' : 'none';
            });
        });
    }

    if (!overlay || !menu || !openBtn) return;

    const openFilters = () => {
        overlay.classList.remove('hidden');
        setTimeout(() => {
            overlay.classList.add('opacity-100');
            menu.classList.remove('opacity-0', 'translate-y-8', 'pointer-events-none');
            menu.classList.add('opacity-100', 'translate-y-0');
        }, 10);
        document.body.style.overflow = 'hidden';
    };

    const closeFilters = () => {
        overlay.classList.remove('opacity-100');
        menu.classList.remove('opacity-100', 'translate-y-0');
        menu.classList.add('opacity-0', 'translate-y-8', 'pointer-events-none');
        setTimeout(() => {
            overlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 500);
    };

    openBtn.addEventListener('click', openFilters);
    if (closeBtn) closeBtn.addEventListener('click', closeFilters);
    overlay.addEventListener('click', closeFilters);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !overlay.classList.contains('hidden')) closeFilters();
    });

    // Gestion des "Tout sélectionner"
    document.querySelectorAll('.select-all').forEach(selectAll => {
        const section = selectAll.closest('.mobile-accordion-content');
        const checkboxes = section.querySelectorAll('.filter-checkbox');

        selectAll.addEventListener('change', () => {
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
        });

        checkboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                selectAll.checked = [...checkboxes].every(c => c.checked);
            });
        });

        selectAll.checked = checkboxes.length > 0 && [...checkboxes].every(c => c.checked);
    });

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

    if (filterForm) {
        filterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(filterForm);
            const params = new URLSearchParams();

            const grouped = {};
            for (const [key, value] of formData.entries()) {
                if (!grouped[key]) grouped[key] = [];
                grouped[key].push(value);
            }

            for (const [key, values] of Object.entries(grouped)) {
                for (const value of values) {
                    params.append(key, value);
                }
            }

            const query = params.toString();
            window.location.href = 'admin_pet_gestion.php' + (query ? '?' + query : '');
        });
    }
});
