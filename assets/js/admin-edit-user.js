document.getElementById('deleteAvatarForm')?.addEventListener('submit', (e) => {
    if (!confirm('Supprimer l\'avatar de cet utilisateur ?')) e.preventDefault();
});
