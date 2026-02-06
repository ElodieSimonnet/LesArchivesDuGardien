document.addEventListener('DOMContentLoaded', () => {

    // --- SÉLECTEURS ---
    const activeFiltersZone = document.getElementById('active-filters-zone');
    const checkboxes = document.querySelectorAll('.filter-checkbox');
    // On récupère les radios Desktop ET Mobile
    const statusRadios = document.querySelectorAll('.status-radio, .status-radio-mobile');
    const mountItems = document.querySelectorAll('.mount-item');
    const clearAllBtn = document.getElementById('clear-all-filters');
    const statusLabel = document.getElementById('current-status-label');
    const dropdowns = document.querySelectorAll('.dropdown-container');

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
    });

    document.addEventListener('click', () => {
        document.querySelectorAll('.dropdown-content').forEach(menu => menu.classList.add('hidden'));
        document.querySelectorAll('.dropdown-button i').forEach(i => i.classList.remove('rotate-180'));
    });

    // --- 2. SYSTÈME DE FILTRAGE GLOBAL ---
    function applyAllFilters() {
        const activeFilters = {};
        
        // A. Récupérer les catégories (Type, Source, etc.)
        checkboxes.forEach(chk => {
            if (chk.checked) {
                const category = chk.dataset.filter;
                if (!activeFilters[category]) activeFilters[category] = [];
                activeFilters[category].push(chk.value);
            }
        });

        // B. Récupérer le statut (Synchronisé Desktop/Mobile)
        const activeRadio = document.querySelector('input[name="filter-status"]:checked, input[name="filter-status-mobile"]:checked');
        const statusValue = activeRadio ? activeRadio.value : 'all';
        
        // Synchro visuelle des radios
        statusRadios.forEach(radio => {
            if (radio.value === statusValue) radio.checked = true;
        });

        // Mise à jour du texte label Desktop
        if (statusLabel) {
            const labels = { 'all': 'Statut : Toutes', '1': 'Statut : Acquises', '0': 'Statut : Manquantes' };
            statusLabel.innerText = labels[statusValue];
        }

        // C. Filtrage des montures
        mountItems.forEach(item => {
            const card = item.querySelector('.mount-card');
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

            item.style.display = (matchStatus && matchCategories) ? 'flex' : 'none';
        });

        updateBadges(activeFilters, statusValue);
    }

    // --- 3. GESTION DES BADGES DYNAMIQUES ---
    function updateBadges(activeFilters, statusValue) {
        const container = document.getElementById('badges-dynamic-container');
        if (!container || !activeFiltersZone) return;

        container.innerHTML = '';
        let hasFilters = false;

        // Ajouter le badge pour le Statut (sauf si "Toutes")
        if (statusValue !== 'all') {
            hasFilters = true;
            const statusText = statusValue === '1' ? 'Acquises' : 'Manquantes';
            createBadge(container, 'Statut', statusText, () => {
                const allRadios = document.querySelectorAll('input[value="all"]');
                allRadios.forEach(r => r.checked = true);
                applyAllFilters();
            });
        }

        // Ajouter les badges pour les catégories
        for (const category in activeFilters) {
            activeFilters[category].forEach(value => {
                hasFilters = true;
                createBadge(container, category, value, () => {
                    const targetCheckboxes = document.querySelectorAll(`.filter-checkbox[data-filter="${category}"][value="${value}"]`);
                    targetCheckboxes.forEach(cb => cb.checked = false);
                    applyAllFilters();
                });
            });
        }
        
        activeFiltersZone.style.display = hasFilters ? 'block' : 'none';
    }

    function createBadge(container, label, value, removeCallback) {
        const badge = document.createElement('div');
        badge.className = "flex items-center gap-2 bg-primary-orange/10 border border-primary-orange/40 px-3 py-1 rounded-full group hover:border-primary-orange transition-all";
        badge.innerHTML = `
            <span class="text-[10px] md:text-xs text-primary-white uppercase font-bold tracking-tight">${label}: ${value}</span>
            <button class="text-primary-orange hover:text-white transition-colors">
                <i class="ph-x-circle-bold text-lg"></i>
            </button>
        `;
        badge.querySelector('button').addEventListener('click', removeCallback);
        container.appendChild(badge);
    }

    // --- 4. ÉCOUTEURS ---
    checkboxes.forEach(box => box.addEventListener('change', applyAllFilters));
    statusRadios.forEach(radio => radio.addEventListener('change', applyAllFilters));

    if (clearAllBtn) {
        clearAllBtn.addEventListener('click', () => {
            checkboxes.forEach(chk => chk.checked = false);
            const allRadios = document.querySelectorAll('input[value="all"]');
            allRadios.forEach(r => r.checked = true);
            applyAllFilters();
        });
    }

    // --- 5. ACCORDÉONS MOBILE ---
document.querySelectorAll('.mobile-accordion-header').forEach(header => {
    header.addEventListener('click', () => {
        const content = header.nextElementSibling;
        const svgIcon = header.querySelector('svg:not(.w-9)'); // On ignore la croix de fermeture
        
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