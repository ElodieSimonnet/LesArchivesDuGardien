document.addEventListener('DOMContentLoaded', () => {

    // --- SÉLECTEURS ---
    const activeFiltersContent = document.getElementById('active-filters-content');
    const checkboxes = document.querySelectorAll('.filter-checkbox');
    const statusRadios = document.querySelectorAll('.status-radio, .status-radio-mobile');
    const petItems = document.querySelectorAll('.pet-item');
    const clearAllBtn = document.getElementById('clear-all-filters');
    const statusLabel = document.getElementById('current-status-label');
    const dropdowns = document.querySelectorAll('.dropdown-container');
    const searchInput = document.getElementById('search-input');
    const loadMoreBtn = document.getElementById('load-more-btn');
    const loadMoreCount = document.getElementById('load-more-count');

    // --- PAGINATION "CHARGER PLUS" ---
    const ITEMS_PER_PAGE = 12;
    let currentLimit = ITEMS_PER_PAGE;

    // --- 1. GESTION DES MENUS DÉROULANTS (Desktop) ---
    dropdowns.forEach(container => {
        const btn = container.querySelector('.dropdown-button');
        const content = container.querySelector('.dropdown-content');
        const icon = btn?.querySelector('i');

        btn?.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdowns.forEach(other => {
                if (other !== container) {
                    other.querySelector('.dropdown-content').classList.add('hidden');
                    const otherIcon = other.querySelector('.dropdown-button i');
                    if (otherIcon) otherIcon.classList.remove('rotate-180');
                }
            });

            const isOpened = content.classList.toggle('hidden');
            if (icon) {
                isOpened ? icon.classList.remove('rotate-180') : icon.classList.add('rotate-180');
            }
        });

        content?.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    });

    document.addEventListener('click', () => {
        document.querySelectorAll('.dropdown-content').forEach(menu => menu.classList.add('hidden'));
        document.querySelectorAll('.dropdown-button i').forEach(i => i.classList.remove('rotate-180'));
    });

    // --- 2. SYSTÈME DE FILTRAGE GLOBAL ---
    function applyAllFilters() {
        const activeFilters = {};

        checkboxes.forEach(chk => {
            if (chk.checked) {
                const category = chk.dataset.filter;
                if (!activeFilters[category]) activeFilters[category] = [];
                activeFilters[category].push(chk.value);
            }
        });

        const activeRadio = document.querySelector('input[name="filter-status"]:checked, input[name="filter-status-mobile"]:checked');
        const statusValue = activeRadio ? activeRadio.value : 'all';

        statusRadios.forEach(radio => {
            if (radio.value === statusValue) radio.checked = true;
        });

        if (statusLabel) {
            const labels = { 'all': 'Statut : Toutes', '1': 'Statut : Acquises', '0': 'Statut : Manquantes' };
            statusLabel.innerText = labels[statusValue];
        }

        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';

        let matchCount = 0;
        petItems.forEach(item => {
            const card = item.querySelector('.pet-card');
            if (!card) return;

            const cardOwned = card.dataset.owned;
            const matchStatus = (statusValue === 'all') || (cardOwned === statusValue);

            let matchCategories = true;
            for (const category in activeFilters) {
                const cardValue = card.dataset[category];
                if (!activeFilters[category].includes(cardValue)) {
                    matchCategories = false;
                    break;
                }
            }

            const cardName = (card.querySelector('h2')?.textContent || '').trim().toLowerCase();
            const matchSearch = !searchTerm || cardName.startsWith(searchTerm);

            const matchAll = matchStatus && matchCategories && matchSearch;
            if (matchAll) {
                matchCount++;
                item.style.display = matchCount <= currentLimit ? 'flex' : 'none';
            } else {
                item.style.display = 'none';
            }
        });

        const shownCount = Math.min(matchCount, currentLimit);
        if (loadMoreCount) {
            loadMoreCount.textContent = `Vous avez vu ${shownCount} mascottes sur ${matchCount}`;
            loadMoreCount.style.display = matchCount > 0 ? '' : 'none';
        }
        if (loadMoreBtn) {
            loadMoreBtn.style.display = matchCount > currentLimit ? '' : 'none';
        }

        updateBadges(activeFilters, statusValue);
    }

    function resetAndApply() {
        currentLimit = ITEMS_PER_PAGE;
        applyAllFilters();
    }

    // --- 3. GESTION DES BADGES DYNAMIQUES ---
    function updateBadges(activeFilters, statusValue) {
        const container = document.getElementById('badges-dynamic-container');
        if (!container || !activeFiltersContent) return;

        container.innerHTML = '';
        let hasFilters = false;

        if (statusValue !== 'all') {
            hasFilters = true;
            const statusText = statusValue === '1' ? 'Acquises' : 'Manquantes';
            createBadge(container, 'Statut', statusText, () => {
                const allRadios = document.querySelectorAll('input[value="all"]');
                allRadios.forEach(r => r.checked = true);
                resetAndApply();
            });
        }

        for (const category in activeFilters) {
            activeFilters[category].forEach(value => {
                hasFilters = true;
                createBadge(container, category, value, () => {
                    const targetCheckboxes = document.querySelectorAll(`.filter-checkbox[data-filter="${category}"][value="${value}"]`);
                    targetCheckboxes.forEach(cb => cb.checked = false);
                    resetAndApply();
                });
            });
        }

        hasFilters ? activeFiltersContent.classList.remove('hidden') : activeFiltersContent.classList.add('hidden');
    }

    function createBadge(container, label, value, removeCallback) {
        const badge = document.createElement('div');
        badge.className = "flex items-center gap-2 bg-primary-orange/10 border border-primary-orange/40 px-3 py-1 rounded-full group hover:border-primary-orange transition-all";

        const span = document.createElement('span');
        span.className = "text-[10px] md:text-xs text-primary-white uppercase font-bold tracking-tight";
        span.textContent = `${label}: ${value}`;

        const button = document.createElement('button');
        button.className = "text-primary-orange hover:text-white transition-colors";
        const icon = document.createElement('i');
        icon.className = "ph-x-circle-bold text-lg";
        button.appendChild(icon);
        button.addEventListener('click', removeCallback);

        badge.appendChild(span);
        badge.appendChild(button);
        container.appendChild(badge);
    }

    // --- 4. ÉCOUTEURS ---
    checkboxes.forEach(box => box.addEventListener('change', resetAndApply));
    statusRadios.forEach(radio => radio.addEventListener('change', resetAndApply));

    if (clearAllBtn) {
        clearAllBtn.addEventListener('click', () => {
            checkboxes.forEach(chk => chk.checked = false);
            const allRadios = document.querySelectorAll('input[value="all"]');
            allRadios.forEach(r => r.checked = true);
            resetAndApply();
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', resetAndApply);
    }

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', () => {
            currentLimit += ITEMS_PER_PAGE;
            applyAllFilters();
        });
    }

    // --- 5. ACCORDÉONS MOBILE ---
    document.querySelectorAll('.mobile-accordion-header').forEach(header => {
        header.addEventListener('click', () => {
            const content = header.nextElementSibling;
            const svgIcon = header.querySelector('svg:not(.w-9)');

            const isOpening = content.classList.contains('hidden');
            content.classList.toggle('hidden');

            if (isOpening) {
                header.classList.add('active');
                if(svgIcon) svgIcon.style.transform = 'rotate(180deg)';
            } else {
                header.classList.remove('active');
                if(svgIcon) svgIcon.style.transform = 'rotate(0deg)';
            }
        });
    });

    // Lancement initial
    applyAllFilters();
});