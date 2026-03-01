document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('filter-mobile-overlay');
    const menu = document.getElementById('filter-mobile-menu');
    const openBtn = document.getElementById('open-filters-btn');
    const closeBtn = document.getElementById('close-filters');
    const filterForm = document.getElementById('filterForm');

    // Recherche en temps réel
    const searchInput = document.getElementById('search-mount');
    if (searchInput) {
        const rows = document.querySelectorAll('.mount-row');

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
            menu.setAttribute('aria-hidden', 'false');
            if (closeBtn) closeBtn.focus();
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
            menu.setAttribute('aria-hidden', 'true');
            openBtn.focus();
        }, 500);
    };

    // Focus trap
    menu.addEventListener('keydown', (e) => {
        if (e.key !== 'Tab' || overlay.classList.contains('hidden')) return;
        const focusable = Array.from(menu.querySelectorAll('button, input, [tabindex]:not([tabindex="-1"])'));
        const first = focusable[0];
        const last = focusable[focusable.length - 1];
        if (e.shiftKey) {
            if (document.activeElement === first) { e.preventDefault(); last.focus(); }
        } else {
            if (document.activeElement === last) { e.preventDefault(); first.focus(); }
        }
    });

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

        // Cocher/décocher toutes les checkboxes de la section
        selectAll.addEventListener('change', () => {
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
        });

        // Mettre à jour "Tout sélectionner" quand on coche/décoche individuellement
        checkboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                selectAll.checked = [...checkboxes].every(c => c.checked);
            });
        });

        // État initial au chargement
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

            // Regrouper les checkboxes par nom (type[], source[], etc.)
            const grouped = {};
            for (const [key, value] of formData.entries()) {
                if (!grouped[key]) grouped[key] = [];
                grouped[key].push(value);
            }

            // Construire les paramètres URL : type[]=Val1&type[]=Val2
            for (const [key, values] of Object.entries(grouped)) {
                for (const value of values) {
                    params.append(key, value);
                }
            }

            const query = params.toString();
            window.location.href = 'admin_mount_gestion.php' + (query ? '?' + query : '');
        });
    }
});
