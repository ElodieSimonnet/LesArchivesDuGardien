document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.collection-toggle-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const type = this.dataset.type;
            const itemId = this.dataset.id;
            const csrfToken = this.dataset.csrf;

            const formData = new FormData();
            formData.append('type', type);
            formData.append('item_id', itemId);
            formData.append('csrf_token', csrfToken);

            fetch('components/utils/toggle_collection.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const label = this.querySelector('.collection-label');
                const icon = this.querySelector('.collection-icon');
                const path = icon ? icon.querySelector('path') : null;

                // Mettre à jour la carte (parente dans les listes, ou frère article dans les détails)
                let card = this.closest('[data-owned]');
                if (!card) {
                    const sibling = this.previousElementSibling;
                    if (sibling && sibling.tagName === 'ARTICLE') card = sibling;
                }

                const lockBadge = card ? card.querySelector('.lock-badge') : null;

                if (data.status === 'added') {
                    this.classList.add('is-owned', 'bg-primary-orange', 'text-primary-black');
                    this.classList.remove('text-primary-orange', 'hover:bg-primary-orange', 'hover:text-primary-black');
                    if (label) label.textContent = 'Obtenue';
                    if (path) path.setAttribute('d', 'M5 13l4 4L19 7');
                    if (card) {
                        card.dataset.owned = '1';
                        card.classList.remove('sepia', 'hover:sepia-0');
                    }
                    if (lockBadge) lockBadge.classList.add('hidden');
                } else if (data.status === 'removed') {
                    this.classList.remove('is-owned', 'bg-primary-orange', 'text-primary-black');
                    this.classList.add('text-primary-orange', 'hover:bg-primary-orange', 'hover:text-primary-black');
                    if (label) label.textContent = 'Ajouter à ma collection';
                    if (path) path.setAttribute('d', 'M12 4v16m8-8H4');
                    if (card) {
                        card.dataset.owned = '0';
                        card.classList.add('sepia', 'hover:sepia-0');
                    }
                    if (lockBadge) lockBadge.classList.remove('hidden');
                }
            });
        });
    });
});
