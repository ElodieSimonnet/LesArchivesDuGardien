document.querySelectorAll('.mount-card').forEach(card => {
    card.addEventListener('click', (e) => {
        // Si le clic vient du bouton wishlist ou de n'importe quel élément à l'intérieur du bouton
        if (e.target.closest('.wishlist-btn')) {
            // On ne fait rien ici, le script wishlist-heart.js s'en occupe
            return; 
        }

        // Sinon, on redirige
        const url = card.dataset.url;
        if (url) window.location.href = url;
    });
});