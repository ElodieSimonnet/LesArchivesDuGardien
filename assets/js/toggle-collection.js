function showToast(message, type = 'error') {
    const toast = document.createElement('div');
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.className = `fixed top-20 left-1/2 -translate-x-1/2 z-50 px-6 py-3 rounded-lg border text-sm font-bold uppercase text-center shadow-lg ${
        type === 'success'
            ? 'bg-green-500/20 border-green-500 text-green-400'
            : 'bg-red-500/20 border-red-500 text-red-400'
    }`;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.style.transition = 'opacity 0.5s';
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 500);
    }, 3000);
}

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

            fetch('actions/toggle_collection.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const label = this.querySelector('.collection-label');
                const icon = this.querySelector('.collection-icon');
                const path = icon ? icon.querySelector('path') : null;

                
                let card = this.closest('[data-owned]');
                if (!card) {
                    const sibling = this.previousElementSibling;
                    if (sibling && sibling.hasAttribute('data-owned')) card = sibling;
                }

                const lockBadge = card ? card.querySelector('.lock-badge') : null;

                if (data.status === 'error') {
                    showToast(data.message || 'Une erreur est survenue.');
                    return;
                }

                const wishlistBtn = this.closest('li')?.querySelector('.wishlist-btn')
                    ?? this.parentElement?.querySelector('.wishlist-btn');

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
                    if (wishlistBtn) wishlistBtn.classList.add('hidden');
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
                    if (wishlistBtn) wishlistBtn.classList.remove('hidden');
                }
            })
            .catch(() => showToast('Une erreur réseau est survenue.'));
        });
    });
});
