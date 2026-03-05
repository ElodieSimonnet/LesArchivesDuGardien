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
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const type = this.dataset.type;
            const itemId = this.dataset.id;
            const csrfToken = this.dataset.csrf;

            
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
                if (data.status === 'error') {
                    showToast(data.message || 'Une erreur est survenue.');
                    return;
                }

                if (data.status === 'added') {
                    this.classList.add('is-favorite');
                    this.setAttribute('aria-pressed', 'true');
                    this.setAttribute('aria-label', this.getAttribute('aria-label').replace('Ajouter', 'Retirer').replace('aux favoris', 'des favoris'));
                } else if (data.status === 'removed') {
                    this.classList.remove('is-favorite');
                    this.setAttribute('aria-pressed', 'false');
                    this.setAttribute('aria-label', this.getAttribute('aria-label').replace('Retirer', 'Ajouter').replace('des favoris', 'aux favoris'));
                }
            })
            .catch(() => showToast('Une erreur réseau est survenue.'));
        });
    });
});
