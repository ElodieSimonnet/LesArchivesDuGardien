document.querySelectorAll('.pet-card').forEach(card => {
    card.addEventListener('click', (e) => {
        if (e.target.closest('.wishlist-btn')) {
            return;
        }

        const url = card.dataset.url;
        if (url) window.location.href = url;
    });
});
