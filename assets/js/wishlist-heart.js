// WISHLIST, FONCTIONNEMENT DES COEURS
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const type = this.dataset.type;
            const itemId = this.dataset.id;
            const csrfToken = this.dataset.csrf;

            // Si pas connecté (pas de data-type), toggle visuel uniquement
            if (!type) {
                this.classList.toggle('is-favorite');
                return;
            }

            const formData = new FormData();
            formData.append('type', type);
            formData.append('item_id', itemId);
            formData.append('csrf_token', csrfToken);

            fetch('components/utils/toggle_wishlist.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'added') {
                    this.classList.add('is-favorite');
                } else if (data.status === 'removed') {
                    this.classList.remove('is-favorite');
                }
            });
        });
    });
});
