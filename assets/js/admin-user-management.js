document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', (e) => {
        if (!confirm('Supprimer cet utilisateur ?')) e.preventDefault();
    });
});
