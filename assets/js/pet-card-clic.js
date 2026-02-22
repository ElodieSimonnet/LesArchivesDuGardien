document.querySelectorAll('.pet-card').forEach(card => {
    // Clic souris
    card.addEventListener('click', (e) => {
        if (e.target.closest('.wishlist-btn')) return;
        const url = card.dataset.url;
        if (url) window.location.href = url;
    });

    // Navigation clavier : Entrée ou Espace activent la carte
    card.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            if (e.target.closest('.wishlist-btn')) return;
            const url = card.dataset.url;
            if (url) window.location.href = url;
        }
    });
});
